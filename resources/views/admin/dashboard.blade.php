<x-admin-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="animate-fade-in space-y-6">
        <!-- Revenue Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Total Revenue -->
            <div class="rounded-2xl bg-gradient-to-br from-primary-500 to-secondary-500 p-6 text-white shadow-lg shadow-primary-500/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-white/80">Renda Total</p>
                        <p class="text-2xl font-bold mt-1">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Month Revenue -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 p-6 shadow-soft">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-dark-500 dark:text-dark-400">Renda do Mês</p>
                        <p class="text-2xl font-bold text-dark-900 dark:text-white mt-1">R$ {{ number_format($monthRevenue, 2, ',', '.') }}</p>
                        @if($revenueGrowth != 0)
                            <p class="text-xs mt-1 {{ $revenueGrowth > 0 ? 'text-success-500' : 'text-danger-500' }}">
                                {{ $revenueGrowth > 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}% vs mês anterior
                            </p>
                        @endif
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-success-100 dark:bg-success-500/20">
                        <svg class="h-6 w-6 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Today Revenue -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 p-6 shadow-soft">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-dark-500 dark:text-dark-400">Renda Hoje</p>
                        <p class="text-2xl font-bold text-dark-900 dark:text-white mt-1">R$ {{ number_format($todayRevenue, 2, ',', '.') }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-info-100 dark:bg-info-500/20">
                        <svg class="h-6 w-6 text-info-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Appointments -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 p-6 shadow-soft">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-dark-500 dark:text-dark-400">Agendamentos Totais</p>
                        <p class="text-2xl font-bold text-dark-900 dark:text-white mt-1">{{ number_format($totalAppointments) }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100 dark:bg-primary-500/20">
                        <svg class="h-6 w-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Today Appointments -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 p-6 shadow-soft">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-dark-500 dark:text-dark-400">Agendamentos Hoje</p>
                        <p class="text-2xl font-bold text-dark-900 dark:text-white mt-1">{{ $todayAppointments }}</p>
                        <p class="text-xs text-dark-400 mt-1">{{ $pendingAppointments }} pendentes · {{ $confirmedAppointments }} confirmados</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-warning-100 dark:bg-warning-500/20">
                        <svg class="h-6 w-6 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Appointments Chart -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white">Visão Geral de Reservas</h2>
                    <p class="text-sm text-dark-500 dark:text-dark-400">Últimos 6 meses</p>
                </div>
                <div class="p-6">
                    <canvas id="appointmentsChart" height="200"></canvas>
                </div>
            </div>

            <!-- Revenue Chart -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white">Visão Geral da Receita</h2>
                    <p class="text-sm text-dark-500 dark:text-dark-400">Últimos 6 meses</p>
                </div>
                <div class="p-6">
                    <canvas id="revenueChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Bottom Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Today's Schedule -->
            <div class="lg:col-span-2 rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-dark-900 dark:text-white">Agenda de Hoje</h2>
                        <p class="text-sm text-dark-500 dark:text-dark-400">{{ now()->translatedFormat('l, d \d\e F') }}</p>
                    </div>
                    <a href="{{ route('admin.calendar.index') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                        Ver calendário →
                    </a>
                </div>
                <div class="divide-y divide-dark-100 dark:divide-dark-700">
                    @forelse($upcomingToday as $appointment)
                        <div class="px-6 py-4 flex items-center gap-4 hover:bg-dark-50 dark:hover:bg-dark-700/50 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl text-white font-bold" style="background-color: {{ $appointment->service?->color ?? '#6366f1' }}">
                                    {{ $appointment->formatted_time }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-dark-900 dark:text-white truncate">{{ $appointment->client?->full_name ?? 'Cliente removido' }}</p>
                                <p class="text-sm text-dark-500 dark:text-dark-400">{{ $appointment->service?->name ?? 'Serviço removido' }} · {{ $appointment->time_range }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium" style="background-color: {{ $appointment->status_color }}20; color: {{ $appointment->status_color }}">
                                    {{ $appointment->status_label }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-dark-100 dark:bg-dark-700 mx-auto mb-4">
                                <svg class="h-8 w-8 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-dark-500 dark:text-dark-400">Nenhum agendamento para hoje</p>
                            <a href="{{ route('admin.appointments.create') }}" class="mt-2 inline-block text-primary-500 hover:text-primary-600 font-medium text-sm">
                                Criar agendamento
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Stats & Services -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6">
                    <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-4">Ações Rápidas</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.appointments.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400 hover:bg-primary-100 dark:hover:bg-primary-500/20 transition-colors">
                            <svg class="h-6 w-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="text-xs font-medium">Agendar</span>
                        </a>
                        <a href="{{ route('admin.clients.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-success-50 dark:bg-success-500/10 text-success-600 dark:text-success-400 hover:bg-success-100 dark:hover:bg-success-500/20 transition-colors">
                            <svg class="h-6 w-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span class="text-xs font-medium">Novo Cliente</span>
                        </a>
                        <a href="{{ route('admin.services.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-info-50 dark:bg-info-500/10 text-info-600 dark:text-info-400 hover:bg-info-100 dark:hover:bg-info-500/20 transition-colors">
                            <svg class="h-6 w-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-xs font-medium">Novo Serviço</span>
                        </a>
                        <a href="{{ route('admin.calendar.index') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-warning-50 dark:bg-warning-500/10 text-warning-600 dark:text-warning-400 hover:bg-warning-100 dark:hover:bg-warning-500/20 transition-colors">
                            <svg class="h-6 w-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-xs font-medium">Calendário</span>
                        </a>
                    </div>
                </div>

                <!-- Services Performance -->
                <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                    <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4">
                        <h3 class="font-semibold text-dark-900 dark:text-white">Serviços Populares</h3>
                        <p class="text-xs text-dark-500 dark:text-dark-400">Este mês</p>
                    </div>
                    <div class="p-4 space-y-3">
                        @forelse($servicesBreakdown as $service)
                            <div class="flex items-center gap-3">
                                <span class="h-3 w-3 rounded-full flex-shrink-0" style="background-color: {{ $service->color }}"></span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-dark-900 dark:text-white truncate">{{ $service->name }}</p>
                                    <p class="text-xs text-dark-500 dark:text-dark-400">{{ $service->appointments_count }} agendamentos</p>
                                </div>
                                <span class="text-sm font-semibold text-dark-900 dark:text-white">
                                    R$ {{ number_format($service->revenue ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-dark-500 dark:text-dark-400 text-center py-4">Nenhum dado disponível</p>
                        @endforelse
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="rounded-xl bg-dark-100 dark:bg-dark-700 p-4 text-center">
                        <p class="text-2xl font-bold text-dark-900 dark:text-white">{{ $clientsCount }}</p>
                        <p class="text-xs text-dark-500 dark:text-dark-400">Clientes</p>
                    </div>
                    <div class="rounded-xl bg-dark-100 dark:bg-dark-700 p-4 text-center">
                        <p class="text-2xl font-bold text-dark-900 dark:text-white">{{ $servicesCount }}</p>
                        <p class="text-xs text-dark-500 dark:text-dark-400">Serviços</p>
                    </div>
                    <div class="rounded-xl bg-dark-100 dark:bg-dark-700 p-4 text-center">
                        <p class="text-2xl font-bold text-dark-900 dark:text-white">{{ $usersCount }}</p>
                        <p class="text-xs text-dark-500 dark:text-dark-400">Usuários</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Appointments Chart
            const appointmentsData = @json($appointmentsChart);
            new Chart(document.getElementById('appointmentsChart'), {
                type: 'bar',
                data: {
                    labels: appointmentsData.map(d => d.month),
                    datasets: [{
                        label: 'Agendamentos',
                        data: appointmentsData.map(d => d.count),
                        backgroundColor: 'rgba(99, 102, 241, 0.8)',
                        borderColor: 'rgb(99, 102, 241)',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Revenue Chart
            const revenueData = @json($revenueChart);
            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: revenueData.map(d => d.month),
                    datasets: [{
                        label: 'Receita',
                        data: revenueData.map(d => d.revenue),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgb(16, 185, 129)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'R$ ' + value.toLocaleString('pt-BR');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>
