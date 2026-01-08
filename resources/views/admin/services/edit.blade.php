<x-admin-layout>
    <x-slot name="header">Editar Serviço</x-slot>

    <div class="animate-fade-in max-w-4xl" x-data="serviceEditForm()">
        <!-- Back link -->
        <div class="mb-6">
            <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-dark-500 dark:text-dark-400 hover:text-dark-700 dark:hover:text-dark-200 transition-colors">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar para lista
            </a>
        </div>

        <form method="POST" action="{{ route('admin.services.update', $service) }}" @submit="prepareSubmit">
            @csrf
            @method('PUT')

            <!-- Service Header -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden mb-6">
                <div class="h-2" style="background-color: {{ $service->color }}"></div>
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-xl text-white font-bold text-lg" style="background-color: {{ $service->color }}">
                            {{ $service->initials }}
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-dark-900 dark:text-white">{{ $service->name }}</h2>
                            <p class="text-sm text-dark-500 dark:text-dark-400">
                                {{ $service->formatted_price }} · {{ $service->formatted_duration }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            Nome do serviço <span class="text-danger-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $service->name) }}"
                               required
                               class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('name') border-danger-500 @enderror"
                               placeholder="Ex: Corte de Cabelo, Consulta, Massagem...">
                        @error('name')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            Descrição
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="3"
                                  class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('description') border-danger-500 @enderror"
                                  placeholder="Descreva o serviço...">{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price and Duration -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                Preço <span class="text-danger-500">*</span>
                            </label>
                            <input type="number" 
                                   name="price" 
                                   id="price" 
                                   value="{{ old('price', $service->price) }}"
                                   required
                                   step="0.01"
                                   min="0"
                                   class="block w-full rounded-xl border-gray-300 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('price') border-danger-500 @enderror"
                                   placeholder="R$ 0,00">
                            @error('price')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="duration" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                Duração (minutos) <span class="text-danger-500">*</span>
                            </label>
                            <select name="duration" 
                                    id="duration"
                                    x-model="duration"
                                    @change="updateAllSlots()"
                                    class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors @error('duration') border-danger-500 @enderror">
                                <option value="15" {{ old('duration', $service->duration) == 15 ? 'selected' : '' }}>15 minutos</option>
                                <option value="30" {{ old('duration', $service->duration) == 30 ? 'selected' : '' }}>30 minutos</option>
                                <option value="45" {{ old('duration', $service->duration) == 45 ? 'selected' : '' }}>45 minutos</option>
                                <option value="60" {{ old('duration', $service->duration) == 60 ? 'selected' : '' }}>1 hora</option>
                                <option value="90" {{ old('duration', $service->duration) == 90 ? 'selected' : '' }}>1h 30min</option>
                                <option value="120" {{ old('duration', $service->duration) == 120 ? 'selected' : '' }}>2 horas</option>
                                <option value="180" {{ old('duration', $service->duration) == 180 ? 'selected' : '' }}>3 horas</option>
                                <option value="240" {{ old('duration', $service->duration) == 240 ? 'selected' : '' }}>4 horas</option>
                            </select>
                            @error('duration')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="color" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                Cor <span class="text-danger-500">*</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <input type="color" 
                                       name="color" 
                                       id="color" 
                                       value="{{ old('color', $service->color) }}"
                                       class="h-12 w-12 rounded-lg border-0 cursor-pointer">
                                <div class="flex-1">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(['#6366F1', '#8B5CF6', '#EC4899', '#F43F5E', '#F97316', '#EAB308', '#22C55E', '#14B8A6', '#0EA5E9'] as $colorOption)
                                            <button type="button" 
                                                    onclick="document.getElementById('color').value = '{{ $colorOption }}'"
                                                    class="h-6 w-6 rounded-full transition-transform hover:scale-110"
                                                    style="background-color: {{ $colorOption }}"></button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @error('color')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   class="peer sr-only" 
                                   {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                            <div class="h-6 w-11 rounded-full bg-dark-200 dark:bg-dark-600 peer-checked:bg-primary-500 peer-focus:ring-4 peer-focus:ring-primary-500/25 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-dark-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white"></div>
                        </label>
                        <span class="text-sm font-medium text-dark-700 dark:text-dark-300">Serviço ativo</span>
                    </div>

                    <!-- Professionals Selection -->
                    @if($professionals->count() > 0)
                    <div class="pt-6 border-t border-dark-100 dark:border-dark-700">
                        <label class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-3">
                            Profissionais que realizam este serviço
                        </label>
                        <p class="text-sm text-dark-500 dark:text-dark-400 mb-4">
                            Selecione os profissionais que podem atender este serviço. Se nenhum for selecionado, o serviço estará disponível sem profissional específico.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($professionals as $professional)
                                <label class="relative flex items-center gap-3 p-3 rounded-xl border border-dark-200 dark:border-dark-700 hover:border-primary-500 dark:hover:border-primary-500 cursor-pointer transition-colors group">
                                    <input type="checkbox" 
                                           name="professionals[]" 
                                           value="{{ $professional->id }}"
                                           class="peer sr-only"
                                           {{ in_array($professional->id, old('professionals', $assignedProfessionals)) ? 'checked' : '' }}>
                                    <div class="h-10 w-10 rounded-lg flex items-center justify-center text-white text-sm font-bold flex-shrink-0" 
                                         style="background-color: {{ $professional->color }}">
                                        {{ $professional->initials }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-dark-900 dark:text-white truncate">{{ $professional->name }}</p>
                                        @if($professional->specialty)
                                            <p class="text-xs text-dark-500 dark:text-dark-400 truncate">{{ $professional->specialty }}</p>
                                        @endif
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="h-5 w-5 rounded-md border-2 border-dark-300 dark:border-dark-600 peer-checked:border-primary-500 peer-checked:bg-primary-500 flex items-center justify-center transition-colors">
                                            <svg class="h-3 w-3 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-primary-500 pointer-events-none"></div>
                                </label>
                            @endforeach
                        </div>
                        @if($service->professionals->count() > 0)
                        <div class="mt-4 p-3 rounded-xl bg-primary-50 dark:bg-primary-500/10 border border-primary-200 dark:border-primary-500/30">
                            <p class="text-sm text-primary-700 dark:text-primary-300">
                                <strong>{{ $service->professionals->count() }}</strong> profissional(is) vinculado(s) a este serviço
                            </p>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="pt-6 border-t border-dark-100 dark:border-dark-700">
                        <div class="p-4 rounded-xl bg-warning-50 dark:bg-warning-500/10 border border-warning-200 dark:border-warning-500/30">
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 text-warning-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-warning-800 dark:text-warning-200">Nenhum profissional cadastrado</p>
                                    <p class="text-sm text-warning-600 dark:text-warning-400 mt-1">
                                        <a href="{{ route('admin.professionals.create') }}" class="underline hover:no-underline">Cadastre profissionais</a> para vinculá-los a este serviço.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Schedule Configuration Card -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden mb-6">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white">Horários de Atendimento</h2>
                    <p class="text-sm text-dark-500 dark:text-dark-400">Configure os dias e selecione os horários disponíveis para este serviço.</p>
                </div>

                <div class="p-6">
                    @error('schedules')
                        <div class="mb-4 p-4 rounded-xl bg-danger-100 dark:bg-danger-500/20 text-danger-700 dark:text-danger-400">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="space-y-4">
                        @foreach($daysOfWeek as $dayNum => $dayName)
                            <div class="rounded-xl border border-dark-200 dark:border-dark-700 overflow-hidden"
                                 :class="{ 'border-primary-500 dark:border-primary-500': schedules[{{ $dayNum }}].enabled }">
                                <div class="flex items-center justify-between px-4 py-3 bg-dark-50 dark:bg-dark-700/50">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" 
                                               x-model="schedules[{{ $dayNum }}].enabled"
                                               @change="toggleDay({{ $dayNum }})"
                                               class="h-5 w-5 rounded border-dark-300 text-primary-500 focus:ring-primary-500">
                                        <span class="font-medium text-dark-900 dark:text-white">{{ $dayName }}</span>
                                    </label>
                                    <div x-show="schedules[{{ $dayNum }}].enabled" 
                                         x-cloak
                                         class="text-sm text-dark-500 dark:text-dark-400">
                                        <span x-text="schedules[{{ $dayNum }}].selectedSlots.length"></span>/<span x-text="schedules[{{ $dayNum }}].slots.length"></span> horários selecionados
                                    </div>
                                </div>
                                
                                <div x-show="schedules[{{ $dayNum }}].enabled" 
                                     x-transition
                                     class="p-4 border-t border-dark-200 dark:border-dark-700">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                                Início do atendimento
                                            </label>
                                            <input type="time" 
                                                   x-model="schedules[{{ $dayNum }}].start_time"
                                                   @change="updateSlots({{ $dayNum }})"
                                                   class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                                Fim do atendimento
                                            </label>
                                            <input type="time" 
                                                   x-model="schedules[{{ $dayNum }}].end_time"
                                                   @change="updateSlots({{ $dayNum }})"
                                                   class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors">
                                        </div>
                                    </div>
                                    
                                    <!-- Slots Selection -->
                                    <div x-show="schedules[{{ $dayNum }}].slots.length > 0" class="mt-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <label class="block text-sm font-medium text-dark-700 dark:text-dark-300">
                                                Selecione os horários disponíveis
                                            </label>
                                            <button type="button" 
                                                    @click="toggleSelectAll({{ $dayNum }})"
                                                    class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                                                <span x-show="!schedules[{{ $dayNum }}].selectAll">Selecionar todos</span>
                                                <span x-show="schedules[{{ $dayNum }}].selectAll">Desmarcar todos</span>
                                            </button>
                                        </div>
                                        <div class="flex flex-wrap gap-2 p-4 rounded-xl bg-dark-50 dark:bg-dark-700/50 max-h-48 overflow-y-auto">
                                            <template x-for="slot in schedules[{{ $dayNum }}].slots" :key="slot">
                                                <button type="button"
                                                        @click="toggleSlot({{ $dayNum }}, slot)"
                                                        :class="{
                                                            'bg-primary-500 text-white border-primary-500 shadow-md': isSlotSelected({{ $dayNum }}, slot),
                                                            'bg-white dark:bg-dark-600 text-dark-600 dark:text-dark-300 border-dark-200 dark:border-dark-500 hover:border-primary-300 hover:bg-primary-50 dark:hover:bg-primary-500/20': !isSlotSelected({{ $dayNum }}, slot)
                                                        }"
                                                        class="px-3 py-2 rounded-lg text-sm font-medium border-2 transition-all duration-200"
                                                        x-text="slot">
                                                </button>
                                            </template>
                                        </div>
                                        <p class="mt-2 text-xs text-dark-500 dark:text-dark-400">
                                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Clique nos horários para habilitar/desabilitar. Apenas horários selecionados estarão disponíveis para agendamento.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 flex flex-wrap gap-4">
                        <button type="button" 
                                @click="selectWeekdays()"
                                class="inline-flex items-center gap-2 rounded-xl bg-dark-100 dark:bg-dark-700 px-4 py-2 text-sm font-medium text-dark-700 dark:text-dark-300 hover:bg-dark-200 dark:hover:bg-dark-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Segunda a Sexta
                        </button>
                        <button type="button" 
                                @click="selectAllDays()"
                                class="inline-flex items-center gap-2 rounded-xl bg-dark-100 dark:bg-dark-700 px-4 py-2 text-sm font-medium text-dark-700 dark:text-dark-300 hover:bg-dark-200 dark:hover:bg-dark-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Todos os dias
                        </button>
                        <button type="button" 
                                @click="clearAllDays()"
                                class="inline-flex items-center gap-2 rounded-xl bg-dark-100 dark:bg-dark-700 px-4 py-2 text-sm font-medium text-dark-700 dark:text-dark-300 hover:bg-dark-200 dark:hover:bg-dark-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Limpar seleção
                        </button>
                    </div>
                </div>
            </div>

            <!-- Hidden inputs for schedules -->
            <template x-for="(schedule, dayNum) in schedules" :key="dayNum">
                <template x-if="schedule.enabled && schedule.selectedSlots.length > 0">
                    <div>
                        <input type="hidden" :name="'schedules[' + dayNum + '][day_of_week]'" :value="dayNum">
                        <input type="hidden" :name="'schedules[' + dayNum + '][start_time]'" :value="schedule.start_time">
                        <input type="hidden" :name="'schedules[' + dayNum + '][end_time]'" :value="schedule.end_time">
                        <input type="hidden" :name="'schedules[' + dayNum + '][is_active]'" value="1">
                        <!-- Send available_slots only if not all are selected -->
                        <template x-if="!schedule.selectAll">
                            <template x-for="(slot, idx) in schedule.selectedSlots" :key="idx">
                                <input type="hidden" :name="'schedules[' + dayNum + '][available_slots][]'" :value="slot">
                            </template>
                        </template>
                    </div>
                </template>
            </template>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.services.index') }}" 
                   class="inline-flex items-center justify-center rounded-xl border border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700 px-6 py-3 text-sm font-semibold text-dark-700 dark:text-dark-300 hover:bg-dark-50 dark:hover:bg-dark-600 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>

@push('scripts')
<script>
    function serviceEditForm() {
        return {
            duration: '{{ $service->duration }}',
            initializedDays: {},
            schedules: {
                0: { enabled: {{ isset($schedulesByDay[0]) ? 'true' : 'false' }}, start_time: '{{ isset($schedulesByDay[0]) ? $schedulesByDay[0]->formatted_start_time : '08:00' }}', end_time: '{{ isset($schedulesByDay[0]) ? $schedulesByDay[0]->formatted_end_time : '18:00' }}', slots: [], selectedSlots: [], savedSlots: {!! isset($schedulesByDay[0]) && $schedulesByDay[0]->available_slots ? json_encode($schedulesByDay[0]->available_slots) : 'null' !!}, selectAll: {{ isset($schedulesByDay[0]) && !$schedulesByDay[0]->available_slots ? 'true' : 'false' }} },
                1: { enabled: {{ isset($schedulesByDay[1]) ? 'true' : 'false' }}, start_time: '{{ isset($schedulesByDay[1]) ? $schedulesByDay[1]->formatted_start_time : '08:00' }}', end_time: '{{ isset($schedulesByDay[1]) ? $schedulesByDay[1]->formatted_end_time : '18:00' }}', slots: [], selectedSlots: [], savedSlots: {!! isset($schedulesByDay[1]) && $schedulesByDay[1]->available_slots ? json_encode($schedulesByDay[1]->available_slots) : 'null' !!}, selectAll: {{ isset($schedulesByDay[1]) && !$schedulesByDay[1]->available_slots ? 'true' : 'false' }} },
                2: { enabled: {{ isset($schedulesByDay[2]) ? 'true' : 'false' }}, start_time: '{{ isset($schedulesByDay[2]) ? $schedulesByDay[2]->formatted_start_time : '08:00' }}', end_time: '{{ isset($schedulesByDay[2]) ? $schedulesByDay[2]->formatted_end_time : '18:00' }}', slots: [], selectedSlots: [], savedSlots: {!! isset($schedulesByDay[2]) && $schedulesByDay[2]->available_slots ? json_encode($schedulesByDay[2]->available_slots) : 'null' !!}, selectAll: {{ isset($schedulesByDay[2]) && !$schedulesByDay[2]->available_slots ? 'true' : 'false' }} },
                3: { enabled: {{ isset($schedulesByDay[3]) ? 'true' : 'false' }}, start_time: '{{ isset($schedulesByDay[3]) ? $schedulesByDay[3]->formatted_start_time : '08:00' }}', end_time: '{{ isset($schedulesByDay[3]) ? $schedulesByDay[3]->formatted_end_time : '18:00' }}', slots: [], selectedSlots: [], savedSlots: {!! isset($schedulesByDay[3]) && $schedulesByDay[3]->available_slots ? json_encode($schedulesByDay[3]->available_slots) : 'null' !!}, selectAll: {{ isset($schedulesByDay[3]) && !$schedulesByDay[3]->available_slots ? 'true' : 'false' }} },
                4: { enabled: {{ isset($schedulesByDay[4]) ? 'true' : 'false' }}, start_time: '{{ isset($schedulesByDay[4]) ? $schedulesByDay[4]->formatted_start_time : '08:00' }}', end_time: '{{ isset($schedulesByDay[4]) ? $schedulesByDay[4]->formatted_end_time : '18:00' }}', slots: [], selectedSlots: [], savedSlots: {!! isset($schedulesByDay[4]) && $schedulesByDay[4]->available_slots ? json_encode($schedulesByDay[4]->available_slots) : 'null' !!}, selectAll: {{ isset($schedulesByDay[4]) && !$schedulesByDay[4]->available_slots ? 'true' : 'false' }} },
                5: { enabled: {{ isset($schedulesByDay[5]) ? 'true' : 'false' }}, start_time: '{{ isset($schedulesByDay[5]) ? $schedulesByDay[5]->formatted_start_time : '08:00' }}', end_time: '{{ isset($schedulesByDay[5]) ? $schedulesByDay[5]->formatted_end_time : '18:00' }}', slots: [], selectedSlots: [], savedSlots: {!! isset($schedulesByDay[5]) && $schedulesByDay[5]->available_slots ? json_encode($schedulesByDay[5]->available_slots) : 'null' !!}, selectAll: {{ isset($schedulesByDay[5]) && !$schedulesByDay[5]->available_slots ? 'true' : 'false' }} },
                6: { enabled: {{ isset($schedulesByDay[6]) ? 'true' : 'false' }}, start_time: '{{ isset($schedulesByDay[6]) ? $schedulesByDay[6]->formatted_start_time : '08:00' }}', end_time: '{{ isset($schedulesByDay[6]) ? $schedulesByDay[6]->formatted_end_time : '18:00' }}', slots: [], selectedSlots: [], savedSlots: {!! isset($schedulesByDay[6]) && $schedulesByDay[6]->available_slots ? json_encode($schedulesByDay[6]->available_slots) : 'null' !!}, selectAll: {{ isset($schedulesByDay[6]) && !$schedulesByDay[6]->available_slots ? 'true' : 'false' }} }
            },
            init() {
                this.initializeAllSlots();
            },
            initializeAllSlots() {
                for (let i = 0; i <= 6; i++) {
                    const schedule = this.schedules[i];
                    if (schedule && schedule.enabled && schedule.start_time && schedule.end_time) {
                        schedule.slots = this.generateSlots(schedule.start_time, schedule.end_time, this.duration);
                        
                        if (schedule.savedSlots && schedule.savedSlots.length > 0) {
                            schedule.selectedSlots = [...schedule.savedSlots];
                            schedule.selectAll = (schedule.selectedSlots.length === schedule.slots.length);
                        } else {
                            schedule.selectedSlots = [...schedule.slots];
                            schedule.selectAll = true;
                        }
                    }
                    this.initializedDays[i] = true;
                }
            },
            generateSlots(startTime, endTime, duration) {
                const slots = [];
                const start = this.timeToMinutes(startTime);
                const end = this.timeToMinutes(endTime);
                const durationInt = parseInt(duration);
                const lastSlot = end - durationInt;
                for (let time = start; time <= lastSlot; time += durationInt) {
                    slots.push(this.minutesToTime(time));
                }
                return slots;
            },
            timeToMinutes(time) {
                const [hours, minutes] = time.split(':').map(Number);
                return hours * 60 + minutes;
            },
            minutesToTime(minutes) {
                const hours = Math.floor(minutes / 60);
                const mins = minutes % 60;
                return hours.toString().padStart(2, '0') + ':' + mins.toString().padStart(2, '0');
            },
            updateSlots(dayNum) {
                const schedule = this.schedules[dayNum];
                if (schedule && schedule.enabled && schedule.start_time && schedule.end_time) {
                    const newSlots = this.generateSlots(schedule.start_time, schedule.end_time, this.duration);
                    schedule.slots = newSlots;
                    
                    if (this.initializedDays[dayNum]) {
                        if (schedule.selectAll) {
                            schedule.selectedSlots = [...newSlots];
                        } else {
                            schedule.selectedSlots = schedule.selectedSlots.filter(slot => newSlots.includes(slot));
                            if (schedule.selectedSlots.length === 0) {
                                schedule.selectedSlots = [...newSlots];
                                schedule.selectAll = true;
                            }
                        }
                    }
                } else if (schedule) {
                    schedule.slots = [];
                    schedule.selectedSlots = [];
                }
            },
            updateAllSlots() {
                for (let i = 0; i <= 6; i++) {
                    this.updateSlots(i);
                }
            },
            toggleDay(dayNum) {
                const schedule = this.schedules[dayNum];
                if (schedule.enabled) {
                    schedule.selectAll = true;
                }
                this.updateSlots(dayNum);
            },
            toggleSlot(dayNum, slot) {
                const schedule = this.schedules[dayNum];
                const index = schedule.selectedSlots.indexOf(slot);
                if (index > -1) {
                    schedule.selectedSlots.splice(index, 1);
                    schedule.selectAll = false;
                } else {
                    schedule.selectedSlots.push(slot);
                    schedule.selectedSlots.sort();
                    if (schedule.selectedSlots.length === schedule.slots.length) {
                        schedule.selectAll = true;
                    }
                }
            },
            isSlotSelected(dayNum, slot) {
                return this.schedules[dayNum].selectedSlots.includes(slot);
            },
            selectAllSlots(dayNum) {
                const schedule = this.schedules[dayNum];
                schedule.selectedSlots = [...schedule.slots];
                schedule.selectAll = true;
            },
            deselectAllSlots(dayNum) {
                const schedule = this.schedules[dayNum];
                schedule.selectedSlots = [];
                schedule.selectAll = false;
            },
            toggleSelectAll(dayNum) {
                const schedule = this.schedules[dayNum];
                if (schedule.selectAll) {
                    this.deselectAllSlots(dayNum);
                } else {
                    this.selectAllSlots(dayNum);
                }
            },
            selectWeekdays() {
                for (let i = 0; i <= 6; i++) {
                    this.schedules[i].enabled = (i >= 1 && i <= 5);
                    if (this.schedules[i].enabled) {
                        this.schedules[i].selectAll = true;
                    }
                    this.updateSlots(i);
                }
            },
            selectAllDays() {
                for (let i = 0; i <= 6; i++) {
                    this.schedules[i].enabled = true;
                    this.schedules[i].selectAll = true;
                    this.updateSlots(i);
                }
            },
            clearAllDays() {
                for (let i = 0; i <= 6; i++) {
                    this.schedules[i].enabled = false;
                    this.schedules[i].slots = [];
                    this.schedules[i].selectedSlots = [];
                }
            },
            hasEnabledDays() {
                for (let i = 0; i <= 6; i++) {
                    if (this.schedules[i].enabled) return true;
                }
                return false;
            },
            hasSelectedSlots(dayNum) {
                return this.schedules[dayNum].selectedSlots.length > 0;
            },
            prepareSubmit(e) {
                if (!this.hasEnabledDays()) {
                    e.preventDefault();
                    alert('Configure pelo menos um dia de atendimento.');
                    return false;
                }
                for (let i = 0; i <= 6; i++) {
                    if (this.schedules[i].enabled && this.schedules[i].selectedSlots.length === 0) {
                        e.preventDefault();
                        alert('Selecione pelo menos um horário para cada dia habilitado.');
                        return false;
                    }
                }
                return true;
            }
        };
    }
</script>
@endpush

</x-admin-layout>
