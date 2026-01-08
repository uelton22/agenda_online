<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Professional;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * List all appointments with filters.
     */
    public function index(Request $request)
    {
        $query = Appointment::with([
            'client:id,name,cpf,email,phone', 
            'service:id,name,price,duration,color',
            'professional:id,name,email,phone,specialty,color'
        ]);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->filled('professional_id')) {
            $query->where('professional_id', $request->professional_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('scheduled_date', $request->date);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('scheduled_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('scheduled_date', '<=', $request->date_to);
        }

        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->today();
                    break;
                case 'week':
                    $query->thisWeek();
                    break;
                case 'month':
                    $query->thisMonth();
                    break;
                case 'upcoming':
                    $query->upcoming();
                    break;
            }
        }

        $perPage = $request->input('per_page', 15);
        $appointments = $query->orderBy('scheduled_date', 'desc')
                              ->orderBy('scheduled_time', 'desc')
                              ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $appointments->map(fn($a) => $this->formatAppointment($a)),
            'meta' => [
                'current_page' => $appointments->currentPage(),
                'last_page' => $appointments->lastPage(),
                'per_page' => $appointments->perPage(),
                'total' => $appointments->total(),
            ],
        ]);
    }

    /**
     * Store a new appointment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'service_id' => ['required', 'exists:services,id'],
            'professional_id' => ['nullable', 'exists:professionals,id'],
            'scheduled_date' => ['required', 'date', 'after_or_equal:today'],
            'scheduled_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $professionalId = $validated['professional_id'] ?? null;

        // Calculate end time
        $startTime = Carbon::parse($validated['scheduled_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        // Check availability (considering professional)
        if (!Appointment::isSlotAvailable($service->id, $validated['scheduled_date'], $validated['scheduled_time'], $professionalId)) {
            return response()->json([
                'success' => false,
                'message' => 'Este horário não está disponível para este profissional.',
            ], 422);
        }

        $appointment = Appointment::create([
            'client_id' => $validated['client_id'],
            'service_id' => $validated['service_id'],
            'professional_id' => $professionalId,
            'user_id' => Auth::id(),
            'scheduled_date' => $validated['scheduled_date'],
            'scheduled_time' => $validated['scheduled_time'],
            'end_time' => $endTime->format('H:i'),
            'price' => $service->price,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        $appointment->load(['client', 'service', 'professional']);

        return response()->json([
            'success' => true,
            'message' => 'Agendamento criado com sucesso!',
            'data' => $this->formatAppointment($appointment),
        ], 201);
    }

    /**
     * Show a specific appointment.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['client', 'service', 'professional', 'user']);

        return response()->json([
            'success' => true,
            'data' => $this->formatAppointment($appointment, true),
        ]);
    }

    /**
     * Update an appointment.
     */
    public function update(Request $request, Appointment $appointment)
    {
        if (!$appointment->canBeEdited()) {
            return response()->json([
                'success' => false,
                'message' => 'Este agendamento não pode ser editado.',
            ], 422);
        }

        $validated = $request->validate([
            'client_id' => ['sometimes', 'exists:clients,id'],
            'service_id' => ['sometimes', 'exists:services,id'],
            'professional_id' => ['nullable', 'exists:professionals,id'],
            'scheduled_date' => ['sometimes', 'date'],
            'scheduled_time' => ['sometimes', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $serviceId = $validated['service_id'] ?? $appointment->service_id;
        $service = Service::findOrFail($serviceId);
        $professionalId = $validated['professional_id'] ?? $appointment->professional_id;

        // If date or time changed, recalculate end time and check availability
        if (isset($validated['scheduled_date']) || isset($validated['scheduled_time']) || isset($validated['professional_id'])) {
            $date = $validated['scheduled_date'] ?? $appointment->scheduled_date->format('Y-m-d');
            $time = $validated['scheduled_time'] ?? $appointment->formatted_time;

            $startTime = Carbon::parse($time);
            $endTime = $startTime->copy()->addMinutes($service->duration);

            if (!Appointment::isSlotAvailable($serviceId, $date, $time, $professionalId, $appointment->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este horário não está disponível para este profissional.',
                ], 422);
            }

            $validated['end_time'] = $endTime->format('H:i');
        }

        // Update price if service changed
        if (isset($validated['service_id'])) {
            $validated['price'] = $service->price;
        }

        $appointment->update($validated);
        $appointment->load(['client', 'service', 'professional']);

        return response()->json([
            'success' => true,
            'message' => 'Agendamento atualizado com sucesso!',
            'data' => $this->formatAppointment($appointment),
        ]);
    }

    /**
     * Cancel an appointment.
     */
    public function cancel(Request $request, Appointment $appointment)
    {
        if (!$appointment->canBeCancelled()) {
            return response()->json([
                'success' => false,
                'message' => 'Este agendamento não pode ser cancelado.',
            ], 422);
        }

        $validated = $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $appointment->cancel($validated['reason'] ?? null);

        return response()->json([
            'success' => true,
            'message' => 'Agendamento cancelado com sucesso!',
            'data' => $this->formatAppointment($appointment),
        ]);
    }

    /**
     * Update appointment status.
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled,no_show'],
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        switch ($validated['status']) {
            case 'confirmed':
                $appointment->confirm();
                break;
            case 'completed':
                $appointment->complete();
                break;
            case 'cancelled':
                $appointment->cancel($validated['cancellation_reason'] ?? null);
                break;
            case 'no_show':
                $appointment->markAsNoShow();
                break;
            default:
                $appointment->update(['status' => $validated['status']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status atualizado com sucesso!',
            'data' => $this->formatAppointment($appointment),
        ]);
    }

    /**
     * Delete an appointment.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Agendamento removido com sucesso!',
        ]);
    }

    /**
     * Get available slots for a service on a specific date.
     */
    public function availableSlots(Request $request)
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'professional_id' => ['nullable', 'exists:professionals,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $service = Service::with(['schedules', 'professionals'])->findOrFail($validated['service_id']);
        $professionalId = $validated['professional_id'] ?? null;
        $date = Carbon::parse($validated['date']);
        $dayOfWeek = $date->dayOfWeek;

        // Check if service is available on this day
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

        // Get all possible slots
        $allSlots = $schedule->getAvailableSlots();

        // Get booked slots
        $bookedQuery = Appointment::where('scheduled_date', $date->format('Y-m-d'))
            ->whereNotIn('status', ['cancelled']);

        // Filter by professional if specified
        if ($professionalId) {
            $bookedQuery->where('professional_id', $professionalId);
        } else {
            $bookedQuery->where('service_id', $service->id);
        }

        $bookedSlots = $bookedQuery->pluck('scheduled_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        // Filter available slots
        $availableSlots = array_values(array_filter($allSlots, function ($slot) use ($bookedSlots) {
            return !in_array($slot, $bookedSlots);
        }));

        // Get available professionals for each slot
        $professionalsPerSlot = [];
        if (!$professionalId && $service->professionals->count() > 0) {
            foreach ($availableSlots as $slot) {
                $availableProfessionals = Appointment::getAvailableProfessionalsForSlot(
                    $service->id,
                    $date->format('Y-m-d'),
                    $slot
                );
                $professionalsPerSlot[$slot] = array_map(fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'color' => $p->color
                ], $availableProfessionals);
            }
        }

        return response()->json([
            'success' => true,
            'available' => true,
            'data' => [
                'date' => $date->format('Y-m-d'),
                'day_of_week' => $dayOfWeek,
                'day_name' => Service::DAYS_OF_WEEK[$dayOfWeek],
                'service_id' => $service->id,
                'service_name' => $service->name,
                'duration' => $service->duration,
                'price' => $service->price,
                'professionals' => $service->professionals->where('is_active', true)->map(fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'color' => $p->color,
                    'specialty' => $p->specialty,
                ])->values(),
                'all_slots' => $allSlots,
                'booked_slots' => $bookedSlots,
                'available_slots' => $availableSlots,
                'available_count' => count($availableSlots),
                'professionals_per_slot' => $professionalsPerSlot,
            ],
        ]);
    }

    /**
     * Get appointments by client CPF (for n8n integration).
     */
    public function byClientCpf(Request $request, string $cpf)
    {
        $client = Client::where('cpf', $cpf)->first();

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente não encontrado.',
            ], 404);
        }

        $query = $client->appointments()->with(['service:id,name,price,duration,color']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('upcoming') && $request->upcoming) {
            $query->upcoming();
        }

        $appointments = $query->orderBy('scheduled_date', 'desc')
                              ->orderBy('scheduled_time', 'desc')
                              ->get();

        return response()->json([
            'success' => true,
            'client' => [
                'id' => $client->id,
                'name' => $client->full_name,
                'cpf' => $client->cpf,
                'email' => $client->email,
                'phone' => $client->phone,
            ],
            'appointments' => $appointments->map(fn($a) => $this->formatAppointment($a)),
            'count' => $appointments->count(),
        ]);
    }

    /**
     * Get today's appointments.
     */
    public function today()
    {
        $appointments = Appointment::with(['client:id,name,phone', 'service:id,name,color', 'professional:id,name,color'])
            ->today()
            ->orderBy('scheduled_time')
            ->get();

        return response()->json([
            'success' => true,
            'date' => Carbon::today()->format('Y-m-d'),
            'date_formatted' => Carbon::today()->format('d/m/Y'),
            'data' => $appointments->map(fn($a) => $this->formatAppointment($a)),
            'count' => $appointments->count(),
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

        // Revenue calculations
        $totalRevenue = Appointment::completed()->sum('price');
        $monthRevenue = Appointment::completed()
            ->whereBetween('scheduled_date', [$startOfMonth, $endOfMonth])
            ->sum('price');
        $todayRevenue = Appointment::completed()
            ->whereDate('scheduled_date', $today)
            ->sum('price');

        // Appointment counts
        $totalAppointments = Appointment::count();
        $monthAppointments = Appointment::whereBetween('scheduled_date', [$startOfMonth, $endOfMonth])->count();
        $todayAppointments = Appointment::today()->count();
        $pendingAppointments = Appointment::pending()->count();
        $confirmedAppointments = Appointment::confirmed()->count();

        // Status breakdown
        $statusBreakdown = [];
        foreach (Appointment::STATUSES as $status => $label) {
            $statusBreakdown[$status] = [
                'label' => $label,
                'count' => Appointment::where('status', $status)->count(),
                'month_count' => Appointment::where('status', $status)
                    ->whereBetween('scheduled_date', [$startOfMonth, $endOfMonth])
                    ->count(),
            ];
        }

        // Popular services
        $popularServices = Service::withCount(['appointments' => function ($q) use ($startOfMonth, $endOfMonth) {
            $q->whereBetween('scheduled_date', [$startOfMonth, $endOfMonth]);
        }])
        ->orderBy('appointments_count', 'desc')
        ->take(5)
        ->get()
        ->map(fn($s) => [
            'id' => $s->id,
            'name' => $s->name,
            'appointments_count' => $s->appointments_count,
            'color' => $s->color,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'revenue' => [
                    'total' => $totalRevenue,
                    'total_formatted' => 'R$ ' . number_format($totalRevenue, 2, ',', '.'),
                    'month' => $monthRevenue,
                    'month_formatted' => 'R$ ' . number_format($monthRevenue, 2, ',', '.'),
                    'today' => $todayRevenue,
                    'today_formatted' => 'R$ ' . number_format($todayRevenue, 2, ',', '.'),
                ],
                'appointments' => [
                    'total' => $totalAppointments,
                    'month' => $monthAppointments,
                    'today' => $todayAppointments,
                    'pending' => $pendingAppointments,
                    'confirmed' => $confirmedAppointments,
                ],
                'status_breakdown' => $statusBreakdown,
                'popular_services' => $popularServices,
            ],
        ]);
    }

    /**
     * Format appointment for API response.
     */
    private function formatAppointment(Appointment $appointment, bool $detailed = false): array
    {
        $data = [
            'id' => $appointment->id,
            'client' => $appointment->client ? [
                'id' => $appointment->client->id,
                'name' => $appointment->client->full_name,
                'cpf' => $appointment->client->cpf,
                'phone' => $appointment->client->phone,
            ] : null,
            'service' => $appointment->service ? [
                'id' => $appointment->service->id,
                'name' => $appointment->service->name,
                'duration' => $appointment->service->duration,
                'color' => $appointment->service->color,
            ] : null,
            'professional' => $appointment->professional ? [
                'id' => $appointment->professional->id,
                'name' => $appointment->professional->name,
                'specialty' => $appointment->professional->specialty,
                'color' => $appointment->professional->color,
            ] : null,
            'scheduled_date' => $appointment->scheduled_date->format('Y-m-d'),
            'scheduled_date_formatted' => $appointment->formatted_date,
            'scheduled_time' => $appointment->formatted_time,
            'end_time' => $appointment->formatted_end_time,
            'time_range' => $appointment->time_range,
            'price' => $appointment->price,
            'price_formatted' => $appointment->formatted_price,
            'status' => $appointment->status,
            'status_label' => $appointment->status_label,
            'status_color' => $appointment->status_color,
        ];

        if ($detailed) {
            $data['notes'] = $appointment->notes;
            $data['cancellation_reason'] = $appointment->cancellation_reason;
            $data['confirmed_at'] = $appointment->confirmed_at?->format('Y-m-d H:i:s');
            $data['completed_at'] = $appointment->completed_at?->format('Y-m-d H:i:s');
            $data['cancelled_at'] = $appointment->cancelled_at?->format('Y-m-d H:i:s');
            $data['created_at'] = $appointment->created_at->format('Y-m-d H:i:s');
            $data['updated_at'] = $appointment->updated_at->format('Y-m-d H:i:s');
            $data['created_by'] = $appointment->user?->name;
        }

        return $data;
    }

    /**
     * List available professionals.
     */
    public function professionals(Request $request)
    {
        $query = Professional::where('is_active', true);

        if ($request->filled('service_id')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('services.id', $request->service_id);
            });
        }

        $professionals = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $professionals->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'email' => $p->email,
                'phone' => $p->phone,
                'specialty' => $p->specialty,
                'color' => $p->color,
                'services_count' => $p->services()->count(),
            ]),
        ]);
    }
}

