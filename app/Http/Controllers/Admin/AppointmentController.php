<?php

namespace App\Http\Controllers\Admin;

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
     * Display a listing of appointments.
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['client', 'service', 'user', 'professional']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
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
            }
        }

        $appointments = $query->orderBy('scheduled_date', 'desc')
                              ->orderBy('scheduled_time', 'desc')
                              ->paginate(15)
                              ->withQueryString();

        $services = Service::where('is_active', true)->orderBy('name')->get();
        $statuses = Appointment::STATUSES;

        // Estatísticas rápidas
        $stats = [
            'today' => Appointment::today()->count(),
            'pending' => Appointment::pending()->count(),
            'confirmed' => Appointment::confirmed()->count(),
            'completed_month' => Appointment::thisMonth()->completed()->count(),
        ];

        return view('admin.appointments.index', compact('appointments', 'services', 'statuses', 'stats'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create(Request $request)
    {
        $clients = Client::orderBy('name')->get();
        $services = Service::where('is_active', true)->with(['schedules', 'professionals'])->orderBy('name')->get();
        $professionals = Professional::where('is_active', true)->orderBy('name')->get();
        $statuses = Appointment::STATUSES;

        // Pre-select data if provided
        $selectedDate = $request->date ?? null;
        $selectedTime = $request->time ?? null;
        $selectedServiceId = $request->service_id ?? null;
        $selectedClientId = $request->client_id ?? null;
        $selectedProfessionalId = $request->professional_id ?? null;

        return view('admin.appointments.create', compact(
            'clients', 
            'services',
            'professionals', 
            'statuses',
            'selectedDate',
            'selectedTime',
            'selectedServiceId',
            'selectedClientId',
            'selectedProfessionalId'
        ));
    }

    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'service_id' => ['required', 'exists:services,id'],
            'professional_id' => ['nullable', 'exists:professionals,id'],
            'scheduled_date' => ['required', 'date', 'after_or_equal:today'],
            'scheduled_time' => ['required', 'date_format:H:i'],
            'status' => ['required', 'in:pending,confirmed,completed,cancelled,no_show'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'client_id.required' => 'Selecione um cliente.',
            'service_id.required' => 'Selecione um serviço.',
            'scheduled_date.required' => 'A data é obrigatória.',
            'scheduled_date.after_or_equal' => 'A data deve ser hoje ou no futuro.',
            'scheduled_time.required' => 'O horário é obrigatório.',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $professionalId = $validated['professional_id'] ?? null;

        // Calculate end time based on service duration
        $startTime = Carbon::parse($validated['scheduled_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        // Check if slot is available (considering professional)
        if (!Appointment::isSlotAvailable($service->id, $validated['scheduled_date'], $validated['scheduled_time'], $professionalId)) {
            return back()->withInput()->with('error', 'Este horário não está disponível para este profissional. Por favor, escolha outro horário ou profissional.');
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
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'confirmed_at' => $validated['status'] === 'confirmed' ? now() : null,
            'completed_at' => $validated['status'] === 'completed' ? now() : null,
        ]);

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Agendamento criado com sucesso!');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['client', 'service', 'user']);
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the appointment.
     */
    public function edit(Appointment $appointment)
    {
        if (!$appointment->canBeEdited()) {
            return redirect()
                ->route('admin.appointments.index')
                ->with('error', 'Este agendamento não pode ser editado.');
        }

        $clients = Client::orderBy('name')->get();
        $services = Service::where('is_active', true)->with(['schedules', 'professionals'])->orderBy('name')->get();
        $professionals = Professional::where('is_active', true)->orderBy('name')->get();
        $statuses = Appointment::STATUSES;

        return view('admin.appointments.edit', compact('appointment', 'clients', 'services', 'professionals', 'statuses'));
    }

    /**
     * Update the specified appointment.
     */
    public function update(Request $request, Appointment $appointment)
    {
        if (!$appointment->canBeEdited()) {
            return redirect()
                ->route('admin.appointments.index')
                ->with('error', 'Este agendamento não pode ser editado.');
        }

        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'service_id' => ['required', 'exists:services,id'],
            'professional_id' => ['nullable', 'exists:professionals,id'],
            'scheduled_date' => ['required', 'date'],
            'scheduled_time' => ['required', 'date_format:H:i'],
            'status' => ['required', 'in:pending,confirmed,completed,cancelled,no_show'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $professionalId = $validated['professional_id'] ?? null;

        // Calculate end time
        $startTime = Carbon::parse($validated['scheduled_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        // Check if slot is available (excluding current appointment, considering professional)
        if (!Appointment::isSlotAvailable($service->id, $validated['scheduled_date'], $validated['scheduled_time'], $professionalId, $appointment->id)) {
            return back()->withInput()->with('error', 'Este horário não está disponível para este profissional. Por favor, escolha outro horário ou profissional.');
        }

        // Update status timestamps
        $confirmed_at = $appointment->confirmed_at;
        $completed_at = $appointment->completed_at;
        $cancelled_at = $appointment->cancelled_at;

        if ($validated['status'] === 'confirmed' && !$appointment->isConfirmed()) {
            $confirmed_at = now();
        }
        if ($validated['status'] === 'completed' && !$appointment->isCompleted()) {
            $completed_at = now();
        }
        if ($validated['status'] === 'cancelled' && !$appointment->isCancelled()) {
            $cancelled_at = now();
        }

        $appointment->update([
            'client_id' => $validated['client_id'],
            'service_id' => $validated['service_id'],
            'professional_id' => $professionalId,
            'scheduled_date' => $validated['scheduled_date'],
            'scheduled_time' => $validated['scheduled_time'],
            'end_time' => $endTime->format('H:i'),
            'price' => $service->price,
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'confirmed_at' => $confirmed_at,
            'completed_at' => $completed_at,
            'cancelled_at' => $cancelled_at,
        ]);

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    /**
     * Remove the specified appointment.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Agendamento removido com sucesso!');
    }

    /**
     * Update appointment status via AJAX.
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

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status atualizado com sucesso!',
                'status' => $appointment->status,
                'status_label' => $appointment->status_label,
                'status_color' => $appointment->status_color,
            ]);
        }

        return back()->with('success', 'Status atualizado com sucesso!');
    }

    /**
     * Get available slots for a service on a specific date.
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'date' => ['required', 'date'],
            'professional_id' => ['nullable', 'exists:professionals,id'],
            'exclude_id' => ['nullable', 'exists:appointments,id'],
        ]);

        $service = Service::with(['schedules', 'professionals'])->findOrFail($request->service_id);
        $professionalId = $request->professional_id;
        $date = Carbon::parse($request->date);
        $dayOfWeek = $date->dayOfWeek;

        // Check if service is available on this day
        $schedule = $service->schedules->firstWhere('day_of_week', $dayOfWeek);

        if (!$schedule || !$schedule->is_active) {
            return response()->json([
                'available' => false,
                'message' => 'Serviço não disponível neste dia.',
                'slots' => [],
            ]);
        }

        // Get all possible slots
        $allSlots = $schedule->getAvailableSlots();

        // Get booked slots for this day
        $bookedQuery = Appointment::where('scheduled_date', $date->format('Y-m-d'))
            ->whereNotIn('status', ['cancelled']);

        // Filter by professional if specified
        if ($professionalId) {
            $bookedQuery->where('professional_id', $professionalId);
        } else {
            $bookedQuery->where('service_id', $service->id);
        }

        if ($request->exclude_id) {
            $bookedQuery->where('id', '!=', $request->exclude_id);
        }

        $bookedSlots = $bookedQuery->pluck('scheduled_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        // Filter available slots
        $availableSlots = array_values(array_filter($allSlots, function ($slot) use ($bookedSlots) {
            return !in_array($slot, $bookedSlots);
        }));

        // If professional_id is not specified, return list of available professionals for each slot
        $professionalsPerSlot = [];
        if (!$professionalId && $service->professionals->count() > 0) {
            foreach ($allSlots as $slot) {
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
            'available' => true,
            'slots' => $availableSlots,
            'booked' => $bookedSlots,
            'duration' => $service->duration,
            'professionals' => $service->professionals->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'color' => $p->color
            ]),
            'professionals_per_slot' => $professionalsPerSlot,
        ]);
    }

    /**
     * Get professionals available for a service
     */
    public function getProfessionalsForService(Request $request)
    {
        $request->validate([
            'service_id' => ['required', 'exists:services,id'],
        ]);

        $service = Service::with('professionals')->findOrFail($request->service_id);
        
        return response()->json([
            'professionals' => $service->professionals->where('is_active', true)->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'color' => $p->color,
                'specialty' => $p->specialty,
            ]),
        ]);
    }
}

