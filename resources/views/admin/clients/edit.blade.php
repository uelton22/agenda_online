<x-admin-layout>
    <x-slot name="header">Editar Cliente</x-slot>

    <div class="animate-fade-in max-w-3xl">
        <!-- Back link -->
        <div class="mb-6">
            <a href="{{ route('admin.clients.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-dark-500 dark:text-dark-400 hover:text-dark-700 dark:hover:text-dark-200 transition-colors">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar para lista
            </a>
        </div>

        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
            <!-- Client Header -->
            <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 text-white font-bold text-xl">
                        {{ $client->initials }}
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-dark-900 dark:text-white">{{ $client->name }}</h2>
                        <p class="text-sm text-dark-500 dark:text-dark-400">CPF: {{ $client->formatted_cpf }}</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium 
                                {{ $client->is_active ? 'bg-success-100 dark:bg-success-500/20 text-success-700 dark:text-success-400' : 'bg-danger-100 dark:bg-danger-500/20 text-danger-700 dark:text-danger-400' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $client->is_active ? 'bg-success-500' : 'bg-danger-500' }}"></span>
                                {{ $client->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.clients.update', $client) }}" class="p-6">
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
                               value="{{ old('name', $client->name) }}"
                               required
                               class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('name') border-danger-500 @enderror"
                               placeholder="Digite o nome completo do cliente">
                        @error('name')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CPF -->
                    <div>
                        <label for="cpf" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            CPF <span class="text-danger-500">*</span>
                        </label>
                        <input type="text" 
                               name="cpf" 
                               id="cpf" 
                               value="{{ old('cpf', $client->formatted_cpf) }}"
                               required
                               maxlength="14"
                               class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('cpf') border-danger-500 @enderror"
                               placeholder="000.000.000-00"
                               x-data
                               x-mask="999.999.999-99">
                        @error('cpf')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email and Phone -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                E-mail
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $client->email) }}"
                                   class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('email') border-danger-500 @enderror"
                                   placeholder="email@exemplo.com">
                            @error('email')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                Telefone
                            </label>
                            <input type="text" 
                                   name="phone" 
                                   id="phone" 
                                   value="{{ old('phone', $client->phone) }}"
                                   maxlength="15"
                                   class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('phone') border-danger-500 @enderror"
                                   placeholder="(00) 00000-0000"
                                   x-data
                                   x-mask:dynamic="$input.length > 14 ? '(99) 99999-9999' : '(99) 9999-9999'">
                            @error('phone')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
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
                                  placeholder="Informações adicionais sobre o cliente...">{{ old('notes', $client->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="flex items-center gap-3 border-t border-dark-100 dark:border-dark-700 pt-6">
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   class="peer sr-only" 
                                   {{ old('is_active', $client->is_active) ? 'checked' : '' }}>
                            <div class="h-6 w-11 rounded-full bg-dark-200 dark:bg-dark-600 peer-checked:bg-primary-500 peer-focus:ring-4 peer-focus:ring-primary-500/25 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-dark-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white"></div>
                        </label>
                        <span class="text-sm font-medium text-dark-700 dark:text-dark-300">Cliente ativo</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex items-center justify-end gap-4 border-t border-dark-100 dark:border-dark-700 pt-6">
                    <a href="{{ route('admin.clients.index') }}" 
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

        <!-- Additional Info -->
        <div class="mt-6 rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
            <div class="px-6 py-4 border-b border-dark-100 dark:border-dark-700">
                <h3 class="text-sm font-semibold text-dark-900 dark:text-white">Informações Adicionais</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-dark-500 dark:text-dark-400">Cadastrado em</dt>
                        <dd class="mt-1 text-sm font-medium text-dark-900 dark:text-white">
                            {{ $client->created_at->format('d/m/Y \à\s H:i') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-dark-500 dark:text-dark-400">Última atualização</dt>
                        <dd class="mt-1 text-sm font-medium text-dark-900 dark:text-white">
                            {{ $client->updated_at->format('d/m/Y \à\s H:i') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    @endpush
</x-admin-layout>

