<x-admin-layout>
    <x-slot name="header">Novo Profissional</x-slot>

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
            <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-dark-900 dark:text-white">Informações do Profissional</h2>
                <p class="text-sm text-dark-500 dark:text-dark-400">Preencha os dados para cadastrar um novo profissional.</p>
            </div>

            <form method="POST" action="{{ route('admin.professionals.store') }}" class="p-6">
                @csrf

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            Nome completo <span class="text-danger-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
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
                                   value="{{ old('email') }}"
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
                                   value="{{ old('phone') }}"
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
                                   value="{{ old('specialty') }}"
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
                                       value="{{ old('color', '#6366f1') }}"
                                       class="h-12 w-12 rounded-xl border-dark-200 dark:border-dark-600 cursor-pointer">
                                <input type="text" 
                                       id="color_text"
                                       value="{{ old('color', '#6366f1') }}"
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
                                  placeholder="Breve descrição sobre o profissional...">{{ old('bio') }}</textarea>
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
                                               {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                                               class="h-5 w-5 rounded border-dark-300 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 text-primary-500 focus:ring-primary-500">
                                        <div class="flex items-center gap-2">
                                            <span class="h-3 w-3 rounded-full" style="background-color: {{ $service->color }}"></span>
                                            <span class="text-sm font-medium text-dark-900 dark:text-white">{{ $service->name }}</span>
                                        </div>
                                        <span class="ml-auto text-sm text-dark-500 dark:text-dark-400">{{ $service->formatted_price }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <p class="mt-2 text-xs text-dark-500 dark:text-dark-400">
                                Você pode configurar preços e horários específicos depois de criar o profissional.
                            </p>
                        </div>
                    @endif

                    <!-- Status -->
                    <div class="flex items-center gap-3 border-t border-dark-100 dark:border-dark-700 pt-6">
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   class="peer sr-only" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
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
                        Criar Profissional
                    </button>
                </div>
            </form>
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

