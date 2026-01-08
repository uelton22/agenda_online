<x-admin-layout>
    <x-slot name="header">Calendário</x-slot>

    <div class="animate-fade-in" x-data="calendarApp()">
        <!-- Header with actions -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-dark-900 dark:text-white">Calendário de Agendamentos</h2>
                <p class="text-dark-500 dark:text-dark-400">Visualize e gerencie todos os agendamentos</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.appointments.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl border border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700 px-4 py-2.5 text-sm font-semibold text-dark-700 dark:text-dark-300 hover:bg-dark-50 dark:hover:bg-dark-600 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Ver Lista
                </a>
                <a href="{{ route('admin.appointments.create') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Novo Agendamento
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-4 mb-6">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex-1 min-w-[200px]">
                    <select x-model="filterService" @change="calendar.refetchEvents()" class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-2 text-sm text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Todos os serviços</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <select x-model="filterStatus" @change="calendar.refetchEvents()" class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-2 text-sm text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Todos os status</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    @foreach($statuses as $key => $label)
                        <span class="inline-flex items-center gap-1 text-xs">
                            <span class="h-3 w-3 rounded-full" style="background-color: {{ $statusColors[$key] }}"></span>
                            {{ $label }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
            <div id="calendar" class="p-4"></div>
        </div>

        <!-- Appointment Details Modal -->
        <div x-show="showModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-dark-900/75 transition-opacity" 
                     @click="showModal = false"></div>

                <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block w-full max-w-lg transform overflow-hidden rounded-2xl bg-white dark:bg-dark-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:align-middle">
                    
                    <!-- Modal Header -->
                    <div class="h-2" :style="'background-color: ' + (selectedAppointment?.service?.color || '#6366F1')"></div>
                    <div class="px-6 py-4 border-b border-dark-100 dark:border-dark-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-dark-900 dark:text-white" id="modal-title">
                                Detalhes do Agendamento
                            </h3>
                            <button @click="showModal = false" class="rounded-lg p-2 text-dark-400 hover:bg-dark-100 dark:hover:bg-dark-700 hover:text-dark-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="px-6 py-4" x-show="selectedAppointment">
                        <div class="space-y-4">
                            <!-- Status Badge -->
                            <div class="flex items-center justify-center">
                                <span class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium" 
                                      :style="'background-color: ' + selectedAppointment?.status_color + '20; color: ' + selectedAppointment?.status_color">
                                    <span x-text="selectedAppointment?.status_label"></span>
                                </span>
                            </div>

                            <!-- Client Info -->
                            <div class="rounded-xl bg-dark-50 dark:bg-dark-700/50 p-4">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400 mb-2">Cliente</h4>
                                <p class="font-medium text-dark-900 dark:text-white" x-text="selectedAppointment?.client?.name"></p>
                                <p class="text-sm text-dark-500 dark:text-dark-400" x-text="selectedAppointment?.client?.phone"></p>
                            </div>

                            <!-- Service & Time Info -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="rounded-xl bg-dark-50 dark:bg-dark-700/50 p-4">
                                    <h4 class="text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400 mb-2">Serviço</h4>
                                    <div class="flex items-center gap-2">
                                        <span class="h-3 w-3 rounded-full" :style="'background-color: ' + selectedAppointment?.service?.color"></span>
                                        <span class="font-medium text-dark-900 dark:text-white" x-text="selectedAppointment?.service?.name"></span>
                                    </div>
                                </div>
                                <div class="rounded-xl bg-dark-50 dark:bg-dark-700/50 p-4">
                                    <h4 class="text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400 mb-2">Valor</h4>
                                    <p class="font-medium text-dark-900 dark:text-white" x-text="selectedAppointment?.price_formatted"></p>
                                </div>
                            </div>

                            <!-- Date & Time -->
                            <div class="rounded-xl bg-dark-50 dark:bg-dark-700/50 p-4">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400 mb-2">Data e Horário</h4>
                                <p class="font-medium text-dark-900 dark:text-white">
                                    <span x-text="selectedAppointment?.day_of_week"></span>, 
                                    <span x-text="selectedAppointment?.scheduled_date_formatted"></span>
                                </p>
                                <p class="text-sm text-dark-500 dark:text-dark-400" x-text="selectedAppointment?.time_range"></p>
                            </div>

                            <!-- Notes -->
                            <div x-show="selectedAppointment?.notes" class="rounded-xl bg-dark-50 dark:bg-dark-700/50 p-4">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400 mb-2">Observações</h4>
                                <p class="text-sm text-dark-700 dark:text-dark-300" x-text="selectedAppointment?.notes"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-6 py-4 bg-dark-50 dark:bg-dark-700/50 flex items-center justify-between">
                        <p class="text-xs text-dark-500 dark:text-dark-400">
                            Criado por <span x-text="selectedAppointment?.created_by"></span>
                        </p>
                        <div class="flex items-center gap-2">
                            <a x-show="selectedAppointment?.can_edit" 
                               :href="'{{ route('admin.appointments.index') }}/' + selectedAppointment?.id + '/edit'"
                               class="inline-flex items-center gap-2 rounded-xl bg-primary-500 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-600 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/pt-br.global.min.js"></script>
    
    <script>
        function calendarApp() {
            return {
                calendar: null,
                showModal: false,
                selectedAppointment: null,
                filterService: '',
                filterStatus: '',
                
                init() {
                    const calendarEl = document.getElementById('calendar');
                    const self = this;
                    
                    this.calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        locale: 'pt-br',
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
                        height: 'auto',
                        navLinks: true,
                        editable: true,
                        selectable: true,
                        selectMirror: true,
                        dayMaxEvents: true,
                        weekNumbers: false,
                        nowIndicator: true,
                        slotMinTime: '06:00:00',
                        slotMaxTime: '22:00:00',
                        allDaySlot: false,
                        slotDuration: '00:30:00',
                        slotLabelInterval: '01:00:00',
                        slotLabelFormat: {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        },
                        eventTimeFormat: {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        },
                        
                        events: function(info, successCallback, failureCallback) {
                            let url = `{{ route('admin.calendar.events') }}?start=${info.startStr}&end=${info.endStr}`;
                            if (self.filterService) url += `&service_id=${self.filterService}`;
                            if (self.filterStatus) url += `&status=${self.filterStatus}`;
                            
                            fetch(url)
                                .then(response => response.json())
                                .then(events => successCallback(events))
                                .catch(error => failureCallback(error));
                        },
                        
                        eventClick: function(info) {
                            self.loadAppointmentDetails(info.event.id);
                        },
                        
                        eventDrop: function(info) {
                            self.updateEventDate(info);
                        },
                        
                        dateClick: function(info) {
                            window.location.href = `{{ route('admin.appointments.create') }}?date=${info.dateStr}`;
                        },
                        
                        eventDidMount: function(info) {
                            // Add status indicator border
                            const statusColor = info.event.extendedProps.status_color;
                            info.el.style.borderLeftWidth = '4px';
                            info.el.style.borderLeftColor = statusColor;
                        }
                    });
                    
                    this.calendar.render();
                },
                
                async loadAppointmentDetails(id) {
                    try {
                        const response = await fetch(`{{ url('/admin/calendar/appointment') }}/${id}`);
                        this.selectedAppointment = await response.json();
                        this.showModal = true;
                    } catch (error) {
                        console.error('Erro ao carregar detalhes:', error);
                    }
                },
                
                async updateEventDate(info) {
                    const event = info.event;
                    const newDate = event.start.toISOString().split('T')[0];
                    const newTime = event.start.toTimeString().slice(0, 5);
                    
                    try {
                        const response = await fetch(`{{ url('/admin/calendar/event') }}/${event.id}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                scheduled_date: newDate,
                                scheduled_time: newTime
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (!data.success) {
                            info.revert();
                            alert(data.message || 'Erro ao atualizar agendamento');
                        }
                    } catch (error) {
                        console.error('Erro:', error);
                        info.revert();
                        alert('Erro ao atualizar agendamento');
                    }
                }
            };
        }
    </script>
    
    <style>
        /* FullCalendar Custom Styles */
        .fc {
            --fc-border-color: rgb(229 231 235);
            --fc-button-bg-color: #6366F1;
            --fc-button-border-color: #6366F1;
            --fc-button-hover-bg-color: #4F46E5;
            --fc-button-hover-border-color: #4F46E5;
            --fc-button-active-bg-color: #4338CA;
            --fc-button-active-border-color: #4338CA;
            --fc-today-bg-color: rgba(99, 102, 241, 0.1);
        }
        
        .dark .fc {
            --fc-border-color: rgb(55 65 81);
            --fc-page-bg-color: transparent;
            --fc-neutral-bg-color: rgb(31 41 55);
            --fc-neutral-text-color: rgb(229 231 235);
        }
        
        .fc .fc-button {
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 700;
        }
        
        .fc .fc-daygrid-day-number,
        .fc .fc-col-header-cell-cushion {
            color: inherit;
        }
        
        .fc-event {
            border-radius: 0.5rem;
            padding: 2px 4px;
            font-size: 0.75rem;
            cursor: pointer;
        }
        
        .fc-timegrid-event {
            border-radius: 0.5rem;
        }
        
        .fc-daygrid-event {
            white-space: normal;
        }
    </style>
    @endpush
</x-admin-layout>

