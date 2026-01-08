<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        // Revenue Stats
        $totalRevenue = Appointment::completed()->sum('price');
        $monthRevenue = Appointment::completed()
            ->whereBetween('scheduled_date', [$startOfMonth, $endOfMonth])
            ->sum('price');
        $todayRevenue = Appointment::completed()
            ->whereDate('scheduled_date', $today)
            ->sum('price');

        // Appointment Stats
        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::today()->count();
        $pendingAppointments = Appointment::pending()->upcoming()->count();
        $confirmedAppointments = Appointment::confirmed()->upcoming()->count();

        // Monthly comparison
        $lastMonthRevenue = Appointment::completed()
            ->whereBetween('scheduled_date', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])
            ->sum('price');
        
        $revenueGrowth = $lastMonthRevenue > 0 
            ? (($monthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        // Today's upcoming appointments
        $upcomingToday = Appointment::with(['client', 'service'])
            ->today()
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('scheduled_time')
            ->take(5)
            ->get();

        // Monthly appointments chart data (last 6 months)
        $appointmentsChart = $this->getAppointmentsChartData();

        // Revenue chart data (last 6 months)
        $revenueChart = $this->getRevenueChartData();

        // Services breakdown
        $servicesBreakdown = Service::withCount(['appointments' => function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('scheduled_date', [$startOfMonth, $endOfMonth]);
        }])
        ->withSum(['appointments as revenue' => function ($query) use ($startOfMonth, $endOfMonth) {
            $query->where('status', 'completed')
                  ->whereBetween('scheduled_date', [$startOfMonth, $endOfMonth]);
        }], 'price')
        ->orderBy('appointments_count', 'desc')
        ->take(5)
        ->get();

        // Status breakdown for today
        $statusBreakdown = [
            'pending' => Appointment::today()->pending()->count(),
            'confirmed' => Appointment::today()->confirmed()->count(),
            'completed' => Appointment::today()->completed()->count(),
            'cancelled' => Appointment::today()->cancelled()->count(),
        ];

        // Recent appointments
        $recentAppointments = Appointment::with(['client', 'service'])
            ->latest()
            ->take(5)
            ->get();

        // Quick stats
        $clientsCount = Client::count();
        $servicesCount = Service::where('is_active', true)->count();
        $usersCount = User::count();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'monthRevenue',
            'todayRevenue',
            'revenueGrowth',
            'totalAppointments',
            'todayAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'upcomingToday',
            'appointmentsChart',
            'revenueChart',
            'servicesBreakdown',
            'statusBreakdown',
            'recentAppointments',
            'clientsCount',
            'servicesCount',
            'usersCount'
        ));
    }

    private function getAppointmentsChartData(): array
    {
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Appointment::whereMonth('scheduled_date', $date->month)
                ->whereYear('scheduled_date', $date->year)
                ->count();
            
            $data[] = [
                'month' => $date->translatedFormat('M'),
                'count' => $count,
            ];
        }
        
        return $data;
    }

    private function getRevenueChartData(): array
    {
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Appointment::completed()
                ->whereMonth('scheduled_date', $date->month)
                ->whereYear('scheduled_date', $date->year)
                ->sum('price');
            
            $data[] = [
                'month' => $date->translatedFormat('M'),
                'revenue' => (float) $revenue,
            ];
        }
        
        return $data;
    }
}

