<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();
        $today = Carbon::today();

        // Estatísticas do cliente
        $todayAppointments = Appointment::where('client_id', $client->id)
            ->whereDate('scheduled_date', $today)
            ->whereNotIn('status', ['cancelled'])
            ->count();

        $monthAppointments = Appointment::where('client_id', $client->id)
            ->whereMonth('scheduled_date', $today->month)
            ->whereYear('scheduled_date', $today->year)
            ->whereNotIn('status', ['cancelled'])
            ->count();

        $upcomingAppointments = Appointment::where('client_id', $client->id)
            ->where('scheduled_date', '>=', $today)
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->count();

        $completedAppointments = Appointment::where('client_id', $client->id)
            ->where('status', 'completed')
            ->count();

        // Lista de agendamentos de hoje
        $todayAppointmentsList = Appointment::where('client_id', $client->id)
            ->whereDate('scheduled_date', $today)
            ->whereNotIn('status', ['cancelled'])
            ->with(['service'])
            ->orderBy('scheduled_time', 'asc')
            ->get();

        // Lista de próximos agendamentos
        $upcomingAppointmentsList = Appointment::where('client_id', $client->id)
            ->where('scheduled_date', '>=', $today)
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->with(['service'])
            ->orderBy('scheduled_date', 'asc')
            ->orderBy('scheduled_time', 'asc')
            ->take(10)
            ->get();

        return view('client.dashboard', compact(
            'todayAppointments',
            'monthAppointments',
            'upcomingAppointments',
            'completedAppointments',
            'todayAppointmentsList',
            'upcomingAppointmentsList'
        ));
    }
}
