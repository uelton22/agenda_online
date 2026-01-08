<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Display the calendar view.
     */
    public function index()
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $statuses = Appointment::STATUSES;
        $statusColors = Appointment::STATUS_COLORS;

        return view('admin.calendar.index', compact('services', 'statuses', 'statusColors'));
    }

    /**
     * Get appointments for calendar (JSON).
     */
    public function events(Request $request)
    {
        $request->validate([
            'start' => ['required', 'date'],
            'end' => ['required', 'date'],
        ]);

        $query = Appointment::with(['client', 'service'])
            ->whereBetween('scheduled_date', [
                Carbon::parse($request->start)->startOfDay(),
                Carbon::parse($request->end)->endOfDay()
            ]);

        // Filter by service if specified
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Filter by status if specified
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->get();

        $events = $appointments->map(function ($appointment) {
            return $appointment->toCalendarEvent();
        });

        return response()->json($events);
    }

    /**
     * Get appointment details (for modal).
     */
    public function getAppointment(Appointment $appointment)
    {
        $appointment->load(['client', 'service', 'user']);

        return response()->json([
            'id' => $appointment->id,
            'client' => [
                'id' => $appointment->client->id,
                'name' => $appointment->client->full_name,
                'email' => $appointment->client->email,
                'phone' => $appointment->client->phone,
                'cpf' => $appointment->client->cpf,
            ],
            'service' => [
                'id' => $appointment->service->id,
                'name' => $appointment->service->name,
                'price' => $appointment->service->price,
                'duration' => $appointment->service->duration,
                'color' => $appointment->service->color,
            ],
            'scheduled_date' => $appointment->scheduled_date->format('Y-m-d'),
            'scheduled_date_formatted' => $appointment->formatted_date,
            'scheduled_time' => $appointment->formatted_time,
            'end_time' => $appointment->formatted_end_time,
            'time_range' => $appointment->time_range,
            'day_of_week' => $appointment->day_of_week,
            'price' => $appointment->price,
            'price_formatted' => $appointment->formatted_price,
            'status' => $appointment->status,
            'status_label' => $appointment->status_label,
            'status_color' => $appointment->status_color,
            'notes' => $appointment->notes,
            'can_edit' => $appointment->canBeEdited(),
            'can_cancel' => $appointment->canBeCancelled(),
            'created_by' => $appointment->user->name ?? 'Sistema',
            'created_at' => $appointment->created_at->format('d/m/Y H:i'),
        ]);
    }

    /**
     * Quick create appointment from calendar.
     */
    public function quickStore(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'service_id' => ['required', 'exists:services,id'],
            'scheduled_date' => ['required', 'date'],
            'scheduled_time' => ['required', 'date_format:H:i'],
        ]);

        $service = Service::findOrFail($validated['service_id']);

        // Calculate end time
        $startTime = Carbon::parse($validated['scheduled_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        // Check availability
        if (!Appointment::isSlotAvailable($service->id, $validated['scheduled_date'], $validated['scheduled_time'])) {
            return response()->json([
                'success' => false,
                'message' => 'Este horário não está disponível.',
            ], 422);
        }

        $appointment = Appointment::create([
            'client_id' => $validated['client_id'],
            'service_id' => $validated['service_id'],
            'user_id' => auth()->id(),
            'scheduled_date' => $validated['scheduled_date'],
            'scheduled_time' => $validated['scheduled_time'],
            'end_time' => $endTime->format('H:i'),
            'price' => $service->price,
            'status' => 'pending',
        ]);

        $appointment->load(['client', 'service']);

        return response()->json([
            'success' => true,
            'message' => 'Agendamento criado com sucesso!',
            'event' => $appointment->toCalendarEvent(),
        ]);
    }

    /**
     * Update appointment via drag & drop.
     */
    public function updateEvent(Request $request, Appointment $appointment)
    {
        if (!$appointment->canBeEdited()) {
            return response()->json([
                'success' => false,
                'message' => 'Este agendamento não pode ser alterado.',
            ], 422);
        }

        $validated = $request->validate([
            'scheduled_date' => ['required', 'date'],
            'scheduled_time' => ['required', 'date_format:H:i'],
        ]);

        // Calculate new end time
        $startTime = Carbon::parse($validated['scheduled_time']);
        $endTime = $startTime->copy()->addMinutes($appointment->service->duration);

        // Check availability (excluding current appointment)
        if (!Appointment::isSlotAvailable($appointment->service_id, $validated['scheduled_date'], $validated['scheduled_time'], $appointment->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Este horário não está disponível.',
            ], 422);
        }

        $appointment->update([
            'scheduled_date' => $validated['scheduled_date'],
            'scheduled_time' => $validated['scheduled_time'],
            'end_time' => $endTime->format('H:i'),
        ]);

        $appointment->load(['client', 'service']);

        return response()->json([
            'success' => true,
            'message' => 'Agendamento atualizado com sucesso!',
            'event' => $appointment->toCalendarEvent(),
        ]);
    }
}

