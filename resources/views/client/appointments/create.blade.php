<x-client-layout>
    <x-slot name="header">Novo Agendamento</x-slot>

    <div class="animate-fade-in space-y-6">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm">
            <a href="{{ route('client.appointments.index') }}" class="text-dark-500 dark:text-dark-400 hover:text-dark-700 dark:hover:text-white transition-colors">Agendamentos</a>
            <svg class="h-4 w-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-dark-900 dark:text-white font-medium">Novo Agendamento</span>
        </nav>

        <!-- Form -->
        <form action="{{ route('client.appointments.store') }}" method="POST" 
              x-data="appointmentForm()" 
              @submit.prevent="submitForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Form Fields -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Service Selection -->
                    <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-4">Selecione o Serviço</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($services as $service)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="service_id" value="{{ $service->id }}" 
                                           x-model="serviceId"
                                           @change="selectService({{ json_encode($service) }})"
                                           class="sr-only peer"
                                           {{ $selectedServiceId == $service->id ? 'checked' : '' }}>
                                    <div class="p-4 rounded-xl border-2 border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700/30 peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-500/10 hover:border-dark-300 dark:hover:border-dark-500 transition-all">
                                        <div class="flex items-start gap-3">
                                            <div class="w-3 h-3 rounded-full mt-1.5 flex-shrink-0" style="background-color: {{ $service->color }}"></div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-semibold text-dark-900 dark:text-white">{{ $service->name }}</p>
                                                <p class="text-sm text-dark-500 dark:text-dark-400 mt-1">{{ $service->duration }} minutos</p>
                                                <p class="text-lg font-bold text-primary-600 dark:text-primary-400 mt-2">R$ {{ number_format($service->price, 2, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        @error('service_id')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date Selection -->
                    <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6" x-show="serviceId" x-transition>
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-4">Selecione a Data</h3>
                        
                        <div>
                            <input type="date" name="scheduled_date" 
                                   x-model="selectedDate"
                                   @change="loadSlots()"
                                   :min="minDate"
                                   class="w-full rounded-xl border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700/50 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 py-3"
                                   value="{{ $selectedDate }}">
                        </div>

                        @error('scheduled_date')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Time Slots -->
                    <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6" x-show="selectedDate && serviceId" x-transition>
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-4">Selecione o Horário</h3>
                        
                        <div x-show="loading" class="flex items-center justify-center py-8">
                            <svg class="animate-spin h-8 w-8 text-primary-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        <div x-show="!loading && !slotsAvailable" class="text-center py-8">
                            <div class="mx-auto h-12 w-12 rounded-full bg-warning-100 dark:bg-warning-500/20 flex items-center justify-center mb-3">
                                <svg class="h-6 w-6 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <p class="text-dark-500 dark:text-dark-400" x-text="slotsMessage"></p>
                        </div>

                        <div x-show="!loading && slotsAvailable" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                            <template x-for="slot in availableSlots" :key="slot">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="scheduled_time" :value="slot" 
                                           x-model="selectedTime" class="sr-only peer">
                                    <div class="py-2.5 px-3 rounded-lg border border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700/30 text-center text-sm font-medium text-dark-600 dark:text-dark-300 peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-500/20 peer-checked:text-primary-600 dark:peer-checked:text-primary-400 hover:border-dark-300 dark:hover:border-dark-500 hover:text-dark-900 dark:hover:text-white transition-all"
                                         x-text="slot">
                                    </div>
                                </label>
                            </template>
                        </div>

                        @error('scheduled_time')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-4">Observações (opcional)</h3>
                        
                        <textarea name="notes" rows="3" 
                                  class="w-full rounded-xl border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700/50 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500"
                                  placeholder="Adicione alguma observação para o agendamento...">{{ old('notes') }}</textarea>

                        @error('notes')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column - Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-4">Resumo</h3>
                        
                        <div class="space-y-4">
                            <div x-show="selectedService">
                                <p class="text-sm text-dark-500 dark:text-dark-400">Serviço</p>
                                <p class="text-dark-900 dark:text-white font-medium" x-text="selectedService?.name || '-'"></p>
                            </div>
                            
                            <div x-show="selectedDate">
                                <p class="text-sm text-dark-500 dark:text-dark-400">Data</p>
                                <p class="text-dark-900 dark:text-white font-medium" x-text="formatDate(selectedDate) || '-'"></p>
                            </div>
                            
                            <div x-show="selectedTime">
                                <p class="text-sm text-dark-500 dark:text-dark-400">Horário</p>
                                <p class="text-dark-900 dark:text-white font-medium" x-text="selectedTime || '-'"></p>
                                <p class="text-xs text-dark-400 dark:text-dark-500" x-show="selectedService">
                                    Duração: <span x-text="selectedService?.duration"></span> minutos
                                </p>
                            </div>

                            <div class="pt-4 border-t border-dark-100 dark:border-dark-700" x-show="selectedService">
                                <p class="text-sm text-dark-500 dark:text-dark-400">Total</p>
                                <p class="text-2xl font-bold text-primary-600 dark:text-primary-400" x-text="formatPrice(selectedService?.price || 0)"></p>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3">
                            <button type="submit" 
                                    :disabled="!canSubmit"
                                    :class="{ 'opacity-50 cursor-not-allowed': !canSubmit }"
                                    class="w-full flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Confirmar Agendamento
                            </button>
                            <a href="{{ route('client.appointments.index') }}" class="w-full flex items-center justify-center gap-2 rounded-xl bg-dark-100 dark:bg-dark-700 px-6 py-3 text-sm font-medium text-dark-600 dark:text-dark-300 hover:bg-dark-200 dark:hover:bg-dark-600 hover:text-dark-900 dark:hover:text-white transition-colors">
                                Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function appointmentForm() {
            return {
                serviceId: '{{ $selectedServiceId ?? '' }}',
                selectedService: null,
                selectedDate: '{{ $selectedDate ?? '' }}',
                selectedTime: '{{ $selectedTime ?? '' }}',
                availableSlots: [],
                slotsAvailable: false,
                slotsMessage: '',
                loading: false,
                services: @json($services),

                get minDate() {
                    const today = new Date();
                    return today.toISOString().split('T')[0];
                },

                get canSubmit() {
                    return this.serviceId && this.selectedDate && this.selectedTime;
                },

                init() {
                    if (this.serviceId) {
                        const service = this.services.find(s => s.id == this.serviceId);
                        if (service) {
                            this.selectedService = service;
                        }
                    }
                    if (this.selectedDate && this.serviceId) {
                        this.loadSlots();
                    }
                },

                selectService(service) {
                    this.selectedService = service;
                    this.selectedTime = '';
                    if (this.selectedDate) {
                        this.loadSlots();
                    }
                },

                async loadSlots() {
                    if (!this.serviceId || !this.selectedDate) return;

                    this.loading = true;
                    this.selectedTime = '';
                    this.availableSlots = [];
                    this.slotsAvailable = false;

                    try {
                        const response = await fetch(`{{ route('client.appointments.available-slots') }}?service_id=${this.serviceId}&date=${this.selectedDate}`);
                        const data = await response.json();

                        if (data.available && data.slots.length > 0) {
                            this.availableSlots = data.slots;
                            this.slotsAvailable = true;
                        } else {
                            this.slotsMessage = data.message || 'Não há horários disponíveis para esta data.';
                            this.slotsAvailable = false;
                        }
                    } catch (error) {
                        this.slotsMessage = 'Erro ao carregar horários. Tente novamente.';
                        this.slotsAvailable = false;
                    } finally {
                        this.loading = false;
                    }
                },

                formatDate(dateStr) {
                    if (!dateStr) return '-';
                    const date = new Date(dateStr + 'T00:00:00');
                    return date.toLocaleDateString('pt-BR', { 
                        weekday: 'long', 
                        day: 'numeric', 
                        month: 'long' 
                    });
                },

                formatPrice(price) {
                    return 'R$ ' + Number(price).toLocaleString('pt-BR', { 
                        minimumFractionDigits: 2, 
                        maximumFractionDigits: 2 
                    });
                },

                submitForm() {
                    if (!this.canSubmit) return;
                    this.$el.submit();
                }
            }
        }
    </script>
    @endpush
</x-client-layout>
