<x-admin-layout>
    <x-slot name="header">Novo Agendamento</x-slot>

    <div class="animate-fade-in max-w-4xl">
        <!-- Back link -->
        <div class="mb-6">
            <a href="{{ route('admin.appointments.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-dark-500 dark:text-dark-400 hover:text-dark-700 dark:hover:text-dark-200 transition-colors">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar para lista
            </a>
        </div>

        <form method="POST" action="{{ route('admin.appointments.store') }}" x-data="appointmentForm()">
            @csrf

            <!-- Main Card -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden mb-6">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white">Informações do Agendamento</h2>
                    <p class="text-sm text-dark-500 dark:text-dark-400">Preencha os dados para criar um novo agendamento</p>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Client Selection -->
                    <div>
                        <label for="client_id" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            Cliente <span class="text-danger-500">*</span>
                        </label>
                        <select name="client_id" 
                                id="client_id" 
                                required
                                class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors @error('client_id') border-danger-500 @enderror">
                            <option value="">Selecione um cliente</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', $selectedClientId) == $client->id ? 'selected' : '' }}>
                                    {{ $client->full_name }} - {{ $client->formatted_cpf }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Service Selection -->
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            Serviço <span class="text-danger-500">*</span>
                        </label>
                        <select name="service_id" 
                                id="service_id" 
                                required
                                x-model="serviceId"
                                @change="onServiceChange()"
                                class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors @error('service_id') border-danger-500 @enderror">
                            <option value="">Selecione um serviço</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" 
                                        data-duration="{{ $service->duration }}"
                                        data-price="{{ $service->price }}"
                                        data-color="{{ $service->color }}"
                                        data-professionals="{{ json_encode($service->professionals->pluck('id')) }}"
                                        {{ old('service_id', $selectedServiceId) == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} - {{ $service->formatted_price }} ({{ $service->formatted_duration }})
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                        
                        <!-- Service Info -->
                        <div x-show="serviceId" x-transition class="mt-3 p-4 rounded-xl bg-dark-50 dark:bg-dark-700/50">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-lg" :style="'background-color: ' + serviceColor"></div>
                                <div>
                                    <p class="font-medium text-dark-900 dark:text-white" x-text="serviceName"></p>
                                    <p class="text-sm text-dark-500 dark:text-dark-400">
                                        <span x-text="servicePrice"></span> · <span x-text="serviceDuration + ' min'"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Selection -->
                    <div x-show="serviceProfessionals.length > 0" x-transition>
                        <label for="professional_id" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            Profissional
                        </label>
                        <select name="professional_id" 
                                id="professional_id" 
                                x-model="professionalId"
                                @change="onProfessionalChange()"
                                class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors @error('professional_id') border-danger-500 @enderror">
                            <option value="">Qualquer profissional disponível</option>
                            <template x-for="professional in serviceProfessionals" :key="professional.id">
                                <option :value="professional.id" x-text="professional.name"></option>
                            </template>
                        </select>
                        <p class="mt-2 text-xs text-dark-500 dark:text-dark-400">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Selecione um profissional específico ou deixe vazio para escolher qualquer um disponível.
                        </p>
                        @error('professional_id')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="scheduled_date" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                Data <span class="text-danger-500">*</span>
                            </label>
                            <input type="date" 
                                   name="scheduled_date" 
                                   id="scheduled_date" 
                                   value="{{ old('scheduled_date', $selectedDate ?? date('Y-m-d')) }}"
                                   x-model="scheduledDate"
                                   @change="onDateChange()"
                                   min="{{ date('Y-m-d') }}"
                                   required
                                   class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors @error('scheduled_date') border-danger-500 @enderror">
                            @error('scheduled_date')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="scheduled_time" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                Horário <span class="text-danger-500">*</span>
                            </label>
                            <select name="scheduled_time" 
                                    id="scheduled_time" 
                                    required
                                    x-model="scheduledTime"
                                    :disabled="!serviceId || !scheduledDate || loadingSlots"
                                    class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors @error('scheduled_time') border-danger-500 @enderror disabled:opacity-50">
                                <option value="">Selecione um horário</option>
                                <template x-for="slot in availableSlots" :key="slot">
                                    <option :value="slot" x-text="slot"></option>
                                </template>
                            </select>
                            <p x-show="loadingSlots" class="mt-2 text-sm text-dark-500 dark:text-dark-400">
                                <svg class="animate-spin inline h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Carregando horários...
                            </p>
                            <p x-show="!loadingSlots && serviceId && scheduledDate && availableSlots.length === 0" class="mt-2 text-sm text-warning-600 dark:text-warning-400">
                                <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Nenhum horário disponível para esta data
                            </p>
                            @error('scheduled_time')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            Status <span class="text-danger-500">*</span>
                        </label>
                        <select name="status" 
                                id="status" 
                                required
                                class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors @error('status') border-danger-500 @enderror">
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ old('status', 'pending') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            Observações
                        </label>
                        <textarea name="notes" 
                                  id="notes" 
                                  rows="3"
                                  class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('notes') border-danger-500 @enderror"
                                  placeholder="Informações adicionais sobre o agendamento...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.appointments.index') }}" 
                   class="inline-flex items-center justify-center rounded-xl border border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700 px-6 py-3 text-sm font-semibold text-dark-700 dark:text-dark-300 hover:bg-dark-50 dark:hover:bg-dark-600 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Criar Agendamento
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function appointmentForm() {
            return {
                serviceId: '{{ old('service_id', $selectedServiceId ?? '') }}',
                professionalId: '{{ old('professional_id', $selectedProfessionalId ?? '') }}',
                scheduledDate: '{{ old('scheduled_date', $selectedDate ?? date('Y-m-d')) }}',
                scheduledTime: '{{ old('scheduled_time', $selectedTime ?? '') }}',
                availableSlots: [],
                serviceProfessionals: [],
                allProfessionals: @json($professionals),
                loadingSlots: false,
                serviceName: '',
                servicePrice: '',
                serviceDuration: '',
                serviceColor: '',
                
                init() {
                    if (this.serviceId) {
                        this.updateServiceInfo();
                        this.loadProfessionalsForService();
                        if (this.scheduledDate) {
                            this.loadAvailableSlots();
                        }
                    }
                },
                
                onServiceChange() {
                    this.professionalId = '';
                    this.updateServiceInfo();
                    this.loadProfessionalsForService();
                    this.loadAvailableSlots();
                },
                
                onProfessionalChange() {
                    this.loadAvailableSlots();
                },
                
                onDateChange() {
                    this.loadAvailableSlots();
                },
                
                updateServiceInfo() {
                    const select = document.getElementById('service_id');
                    const option = select.options[select.selectedIndex];
                    if (option && option.value) {
                        this.serviceName = option.text.split(' - ')[0];
                        this.servicePrice = 'R$ ' + parseFloat(option.dataset.price).toFixed(2).replace('.', ',');
                        this.serviceDuration = option.dataset.duration;
                        this.serviceColor = option.dataset.color;
                    }
                },
                
                loadProfessionalsForService() {
                    const select = document.getElementById('service_id');
                    const option = select.options[select.selectedIndex];
                    if (option && option.value && option.dataset.professionals) {
                        const professionalIds = JSON.parse(option.dataset.professionals);
                        this.serviceProfessionals = this.allProfessionals.filter(p => professionalIds.includes(p.id));
                    } else {
                        this.serviceProfessionals = [];
                    }
                },
                
                async loadAvailableSlots() {
                    if (!this.serviceId || !this.scheduledDate) {
                        this.availableSlots = [];
                        return;
                    }
                    
                    this.loadingSlots = true;
                    this.availableSlots = [];
                    
                    try {
                        let url = `{{ route('admin.appointments.available-slots') }}?service_id=${this.serviceId}&date=${this.scheduledDate}`;
                        if (this.professionalId) {
                            url += `&professional_id=${this.professionalId}`;
                        }
                        
                        const response = await fetch(url);
                        const data = await response.json();
                        
                        if (data.available) {
                            this.availableSlots = data.slots;
                        }
                    } catch (error) {
                        console.error('Erro ao carregar horários:', error);
                    }
                    
                    this.loadingSlots = false;
                }
            };
        }
    </script>
    @endpush
</x-admin-layout>
