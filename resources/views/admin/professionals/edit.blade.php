<x-admin-layout>
    <x-slot name="header">Editar Profissional</x-slot>

    <div class="animate-fade-in max-w-3xl">
        <!-- Back link -->
        <div class="mb-6">
            <a href="{{ route('admin.professionals.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-dark-500 dark:text-dark-400 hover:text-dark-700 dark:hover:text-dark-200 transition-colors">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar para lista
            </a>
        </div>

        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
            <!-- Header with professional info -->
            <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-6">
                <div class="flex items-center gap-4">
                    <img src="{{ $professional->avatar_url }}" alt="{{ $professional->name }}" 
                         class="h-16 w-16 rounded-full object-cover ring-4 ring-white dark:ring-dark-700 shadow-lg">
                    <div>
                        <h2 class="text-lg font-semibold text-dark-900 dark:text-white">{{ $professional->name }}</h2>
                        <p class="text-sm text-dark-500 dark:text-dark-400">{{ $professional->email }}</p>
                        <div class="mt-2 flex items-center gap-2">
                            @if($professional->specialty)
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-primary-100 dark:bg-primary-500/20 text-primary-700 dark:text-primary-400">
                                    {{ $professional->specialty }}
                                </span>
                            @endif
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium 
                                {{ $professional->is_active ? 'bg-success-100 dark:bg-success-500/20 text-success-700 dark:text-success-400' : 'bg-danger-100 dark:bg-danger-500/20 text-danger-700 dark:text-danger-400' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $professional->is_active ? 'bg-success-500' : 'bg-danger-500' }}"></span>
                                {{ $professional->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.professionals.update', $professional) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            Nome completo <span class="text-danger-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $professional->name) }}"
                               required
                               class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('name') border-danger-500 @enderror"
                               placeholder="Digite o nome completo">
                        @error('name')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                E-mail <span class="text-danger-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $professional->email) }}"
                                   required
                                   class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('email') border-danger-500 @enderror"
                                   placeholder="email@exemplo.com">
                            @error('email')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                Telefone
                            </label>
                            <input type="text" 
                                   name="phone" 
                                   id="phone" 
                                   value="{{ old('phone', $professional->phone) }}"
                                   class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('phone') border-danger-500 @enderror"
                                   placeholder="(00) 00000-0000">
                            @error('phone')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Specialty -->
                        <div>
                            <label for="specialty" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                Especialidade
                            </label>
                            <input type="text" 
                                   name="specialty" 
                                   id="specialty" 
                                   value="{{ old('specialty', $professional->specialty) }}"
                                   class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('specialty') border-danger-500 @enderror"
                                   placeholder="Ex: Cabeleireiro, Massagista, etc.">
                            @error('specialty')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color -->
                        <div>
                            <label for="color" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                Cor no calendário <span class="text-danger-500">*</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <input type="color" 
                                       name="color" 
                                       id="color" 
                                       value="{{ old('color', $professional->color) }}"
                                       class="h-12 w-12 rounded-xl border-dark-200 dark:border-dark-600 cursor-pointer">
                                <input type="text" 
                                       id="color_text"
                                       value="{{ old('color', $professional->color) }}"
                                       readonly
                                       class="flex-1 rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors">
                            </div>
                            @error('color')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            Biografia
                        </label>
                        <textarea name="bio" 
                                  id="bio" 
                                  rows="3"
                                  class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('bio') border-danger-500 @enderror"
                                  placeholder="Breve descrição sobre o profissional...">{{ old('bio', $professional->bio) }}</textarea>
                        @error('bio')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Services -->
                    @if($services->count() > 0)
                        <div class="border-t border-dark-100 dark:border-dark-700 pt-6">
                            <label class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-4">
                                Serviços que o profissional realiza
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($services as $service)
                                    <label class="flex items-center gap-3 p-3 rounded-xl border border-dark-200 dark:border-dark-600 hover:border-primary-300 dark:hover:border-primary-500/50 cursor-pointer transition-colors">
                                        <input type="checkbox" 
                                               name="services[]" 
                                               value="{{ $service->id }}"
                                               {{ in_array($service->id, old('services', $professional->services->pluck('id')->toArray())) ? 'checked' : '' }}
                                               class="h-5 w-5 rounded border-dark-300 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 text-primary-500 focus:ring-primary-500">
                                        <div class="flex items-center gap-2">
                                            <span class="h-3 w-3 rounded-full" style="background-color: {{ $service->color }}"></span>
                                            <span class="text-sm font-medium text-dark-900 dark:text-white">{{ $service->name }}</span>
                                        </div>
                                        <span class="ml-auto text-sm text-dark-500 dark:text-dark-400">{{ $service->formatted_price }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Status -->
                    <div class="flex items-center gap-3 border-t border-dark-100 dark:border-dark-700 pt-6">
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   class="peer sr-only" 
                                   {{ old('is_active', $professional->is_active) ? 'checked' : '' }}>
                            <div class="h-6 w-11 rounded-full bg-dark-200 dark:bg-dark-600 peer-checked:bg-primary-500 peer-focus:ring-4 peer-focus:ring-primary-500/25 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-dark-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white"></div>
                        </label>
                        <span class="text-sm font-medium text-dark-700 dark:text-dark-300">Profissional ativo</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex items-center justify-end gap-4 border-t border-dark-100 dark:border-dark-700 pt-6">
                    <a href="{{ route('admin.professionals.index') }}" 
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

        <!-- Statistics -->
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100 dark:bg-primary-500/20">
                        <svg class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-dark-900 dark:text-white">{{ $professional->services->count() }}</p>
                        <p class="text-sm text-dark-500 dark:text-dark-400">Serviços</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-success-100 dark:bg-success-500/20">
                        <svg class="h-6 w-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-dark-900 dark:text-white">{{ $professional->today_appointments_count }}</p>
                        <p class="text-sm text-dark-500 dark:text-dark-400">Agendamentos hoje</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-secondary-100 dark:bg-secondary-500/20">
                        <svg class="h-6 w-6 text-secondary-600 dark:text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-dark-900 dark:text-white">{{ $professional->total_appointments_count }}</p>
                        <p class="text-sm text-dark-500 dark:text-dark-400">Total de agendamentos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Color picker sync
        document.getElementById('color').addEventListener('input', function(e) {
            document.getElementById('color_text').value = e.target.value;
        });
    </script>
    @endpush
</x-admin-layout>

