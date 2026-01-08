<x-client-layout>
    <x-slot name="header">Meu Calendário</x-slot>

    <div class="animate-fade-in space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-dark-500 dark:text-dark-400">Visualize todos os seus agendamentos</p>
            </div>
            <a href="{{ route('client.appointments.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Novo Agendamento
            </a>
        </div>

        <!-- Calendar -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
            <div class="p-6">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Appointment Detail Modal -->
    <div id="appointmentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-dark-900/80 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>
            <div class="relative inline-block transform overflow-hidden rounded-2xl bg-white dark:bg-dark-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white">Detalhes do Agendamento</h3>
                        <button type="button" onclick="closeModal()" class="text-dark-400 hover:text-dark-600 dark:hover:text-white transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div id="modalContent" class="space-y-4">
                        <!-- Content loaded via JS -->
                    </div>
                </div>
                <div class="flex justify-end gap-3 px-6 py-4 bg-dark-50 dark:bg-dark-700/30 border-t border-dark-100 dark:border-dark-700">
                    <button type="button" onclick="closeModal()" class="rounded-xl px-4 py-2.5 text-sm font-medium text-dark-500 dark:text-dark-300 hover:text-dark-700 dark:hover:text-white transition-colors">
                        Fechar
                    </button>
                    <a id="viewDetailsLink" href="#" class="rounded-xl bg-primary-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-600 transition-colors">
                        Ver Detalhes
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/pt-br.global.min.js"></script>
    <script>
        let calendar;

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                buttonText: {
                    today: 'Hoje',
                    month: 'Mês',
                    week: 'Semana',
                    day: 'Dia',
                    list: 'Lista'
                },
                events: '{{ route('client.calendar.events') }}',
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    openModal(info.event.id);
                },
                eventDisplay: 'block',
                displayEventTime: true,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                dayMaxEvents: 3,
                moreLinkClick: 'popover',
                nowIndicator: true,
                navLinks: true,
                editable: false,
                selectable: false,
            });
            calendar.render();
        });

        async function openModal(appointmentId) {
            const modal = document.getElementById('appointmentModal');
            const content = document.getElementById('modalContent');
            const viewLink = document.getElementById('viewDetailsLink');
            
            content.innerHTML = `
                <div class="flex items-center justify-center py-8">
                    <svg class="animate-spin h-8 w-8 text-primary-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            `;
            
            modal.classList.remove('hidden');
            viewLink.href = '{{ url('cliente/agendamentos') }}/' + appointmentId;

            try {
                const response = await fetch('{{ url('cliente/calendario/agendamento') }}/' + appointmentId);
                const data = await response.json();

                if (data.success) {
                    const appointment = data.appointment;
                    content.innerHTML = `
                        <div class="flex items-center gap-3 p-4 rounded-xl bg-dark-50 dark:bg-dark-700/30">
                            <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: ${appointment.service_color || '#6366f1'}"></div>
                            <div class="flex-1">
                                <p class="text-dark-900 dark:text-white font-medium">${appointment.service_name || 'Serviço removido'}</p>
                                <p class="text-sm text-dark-500 dark:text-dark-400">${appointment.service_duration || '-'} minutos</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-dark-500 dark:text-dark-400">Data</p>
                                <p class="text-dark-900 dark:text-white font-medium">${appointment.date_formatted}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500 dark:text-dark-400">Horário</p>
                                <p class="text-dark-900 dark:text-white font-medium">${appointment.time_formatted}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-dark-500 dark:text-dark-400">Valor</p>
                                <p class="text-xl font-bold text-primary-600 dark:text-primary-400">${appointment.price_formatted}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500 dark:text-dark-400">Status</p>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium ${getStatusClass(appointment.status)}">
                                    ${getStatusLabel(appointment.status)}
                                </span>
                            </div>
                        </div>
                        ${appointment.notes ? `
                            <div>
                                <p class="text-sm text-dark-500 dark:text-dark-400">Observações</p>
                                <p class="text-dark-600 dark:text-dark-300">${appointment.notes}</p>
                            </div>
                        ` : ''}
                    `;
                } else {
                    content.innerHTML = `
                        <div class="text-center py-4 text-danger-600 dark:text-danger-400">
                            Erro ao carregar detalhes do agendamento.
                        </div>
                    `;
                }
            } catch (error) {
                content.innerHTML = `
                    <div class="text-center py-4 text-danger-600 dark:text-danger-400">
                        Erro ao carregar detalhes do agendamento.
                    </div>
                `;
            }
        }

        function closeModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
        }

        function getStatusClass(status) {
            const classes = {
                'confirmed': 'bg-success-100 dark:bg-success-500/20 text-success-700 dark:text-success-400',
                'pending': 'bg-warning-100 dark:bg-warning-500/20 text-warning-700 dark:text-warning-400',
                'completed': 'bg-primary-100 dark:bg-primary-500/20 text-primary-700 dark:text-primary-400',
                'cancelled': 'bg-danger-100 dark:bg-danger-500/20 text-danger-700 dark:text-danger-400',
                'no_show': 'bg-dark-100 dark:bg-dark-500/20 text-dark-600 dark:text-dark-300'
            };
            return classes[status] || 'bg-dark-100 dark:bg-dark-500/20 text-dark-600 dark:text-dark-300';
        }

        function getStatusLabel(status) {
            const labels = {
                'confirmed': 'Confirmado',
                'pending': 'Pendente',
                'completed': 'Concluído',
                'cancelled': 'Cancelado',
                'no_show': 'Não compareceu'
            };
            return labels[status] || status;
        }
    </script>
    @endpush

    @push('styles')
    <style>
        /* Light mode styles */
        #calendar {
            --fc-border-color: rgba(229, 231, 235, 1);
            --fc-button-bg-color: rgba(99, 102, 241, 0.1);
            --fc-button-border-color: transparent;
            --fc-button-text-color: #4f46e5;
            --fc-button-hover-bg-color: rgba(99, 102, 241, 0.2);
            --fc-button-hover-border-color: transparent;
            --fc-button-active-bg-color: rgba(99, 102, 241, 0.3);
            --fc-today-bg-color: rgba(99, 102, 241, 0.05);
            --fc-neutral-bg-color: transparent;
            --fc-page-bg-color: transparent;
            --fc-event-bg-color: #6366f1;
            --fc-event-border-color: transparent;
            --fc-list-event-hover-bg-color: rgba(99, 102, 241, 0.05);
        }
        
        /* Dark mode styles */
        .dark #calendar {
            --fc-border-color: rgba(55, 65, 81, 0.5);
            --fc-button-bg-color: rgba(99, 102, 241, 0.2);
            --fc-button-text-color: #a5b4fc;
            --fc-button-hover-bg-color: rgba(99, 102, 241, 0.4);
            --fc-button-active-bg-color: rgba(99, 102, 241, 0.6);
            --fc-today-bg-color: rgba(99, 102, 241, 0.1);
            --fc-list-event-hover-bg-color: rgba(99, 102, 241, 0.1);
        }
        
        .fc {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        .fc-theme-standard td, .fc-theme-standard th {
            border-color: var(--fc-border-color);
        }
        
        .fc-day-today {
            background-color: var(--fc-today-bg-color) !important;
        }
        
        .fc-col-header-cell-cushion,
        .fc-daygrid-day-number,
        .fc-list-day-cushion {
            color: #6b7280;
        }
        
        .dark .fc-col-header-cell-cushion,
        .dark .fc-daygrid-day-number,
        .dark .fc-list-day-cushion {
            color: #9ca3af;
        }
        
        .fc-toolbar-title {
            color: #111827 !important;
            font-size: 1.25rem !important;
            font-weight: 600;
        }
        
        .dark .fc-toolbar-title {
            color: #fff !important;
        }
        
        .fc-button {
            font-size: 0.75rem !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.75rem !important;
            color: var(--fc-button-text-color);
        }
        
        .fc-button-active {
            background-color: var(--fc-button-active-bg-color) !important;
        }
        
        .fc-event {
            border-radius: 0.5rem;
            padding: 2px 6px;
            font-size: 0.8rem;
            cursor: pointer;
        }
        
        .fc-event:hover {
            opacity: 0.9;
        }

        .fc-timegrid-slot {
            height: 3rem;
        }

        .fc-timegrid-slot-label,
        .fc-list-event-time,
        .fc-list-event-title {
            color: #6b7280;
        }
        
        .dark .fc-timegrid-slot-label,
        .dark .fc-list-event-time,
        .dark .fc-list-event-title {
            color: #d1d5db;
        }

        .fc-more-link {
            color: #6366f1;
        }

        .fc-popover {
            background-color: #fff !important;
            border-color: rgba(229, 231, 235, 1) !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }
        
        .dark .fc-popover {
            background-color: #1f2937 !important;
            border-color: rgba(55, 65, 81, 0.5) !important;
        }

        .fc-popover-header {
            background-color: #f9fafb !important;
            color: #111827 !important;
        }
        
        .dark .fc-popover-header {
            background-color: rgba(55, 65, 81, 0.3) !important;
            color: #fff !important;
        }
    </style>
    @endpush
</x-client-layout>
