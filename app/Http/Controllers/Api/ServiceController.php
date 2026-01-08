<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Service::with('schedules');

        // Search by name or description
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        // Filter only active services by default for n8n integrations
        if (!$request->has('is_active') && $request->boolean('only_active', false)) {
            $query->active();
        }

        // Pagination
        $perPage = $request->input('per_page', 15);
        $services = $query->orderBy('name', 'asc')->paginate($perPage);

        // Transform data for API response
        $data = $services->map(function ($service) {
            return $this->formatServiceResponse($service);
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'current_page' => $services->currentPage(),
                'last_page' => $services->lastPage(),
                'per_page' => $services->perPage(),
                'total' => $services->total(),
            ],
        ]);
    }

    /**
     * Store a newly created service.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:5', 'max:480'],
            'color' => ['nullable', 'string', 'size:7', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'is_active' => ['nullable', 'boolean'],
            'schedules' => ['required', 'array', 'min:1'],
            'schedules.*.day_of_week' => ['required', 'integer', 'between:0,6'],
            'schedules.*.start_time' => ['required', 'date_format:H:i'],
            'schedules.*.end_time' => ['required', 'date_format:H:i', 'after:schedules.*.start_time'],
            'schedules.*.is_active' => ['nullable', 'boolean'],
        ]);

        DB::beginTransaction();

        try {
            $service = Service::create([
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'duration' => $validated['duration'],
                'color' => $validated['color'] ?? '#6366F1',
                'is_active' => $validated['is_active'] ?? true,
            ]);

            foreach ($validated['schedules'] as $scheduleData) {
                $service->schedules()->create([
                    'day_of_week' => $scheduleData['day_of_week'],
                    'start_time' => $scheduleData['start_time'],
                    'end_time' => $scheduleData['end_time'],
                    'is_active' => $scheduleData['is_active'] ?? true,
                ]);
            }

            DB::commit();

            $service->load('schedules');

            return response()->json([
                'success' => true,
                'message' => 'Serviço cadastrado com sucesso!',
                'data' => $this->formatServiceResponse($service),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar serviço.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified service.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Service $service)
    {
        $service->load('schedules');

        return response()->json([
            'success' => true,
            'data' => $this->formatServiceResponse($service, true),
        ]);
    }

    /**
     * Get available time slots for a service on a specific date
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function availableSlots(Request $request, Service $service)
    {
        $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $date = \Carbon\Carbon::parse($request->date);
        $dayOfWeek = $date->dayOfWeek;

        $service->load('schedules');

        if (!$service->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Serviço não está disponível.',
            ], 400);
        }

        $slots = $service->getTimeSlotsForDay($dayOfWeek);

        if (empty($slots)) {
            return response()->json([
                'success' => true,
                'message' => 'Serviço não disponível neste dia.',
                'data' => [
                    'date' => $date->format('Y-m-d'),
                    'day_of_week' => $dayOfWeek,
                    'day_name' => Service::DAYS_OF_WEEK[$dayOfWeek],
                    'available' => false,
                    'slots' => [],
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'date' => $date->format('Y-m-d'),
                'day_of_week' => $dayOfWeek,
                'day_name' => Service::DAYS_OF_WEEK[$dayOfWeek],
                'available' => true,
                'slots' => $slots,
                'slots_count' => count($slots),
            ],
        ]);
    }

    /**
     * Get all available slots for a service (weekly view)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function weeklySlots(Service $service)
    {
        $service->load('schedules');

        if (!$service->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Serviço não está disponível.',
            ], 400);
        }

        $allSlots = $service->getAllTimeSlots();

        return response()->json([
            'success' => true,
            'data' => [
                'service_id' => $service->id,
                'service_name' => $service->name,
                'duration' => $service->duration,
                'duration_formatted' => $service->formatted_duration,
                'price' => $service->price,
                'price_formatted' => $service->formatted_price,
                'weekly_schedule' => $allSlots,
            ],
        ]);
    }

    /**
     * Update the specified service.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'duration' => ['sometimes', 'integer', 'min:5', 'max:480'],
            'color' => ['nullable', 'string', 'size:7', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'is_active' => ['nullable', 'boolean'],
            'schedules' => ['sometimes', 'array', 'min:1'],
            'schedules.*.day_of_week' => ['required_with:schedules', 'integer', 'between:0,6'],
            'schedules.*.start_time' => ['required_with:schedules', 'date_format:H:i'],
            'schedules.*.end_time' => ['required_with:schedules', 'date_format:H:i', 'after:schedules.*.start_time'],
            'schedules.*.is_active' => ['nullable', 'boolean'],
        ]);

        DB::beginTransaction();

        try {
            $updateData = array_filter([
                'name' => $validated['name'] ?? null,
                'description' => array_key_exists('description', $validated) ? $validated['description'] : null,
                'price' => $validated['price'] ?? null,
                'duration' => $validated['duration'] ?? null,
                'color' => $validated['color'] ?? null,
                'is_active' => $validated['is_active'] ?? null,
            ], fn($value) => $value !== null);

            if (!empty($updateData)) {
                $service->update($updateData);
            }

            if (isset($validated['schedules'])) {
                $service->schedules()->delete();

                foreach ($validated['schedules'] as $scheduleData) {
                    $service->schedules()->create([
                        'day_of_week' => $scheduleData['day_of_week'],
                        'start_time' => $scheduleData['start_time'],
                        'end_time' => $scheduleData['end_time'],
                        'is_active' => $scheduleData['is_active'] ?? true,
                    ]);
                }
            }

            DB::commit();

            $service->load('schedules');

            return response()->json([
                'success' => true,
                'message' => 'Serviço atualizado com sucesso!',
                'data' => $this->formatServiceResponse($service),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar serviço.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified service.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Serviço excluído com sucesso!',
        ]);
    }

    /**
     * Get service statistics.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics()
    {
        $stats = [
            'total' => Service::count(),
            'active' => Service::where('is_active', true)->count(),
            'inactive' => Service::where('is_active', false)->count(),
            'average_price' => round(Service::avg('price') ?? 0, 2),
            'average_duration' => round(Service::avg('duration') ?? 0),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * List active services for public/n8n use
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function listActive()
    {
        $services = Service::with('schedules')
            ->active()
            ->orderBy('name')
            ->get()
            ->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'description' => $service->description,
                    'price' => $service->price,
                    'price_formatted' => $service->formatted_price,
                    'duration' => $service->duration,
                    'duration_formatted' => $service->formatted_duration,
                    'color' => $service->color,
                    'working_days' => $service->working_days_names,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $services,
            'count' => $services->count(),
        ]);
    }

    /**
     * Format service for API response
     */
    private function formatServiceResponse(Service $service, bool $includeSlots = false): array
    {
        $data = [
            'id' => $service->id,
            'name' => $service->name,
            'description' => $service->description,
            'price' => $service->price,
            'price_formatted' => $service->formatted_price,
            'duration' => $service->duration,
            'duration_formatted' => $service->formatted_duration,
            'color' => $service->color,
            'is_active' => $service->is_active,
            'working_days' => $service->working_days,
            'working_days_names' => $service->working_days_names,
            'schedules' => $service->schedules->map(function ($schedule) {
                return [
                    'day_of_week' => $schedule->day_of_week,
                    'day_name' => $schedule->day_name,
                    'short_day_name' => $schedule->short_day_name,
                    'start_time' => $schedule->formatted_start_time,
                    'end_time' => $schedule->formatted_end_time,
                    'time_range' => $schedule->time_range,
                    'is_active' => $schedule->is_active,
                    'slots' => $schedule->getAvailableSlots(),
                    'slots_count' => $schedule->slots_count,
                ];
            }),
            'created_at' => $service->created_at->toIso8601String(),
            'updated_at' => $service->updated_at->toIso8601String(),
        ];

        if ($includeSlots) {
            $data['all_time_slots'] = $service->getAllTimeSlots();
        }

        return $data;
    }
}

