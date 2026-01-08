<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    protected function client()
    {
        return Auth::guard('client')->user();
    }

    public function index()
    {
        $services = Service::where('is_active', true)->get(['id', 'name', 'color']);

        return view('client.calendar.index', compact('services'));
    }

    public function events(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $appointments = Appointment::where('client_id', $this->client()->id)
            ->whereBetween('scheduled_date', [$start, $end])
            ->with(['service'])
            ->get();

        $events = $appointments->map(fn($appointment) => $appointment->toCalendarEvent());

        return response()->json($events);
    }

    public function getAppointment(Appointment $appointment)
    {
        // Verificar se o agendamento pertence ao cliente logado
        if ($appointment->client_id !== $this->client()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Agendamento não encontrado.'
            ], 404);
        }

        $appointment->load(['service']);

        return response()->json([
            'success' => true,
            'appointment' => [
                'id' => $appointment->id,
                'service_name' => $appointment->service->name ?? 'Serviço removido',
                'service_color' => $appointment->service->color ?? '#6366f1',
                'service_duration' => $appointment->service->duration ?? null,
                'date_formatted' => \Carbon\Carbon::parse($appointment->scheduled_date)->format('d/m/Y'),
                'time_formatted' => \Carbon\Carbon::parse($appointment->scheduled_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($appointment->end_time)->format('H:i'),
                'price' => $appointment->price,
                'price_formatted' => 'R$ ' . number_format($appointment->price, 2, ',', '.'),
                'status' => $appointment->status,
                'notes' => $appointment->notes,
            ]
        ]);
    }
}

