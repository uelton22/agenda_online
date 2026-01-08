<x-admin-layout>
    <x-slot name="header">Novo Administrador</x-slot>

    <div class="animate-fade-in max-w-3xl">
        <!-- Back link -->
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-dark-500 dark:text-dark-400 hover:text-dark-700 dark:hover:text-dark-200 transition-colors">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar para lista
            </a>
        </div>

        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
            <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-dark-900 dark:text-white">Informações do Administrador</h2>
                <p class="text-sm text-dark-500 dark:text-dark-400">Preencha os dados para criar um novo administrador do sistema.</p>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="p-6">
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

                    <!-- Password -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                Senha <span class="text-danger-500">*</span>
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   required
                                   class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('password') border-danger-500 @enderror"
                                   placeholder="Mínimo 8 caracteres">
                            @error('password')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                Confirmar senha <span class="text-danger-500">*</span>
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   required
                                   class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors"
                                   placeholder="Repita a senha">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   class="peer sr-only" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <div class="h-6 w-11 rounded-full bg-dark-200 dark:bg-dark-600 peer-checked:bg-primary-500 peer-focus:ring-4 peer-focus:ring-primary-500/25 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-dark-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white"></div>
                        </label>
                        <span class="text-sm font-medium text-dark-700 dark:text-dark-300">Administrador ativo</span>
                    </div>

                    <!-- Info Box -->
                    <div class="rounded-xl bg-primary-50 dark:bg-primary-500/10 border border-primary-200 dark:border-primary-500/20 p-4">
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-primary-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-primary-700 dark:text-primary-400">Privilégios de Administrador</p>
                                <p class="text-sm text-primary-600 dark:text-primary-300 mt-1">
                                    Este usuário terá acesso total ao sistema, incluindo gerenciamento de clientes, serviços, agendamentos e configurações.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex items-center justify-end gap-4 border-t border-dark-100 dark:border-dark-700 pt-6">
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center justify-center rounded-xl border border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700 px-6 py-3 text-sm font-semibold text-dark-700 dark:text-dark-300 hover:bg-dark-50 dark:hover:bg-dark-600 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-0.5">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Criar Administrador
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
