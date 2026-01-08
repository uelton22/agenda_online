<x-admin-layout>
    <x-slot name="header">Gerenciar Administradores</x-slot>

    <div class="animate-fade-in">
        <!-- Header with actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <p class="text-dark-500 dark:text-dark-400">
                    Gerencie os administradores do sistema
                </p>
            </div>
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Novo Administrador
            </a>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-6 rounded-xl bg-success-500/10 border border-success-500/20 p-4">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-success-300">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-xl bg-danger-500/10 border border-danger-500/20 p-4">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-danger-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-danger-300">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Filters -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 p-6 shadow-soft mb-6">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="h-5 w-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" 
                               name="search" 
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Buscar por nome, e-mail ou telefone..."
                               class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 pl-11 pr-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors">
                    </div>
                </div>
                <div class="flex gap-4">
                    <select name="status" 
                            class="rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors">
                        <option value="">Todos os status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativo</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inativo</option>
                    </select>
                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-dark-100 dark:bg-dark-700 px-5 py-3 text-sm font-medium text-dark-700 dark:text-dark-300 hover:bg-dark-200 dark:hover:bg-dark-600 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filtrar
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.users.index') }}" 
                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-dark-100 dark:bg-dark-700 px-5 py-3 text-sm font-medium text-dark-700 dark:text-dark-300 hover:bg-dark-200 dark:hover:bg-dark-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Limpar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-dark-50 dark:bg-dark-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Administrador</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Telefone</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Último Acesso</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-100 dark:divide-dark-700">
                        @forelse($users as $user)
                            <tr class="group hover:bg-dark-50 dark:hover:bg-dark-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                             class="h-11 w-11 rounded-full object-cover ring-2 ring-white dark:ring-dark-700 shadow">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <p class="font-semibold text-dark-900 dark:text-white">{{ $user->name }}</p>
                                                @if($user->id === auth()->id())
                                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-primary-100 dark:bg-primary-500/20 text-primary-700 dark:text-primary-400">
                                                        Você
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-dark-500 dark:text-dark-400">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-dark-600 dark:text-dark-300">
                                    {{ $user->phone ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium 
                                        {{ $user->is_active ? 'bg-success-100 dark:bg-success-500/20 text-success-700 dark:text-success-400' : 'bg-danger-100 dark:bg-danger-500/20 text-danger-700 dark:text-danger-400' }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $user->is_active ? 'bg-success-500' : 'bg-danger-500' }}"></span>
                                        {{ $user->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-dark-600 dark:text-dark-300">
                                    @if($user->last_login_at)
                                        <span title="{{ $user->last_login_at->format('d/m/Y H:i:s') }}">
                                            {{ $user->last_login_at->diffForHumans() }}
                                        </span>
                                    @else
                                        <span class="text-dark-400">Nunca</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Toggle Status -->
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="rounded-lg p-2 text-dark-400 hover:bg-dark-100 dark:hover:bg-dark-700 hover:text-dark-600 dark:hover:text-dark-200 transition-colors"
                                                        title="{{ $user->is_active ? 'Desativar' : 'Ativar' }}">
                                                    @if($user->is_active)
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Edit -->
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="rounded-lg p-2 text-dark-400 hover:bg-primary-100 dark:hover:bg-primary-500/20 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
                                           title="Editar">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <!-- Delete -->
                                        @if($user->id !== auth()->id())
                                            <form method="POST" 
                                                  action="{{ route('admin.users.destroy', $user) }}" 
                                                  class="inline"
                                                  x-data
                                                  @submit.prevent="if(confirm('Tem certeza que deseja excluir este administrador?')) $el.submit()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="rounded-lg p-2 text-dark-400 hover:bg-danger-100 dark:hover:bg-danger-500/20 hover:text-danger-600 dark:hover:text-danger-400 transition-colors"
                                                        title="Excluir">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-dark-100 dark:bg-dark-700">
                                            <svg class="h-8 w-8 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <p class="mt-4 text-lg font-medium text-dark-900 dark:text-white">Nenhum administrador encontrado</p>
                                        <p class="mt-1 text-sm text-dark-500 dark:text-dark-400">Tente ajustar os filtros ou criar um novo administrador.</p>
                                        <a href="{{ route('admin.users.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-primary-500 px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 transition-colors">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Criar administrador
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="border-t border-dark-100 dark:border-dark-700 px-6 py-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
