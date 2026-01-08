<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    protected function client()
    {
        return Auth::guard('client')->user();
    }

    public function index(Request $request)
    {
        $query = Appointment::where('client_id', $this->client()->id)->with(['service']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('service', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
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
                case 'past':
                    $query->past();
                    break;
            }
        }

        $appointments = $query->orderBy('scheduled_date', 'desc')
                              ->orderBy('scheduled_time', 'desc')
                              ->paginate(10)
                              ->withQueryString();

        $services = Service::where('is_active', true)->orderBy('name')->get();
        $statuses = Appointment::STATUSES;

        return view('client.appointments.index', compact('appointments', 'services', 'statuses'));
    }

    public function create(Request $request)
    {
        $services = Service::where('is_active', true)->with('schedules')->orderBy('name')->get();

        $selectedDate = $request->date ?? null;
        $selectedTime = $request->time ?? null;
        $selectedServiceId = $request->service_id ?? null;

        return view('client.appointments.create', compact(
            'services',
            'selectedDate',
            'selectedTime',
            'selectedServiceId'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'scheduled_date' => ['required', 'date', 'after_or_equal:today'],
            'scheduled_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'service_id.required' => 'Selecione um serviço.',
            'scheduled_date.required' => 'A data é obrigatória.',
            'scheduled_date.after_or_equal' => 'A data deve ser hoje ou no futuro.',
            'scheduled_time.required' => 'O horário é obrigatório.',
        ]);

        $service = Service::findOrFail($validated['service_id']);

        $startTime = Carbon::parse($validated['scheduled_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        // Verificar disponibilidade
        if (!Appointment::isSlotAvailable($service->id, $validated['scheduled_date'], $validated['scheduled_time'])) {
            return back()->withInput()->with('error', 'Este horário não está disponível. Por favor, escolha outro horário.');
        }

        Appointment::create([
            'client_id' => $this->client()->id,
            'service_id' => $validated['service_id'],
            'user_id' => null, // Cliente criou diretamente
            'scheduled_date' => $validated['scheduled_date'],
            'scheduled_time' => $validated['scheduled_time'],
            'end_time' => $endTime->format('H:i'),
            'price' => $service->price,
            'status' => Appointment::STATUS_PENDING,
            'notes' => $validated['notes'],
        ]);

        return redirect()
            ->route('client.appointments.index')
            ->with('success', 'Agendamento realizado com sucesso! Aguarde a confirmação.');
    }

    public function show(Appointment $appointment)
    {
        // Verificar se o agendamento pertence ao cliente logado
        if ($appointment->client_id !== $this->client()->id) {
            abort(403);
        }

        $appointment->load(['service']);
        return view('client.appointments.show', compact('appointment'));
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        // Verificar se o agendamento pertence ao cliente logado
        if ($appointment->client_id !== $this->client()->id) {
            abort(403);
        }

        if (!$appointment->canBeCancelled()) {
            return back()->with('error', 'Este agendamento não pode ser cancelado.');
        }

        $validated = $request->validate([
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $appointment->cancel($validated['cancellation_reason'] ?? 'Cancelado pelo cliente');

        return back()->with('success', 'Agendamento cancelado com sucesso.');
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'date' => ['required', 'date'],
        ]);

        $service = Service::with('schedules')->findOrFail($request->service_id);
        $date = Carbon::parse($request->date);
        $dayOfWeek = $date->dayOfWeek;

        $schedule = $service->schedules->firstWhere('day_of_week', $dayOfWeek);

        if (!$schedule || !$schedule->is_active) {
            return response()->json([
                'available' => false,
                'message' => 'Serviço não disponível neste dia.',
                'slots' => [],
            ]);
        }

        $allSlots = $schedule->getAvailableSlots();

        // Buscar horários já reservados
        $bookedSlots = Appointment::where('service_id', $service->id)
            ->where('scheduled_date', $date->format('Y-m-d'))
            ->whereNotIn('status', ['cancelled'])
            ->pluck('scheduled_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        $availableSlots = array_values(array_filter($allSlots, function ($slot) use ($bookedSlots) {
            return !in_array($slot, $bookedSlots);
        }));

        return response()->json([
            'available' => true,
            'slots' => $availableSlots,
            'booked' => $bookedSlots,
            'duration' => $service->duration,
        ]);
    }
}

