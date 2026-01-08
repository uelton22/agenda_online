<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProfessionalController extends Controller
{
    /**
     * List all professionals with filters.
     */
    public function index(Request $request)
    {
        $query = Professional::with('services:id,name,color');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('specialty', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Filter by service
        if ($request->filled('service_id')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('services.id', $request->service_id);
            });
        }

        $perPage = $request->input('per_page', 15);
        $professionals = $query->orderBy('name')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $professionals->map(fn($p) => $this->formatProfessional($p)),
            'meta' => [
                'current_page' => $professionals->currentPage(),
                'last_page' => $professionals->lastPage(),
                'per_page' => $professionals->perPage(),
                'total' => $professionals->total(),
            ],
        ]);
    }

    /**
     * List active professionals.
     */
    public function listActive(Request $request)
    {
        $query = Professional::active()->with('services:id,name,color');

        // Filter by service
        if ($request->filled('service_id')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('services.id', $request->service_id);
            });
        }

        $professionals = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $professionals->map(fn($p) => $this->formatProfessional($p)),
            'count' => $professionals->count(),
        ]);
    }

    /**
     * Store a new professional.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:professionals,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'color' => ['nullable', 'string', 'size:7', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'is_active' => ['boolean'],
            'services' => ['nullable', 'array'],
            'services.*' => ['exists:services,id'],
        ]);

        $professional = Professional::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'specialty' => $validated['specialty'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'color' => $validated['color'] ?? '#6366f1',
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Attach services
        if (!empty($validated['services'])) {
            $professional->services()->attach($validated['services']);
        }

        $professional->load('services:id,name,color');

        return response()->json([
            'success' => true,
            'message' => 'Profissional criado com sucesso!',
            'data' => $this->formatProfessional($professional, true),
        ], 201);
    }

    /**
     * Show a specific professional.
     */
    public function show(Professional $professional)
    {
        $professional->load('services');

        return response()->json([
            'success' => true,
            'data' => $this->formatProfessional($professional, true),
        ]);
    }

    /**
     * Update a professional.
     */
    public function update(Request $request, Professional $professional)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'unique:professionals,email,' . $professional->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'color' => ['nullable', 'string', 'size:7', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'is_active' => ['boolean'],
            'services' => ['nullable', 'array'],
            'services.*' => ['exists:services,id'],
        ]);

        $professional->update($validated);

        // Sync services if provided
        if (isset($validated['services'])) {
            $professional->services()->sync($validated['services']);
        }

        $professional->load('services:id,name,color');

        return response()->json([
            'success' => true,
            'message' => 'Profissional atualizado com sucesso!',
            'data' => $this->formatProfessional($professional, true),
        ]);
    }

    /**
     * Delete a professional.
     */
    public function destroy(Professional $professional)
    {
        // Check if professional has appointments
        $appointmentsCount = $professional->appointments()->count();
        if ($appointmentsCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Este profissional possui {$appointmentsCount} agendamento(s) e não pode ser excluído.",
            ], 422);
        }

        $professional->delete();

        return response()->json([
            'success' => true,
            'message' => 'Profissional excluído com sucesso!',
        ]);
    }

    /**
     * Get services for a professional.
     */
    public function services(Professional $professional)
    {
        $services = $professional->services()->where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'professional' => [
                'id' => $professional->id,
                'name' => $professional->name,
            ],
            'services' => $services->map(fn($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'price' => $s->price,
                'duration' => $s->duration,
                'color' => $s->color,
                'pivot_price' => $s->pivot->price,
                'pivot_duration' => $s->pivot->duration,
            ]),
            'count' => $services->count(),
        ]);
    }

    /**
     * Get available slots for a professional on a specific date and service.
     */
    public function availableSlots(Request $request, Professional $professional)
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $service = Service::with('schedules')->findOrFail($validated['service_id']);
        $date = Carbon::parse($validated['date']);
        $dayOfWeek = $date->dayOfWeek;

        // Check if professional offers this service
        if (!$professional->services()->where('services.id', $service->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Este profissional não realiza este serviço.',
            ], 422);
        }

        // Get the schedule for this day
        $schedule = $service->schedules->firstWhere('day_of_week', $dayOfWeek);

        if (!$schedule || !$schedule->is_active) {
            return response()->json([
                'success' => true,
                'available' => false,
                'message' => 'Serviço não disponível neste dia.',
                'data' => [
                    'date' => $date->format('Y-m-d'),
                    'day_of_week' => $dayOfWeek,
                    'day_name' => Service::DAYS_OF_WEEK[$dayOfWeek],
                    'slots' => [],
                ],
            ]);
        }

        // Get all possible slots for this schedule
        $allSlots = $schedule->getAvailableSlots();

        // Get professional's duration for this service (or service default)
        $duration = $professional->getDurationForService($service);

        // Get booked slots for this professional on this date
        $bookedSlots = Appointment::where('professional_id', $professional->id)
            ->where('scheduled_date', $date->format('Y-m-d'))
            ->whereNotIn('status', ['cancelled'])
            ->pluck('scheduled_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        // Filter available slots
        $availableSlots = array_values(array_filter($allSlots, function ($slot) use ($bookedSlots) {
            return !in_array($slot, $bookedSlots);
        }));

        return response()->json([
            'success' => true,
            'available' => true,
            'data' => [
                'professional' => [
                    'id' => $professional->id,
                    'name' => $professional->name,
                ],
                'service' => [
                    'id' => $service->id,
                    'name' => $service->name,
                ],
                'date' => $date->format('Y-m-d'),
                'day_of_week' => $dayOfWeek,
                'day_name' => Service::DAYS_OF_WEEK[$dayOfWeek],
                'duration' => $duration,
                'price' => $professional->getPriceForService($service),
                'all_slots' => $allSlots,
                'booked_slots' => $bookedSlots,
                'available_slots' => $availableSlots,
                'available_count' => count($availableSlots),
            ],
        ]);
    }

    /**
     * Get professionals available for a service at a specific date and time.
     */
    public function availableForSlot(Request $request)
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i'],
        ]);

        $service = Service::with('professionals')->findOrFail($validated['service_id']);
        $date = $validated['date'];
        $time = $validated['time'];

        $availableProfessionals = [];

        foreach ($service->professionals()->active()->get() as $professional) {
            if (Appointment::isSlotAvailable($service->id, $date, $time, $professional->id)) {
                $availableProfessionals[] = $this->formatProfessional($professional);
            }
        }

        return response()->json([
            'success' => true,
            'service' => [
                'id' => $service->id,
                'name' => $service->name,
            ],
            'date' => $date,
            'time' => $time,
            'professionals' => $availableProfessionals,
            'count' => count($availableProfessionals),
        ]);
    }

    /**
     * Get statistics.
     */
    public function statistics()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalProfessionals = Professional::count();
        $activeProfessionals = Professional::active()->count();
        $inactiveProfessionals = $totalProfessionals - $activeProfessionals;

        // Top professionals by appointments this month
        $topProfessionals = Professional::withCount(['appointments' => function ($q) use ($startOfMonth, $endOfMonth) {
            $q->whereBetween('scheduled_date', [$startOfMonth, $endOfMonth])
                ->whereNotIn('status', ['cancelled']);
        }])
        ->orderBy('appointments_count', 'desc')
        ->take(5)
        ->get()
        ->map(fn($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'specialty' => $p->specialty,
            'color' => $p->color,
            'appointments_count' => $p->appointments_count,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $totalProfessionals,
                'active' => $activeProfessionals,
                'inactive' => $inactiveProfessionals,
                'top_professionals' => $topProfessionals,
            ],
        ]);
    }

    /**
     * Format professional for API response.
     */
    private function formatProfessional(Professional $professional, bool $detailed = false): array
    {
        $data = [
            'id' => $professional->id,
            'name' => $professional->name,
            'email' => $professional->email,
            'phone' => $professional->phone,
            'specialty' => $professional->specialty,
            'color' => $professional->color,
            'avatar_url' => $professional->avatar_url,
            'is_active' => $professional->is_active,
            'services_count' => $professional->services->count(),
        ];

        if ($detailed) {
            $data['bio'] = $professional->bio;
            $data['services'] = $professional->services->map(fn($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'price' => $s->price,
                'duration' => $s->duration,
                'color' => $s->color,
            ]);
            $data['today_appointments'] = $professional->today_appointments_count;
            $data['total_appointments'] = $professional->total_appointments_count;
            $data['created_at'] = $professional->created_at->format('Y-m-d H:i:s');
            $data['updated_at'] = $professional->updated_at->format('Y-m-d H:i:s');
        }

        return $data;
    }
}

