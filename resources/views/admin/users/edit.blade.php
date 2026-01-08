<x-admin-layout>
    <x-slot name="header">Editar Administrador</x-slot>

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
            <!-- User Header -->
            <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-6">
                <div class="flex items-center gap-4">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                         class="h-16 w-16 rounded-full object-cover ring-4 ring-white dark:ring-dark-700 shadow-lg">
                    <div>
                        <h2 class="text-lg font-semibold text-dark-900 dark:text-white">{{ $user->name }}</h2>
                        <p class="text-sm text-dark-500 dark:text-dark-400">{{ $user->email }}</p>
                        <div class="mt-2 flex items-center gap-2">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-secondary-100 dark:bg-secondary-500/20 text-secondary-700 dark:text-secondary-400">
                                Administrador
                            </span>
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium 
                                {{ $user->is_active ? 'bg-success-100 dark:bg-success-500/20 text-success-700 dark:text-success-400' : 'bg-danger-100 dark:bg-danger-500/20 text-danger-700 dark:text-danger-400' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $user->is_active ? 'bg-success-500' : 'bg-danger-500' }}"></span>
                                {{ $user->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6">
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
                               value="{{ old('name', $user->name) }}"
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
                               value="{{ old('email', $user->email) }}"
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
                               value="{{ old('phone', $user->phone) }}"
                               class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('phone') border-danger-500 @enderror"
                               placeholder="(00) 00000-0000">
                        @error('phone')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="border-t border-dark-100 dark:border-dark-700 pt-6">
                        <p class="text-sm font-medium text-dark-700 dark:text-dark-300 mb-4">
                            Alterar Senha <span class="text-dark-400 font-normal">(deixe em branco para manter a atual)</span>
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                    Nova senha
                                </label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('password') border-danger-500 @enderror"
                                       placeholder="Mínimo 8 caracteres">
                                @error('password')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                    Confirmar nova senha
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors"
                                       placeholder="Repita a nova senha">
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    @if($user->id !== auth()->id())
                        <div class="flex items-center gap-3 border-t border-dark-100 dark:border-dark-700 pt-6">
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       class="peer sr-only" 
                                       {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                <div class="h-6 w-11 rounded-full bg-dark-200 dark:bg-dark-600 peer-checked:bg-primary-500 peer-focus:ring-4 peer-focus:ring-primary-500/25 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-dark-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white"></div>
                            </label>
                            <span class="text-sm font-medium text-dark-700 dark:text-dark-300">Administrador ativo</span>
                        </div>
                    @else
                        <input type="hidden" name="is_active" value="1">
                    @endif
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
                        <dt class="text-sm text-dark-500 dark:text-dark-400">Criado em</dt>
                        <dd class="mt-1 text-sm font-medium text-dark-900 dark:text-white">
                            {{ $user->created_at->format('d/m/Y \à\s H:i') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-dark-500 dark:text-dark-400">Último acesso</dt>
                        <dd class="mt-1 text-sm font-medium text-dark-900 dark:text-white">
                            @if($user->last_login_at)
                                {{ $user->last_login_at->format('d/m/Y \à\s H:i') }}
                                <span class="text-dark-400">({{ $user->last_login_at->diffForHumans() }})</span>
                            @else
                                <span class="text-dark-400">Nunca acessou</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-dark-500 dark:text-dark-400">IP do último acesso</dt>
                        <dd class="mt-1 text-sm font-medium text-dark-900 dark:text-white">
                            {{ $user->last_login_ip ?? '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-dark-500 dark:text-dark-400">E-mail verificado</dt>
                        <dd class="mt-1 text-sm font-medium text-dark-900 dark:text-white">
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center gap-1 text-success-600 dark:text-success-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Sim
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-danger-600 dark:text-danger-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Não
                                </span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-admin-layout>
