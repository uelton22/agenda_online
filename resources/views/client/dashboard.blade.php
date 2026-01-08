<x-client-layout>
    <x-slot name="header">Meus Agendamentos</x-slot>

    <div class="animate-fade-in space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Today's Appointments -->
            <div class="rounded-2xl bg-gradient-to-br from-primary-500 to-secondary-500 p-6 text-white shadow-lg shadow-primary-500/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-white/80">Hoje</p>
                        <p class="text-3xl font-bold mt-1">{{ $todayAppointments }}</p>
                        <p class="text-xs text-white/60 mt-1">agendamentos</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- This Month -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 p-6 shadow-soft">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-dark-500 dark:text-dark-400">Este Mês</p>
                        <p class="text-3xl font-bold text-dark-900 dark:text-white mt-1">{{ $monthAppointments }}</p>
                        <p class="text-xs text-dark-400 mt-1">agendamentos</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-secondary-100 dark:bg-secondary-500/20">
                        <svg class="h-6 w-6 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Upcoming -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 p-6 shadow-soft">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-dark-500 dark:text-dark-400">Próximos</p>
                        <p class="text-3xl font-bold text-dark-900 dark:text-white mt-1">{{ $upcomingAppointments }}</p>
                        <p class="text-xs text-dark-400 mt-1">agendamentos</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-info-100 dark:bg-info-500/20">
                        <svg class="h-6 w-6 text-info-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 p-6 shadow-soft">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-dark-500 dark:text-dark-400">Concluídos</p>
                        <p class="text-3xl font-bold text-dark-900 dark:text-white mt-1">{{ $completedAppointments }}</p>
                        <p class="text-xs text-dark-400 mt-1">agendamentos</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-success-100 dark:bg-success-500/20">
                        <svg class="h-6 w-6 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Today's Schedule -->
            <div class="lg:col-span-2 rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-dark-900 dark:text-white">Agendamentos de Hoje</h2>
                        <p class="text-sm text-dark-500 dark:text-dark-400">{{ now()->translatedFormat('l, d \d\e F') }}</p>
                    </div>
                    <a href="{{ route('client.calendar.index') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                        Ver calendário →
                    </a>
                </div>
                <div class="divide-y divide-dark-100 dark:divide-dark-700">
                    @forelse($todayAppointmentsList as $appointment)
                        <div class="px-6 py-4 flex items-center gap-4 hover:bg-dark-50 dark:hover:bg-dark-700/50 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl text-white font-bold text-sm" style="background-color: {{ $appointment->service?->color ?? '#6366f1' }}">
                                    {{ \Carbon\Carbon::parse($appointment->scheduled_time)->format('H:i') }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-dark-900 dark:text-white truncate">{{ $appointment->service?->name ?? 'Serviço removido' }}</p>
                                <p class="text-sm text-dark-500 dark:text-dark-400">{{ \Carbon\Carbon::parse($appointment->scheduled_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                    @if($appointment->status === 'confirmed') bg-success-100 dark:bg-success-500/20 text-success-700 dark:text-success-400
                                    @elseif($appointment->status === 'pending') bg-warning-100 dark:bg-warning-500/20 text-warning-700 dark:text-warning-400
                                    @elseif($appointment->status === 'completed') bg-primary-100 dark:bg-primary-500/20 text-primary-700 dark:text-primary-400
                                    @else bg-danger-100 dark:bg-danger-500/20 text-danger-700 dark:text-danger-400
                                    @endif">
                                    @if($appointment->status === 'confirmed') Confirmado
                                    @elseif($appointment->status === 'pending') Pendente
                                    @elseif($appointment->status === 'completed') Concluído
                                    @else Cancelado
                                    @endif
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
                            <a href="{{ route('client.appointments.create') }}" class="mt-2 inline-block text-primary-500 hover:text-primary-600 font-medium text-sm">
                                Criar agendamento
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions & Calendar Preview -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6">
                    <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-4">Ações Rápidas</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('client.appointments.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400 hover:bg-primary-100 dark:hover:bg-primary-500/20 transition-colors">
                            <svg class="h-6 w-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="text-xs font-medium">Novo Agendamento</span>
                        </a>
                        <a href="{{ route('client.calendar.index') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-secondary-50 dark:bg-secondary-500/10 text-secondary-600 dark:text-secondary-400 hover:bg-secondary-100 dark:hover:bg-secondary-500/20 transition-colors">
                            <svg class="h-6 w-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-xs font-medium">Calendário</span>
                        </a>
                        <a href="{{ route('client.appointments.index') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-info-50 dark:bg-info-500/10 text-info-600 dark:text-info-400 hover:bg-info-100 dark:hover:bg-info-500/20 transition-colors">
                            <svg class="h-6 w-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="text-xs font-medium">Meus Agendamentos</span>
                        </a>
                        <a href="{{ route('client.appointments.index', ['period' => 'past']) }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-success-50 dark:bg-success-500/10 text-success-600 dark:text-success-400 hover:bg-success-100 dark:hover:bg-success-500/20 transition-colors">
                            <svg class="h-6 w-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-xs font-medium">Histórico</span>
                        </a>
                    </div>
                </div>

                <!-- Mini Calendar -->
                <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                    <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 flex items-center justify-between">
                        <h3 class="font-semibold text-dark-900 dark:text-white">Calendário</h3>
                        <a href="{{ route('client.calendar.index') }}" class="text-xs text-primary-500 hover:text-primary-600 font-medium">
                            Ver completo →
                        </a>
                    </div>
                    <div class="p-4">
                        <div id="mini-calendar"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments Table -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
            <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white">Próximos Agendamentos</h2>
                    <p class="text-sm text-dark-500 dark:text-dark-400">Seus agendamentos futuros</p>
                </div>
                <a href="{{ route('client.appointments.index') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                    Ver todos →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-dark-50 dark:bg-dark-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-500 dark:text-dark-400 uppercase tracking-wider">Serviço</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-500 dark:text-dark-400 uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-500 dark:text-dark-400 uppercase tracking-wider">Horário</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-500 dark:text-dark-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-500 dark:text-dark-400 uppercase tracking-wider">Valor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-100 dark:divide-dark-700">
                        @forelse($upcomingAppointmentsList as $appointment)
                            <tr class="hover:bg-dark-50 dark:hover:bg-dark-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $appointment->service?->color ?? '#6366f1' }}"></div>
                                        <span class="font-medium text-dark-900 dark:text-white">{{ $appointment->service?->name ?? 'Serviço removido' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-dark-600 dark:text-dark-300">
                                    {{ \Carbon\Carbon::parse($appointment->scheduled_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-dark-600 dark:text-dark-300">
                                    {{ \Carbon\Carbon::parse($appointment->scheduled_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                        @if($appointment->status === 'confirmed') bg-success-100 dark:bg-success-500/20 text-success-700 dark:text-success-400
                                        @elseif($appointment->status === 'pending') bg-warning-100 dark:bg-warning-500/20 text-warning-700 dark:text-warning-400
                                        @elseif($appointment->status === 'completed') bg-primary-100 dark:bg-primary-500/20 text-primary-700 dark:text-primary-400
                                        @else bg-danger-100 dark:bg-danger-500/20 text-danger-700 dark:text-danger-400
                                        @endif">
                                        @if($appointment->status === 'confirmed') Confirmado
                                        @elseif($appointment->status === 'pending') Pendente
                                        @elseif($appointment->status === 'completed') Concluído
                                        @else Cancelado
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-dark-900 dark:text-white">
                                    R$ {{ number_format($appointment->price, 2, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-dark-100 dark:bg-dark-700 mx-auto mb-3">
                                        <svg class="h-6 w-6 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-dark-500 dark:text-dark-400">Nenhum agendamento futuro encontrado</p>
                                    <a href="{{ route('client.appointments.create') }}" class="mt-2 inline-block text-primary-500 hover:text-primary-600 font-medium text-sm">
                                        Fazer um agendamento
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/pt-br.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('mini-calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                height: 280,
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                },
                events: '{{ route('client.calendar.events') }}',
                eventClick: function(info) {
                    window.location.href = '{{ url('cliente/agendamentos') }}/' + info.event.id;
                },
                eventDisplay: 'dot',
                dayMaxEvents: 2
            });
            calendar.render();
        });
    </script>
    @endpush

    @push('styles')
    <style>
        #mini-calendar {
            --fc-border-color: rgba(229, 231, 235, 0.5);
            --fc-button-bg-color: transparent;
            --fc-button-border-color: transparent;
            --fc-button-hover-bg-color: rgba(99, 102, 241, 0.1);
            --fc-button-hover-border-color: transparent;
            --fc-button-active-bg-color: rgba(99, 102, 241, 0.2);
            --fc-today-bg-color: rgba(99, 102, 241, 0.1);
            --fc-neutral-bg-color: transparent;
            --fc-page-bg-color: transparent;
            --fc-event-bg-color: #6366f1;
            --fc-event-border-color: transparent;
        }
        
        .dark #mini-calendar {
            --fc-border-color: rgba(55, 65, 81, 0.5);
        }
        
        #mini-calendar .fc {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        #mini-calendar .fc-theme-standard td,
        #mini-calendar .fc-theme-standard th {
            border-color: var(--fc-border-color);
        }
        
        #mini-calendar .fc-col-header-cell-cushion,
        #mini-calendar .fc-daygrid-day-number {
            color: #6b7280;
            font-size: 0.75rem;
        }
        
        .dark #mini-calendar .fc-col-header-cell-cushion,
        .dark #mini-calendar .fc-daygrid-day-number {
            color: #9ca3af;
        }
        
        #mini-calendar .fc-toolbar-title {
            color: #111827 !important;
            font-size: 0.875rem !important;
            font-weight: 600;
        }
        
        .dark #mini-calendar .fc-toolbar-title {
            color: #fff !important;
        }
        
        #mini-calendar .fc-button {
            font-size: 0.75rem !important;
            padding: 0.25rem 0.5rem !important;
            border-radius: 0.375rem !important;
            color: #6b7280;
        }
        
        .dark #mini-calendar .fc-button {
            color: #9ca3af;
        }
        
        #mini-calendar .fc-button:hover {
            color: #111827;
        }
        
        .dark #mini-calendar .fc-button:hover {
            color: #fff;
        }
        
        #mini-calendar .fc-daygrid-day-events {
            min-height: 0.5rem;
        }
        
        #mini-calendar .fc-daygrid-event-dot {
            border-color: #6366f1;
        }
    </style>
    @endpush
</x-client-layout>
