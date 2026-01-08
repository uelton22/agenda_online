<x-admin-layout>
    <x-slot name="header">Gerenciar Profissionais</x-slot>

    <div class="animate-fade-in">
        <!-- Header with actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <p class="text-dark-500 dark:text-dark-400">
                    Gerencie os profissionais que realizam os serviços
                </p>
            </div>
            <a href="{{ route('admin.professionals.create') }}" 
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Novo Profissional
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
            <form method="GET" action="{{ route('admin.professionals.index') }}" class="flex flex-col md:flex-row gap-4">
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
                               placeholder="Buscar por nome, e-mail, telefone ou especialidade..."
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
                        <a href="{{ route('admin.professionals.index') }}" 
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

        <!-- Professionals Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($professionals as $professional)
                <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                    <!-- Header with color -->
                    <div class="h-3" style="background-color: {{ $professional->color }}"></div>
                    
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <img src="{{ $professional->avatar_url }}" 
                                 alt="{{ $professional->name }}" 
                                 class="h-16 w-16 rounded-full object-cover ring-4 ring-white dark:ring-dark-700 shadow-lg">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-dark-900 dark:text-white truncate">
                                    {{ $professional->name }}
                                </h3>
                                @if($professional->specialty)
                                    <p class="text-sm text-primary-500">{{ $professional->specialty }}</p>
                                @endif
                                <p class="text-sm text-dark-500 dark:text-dark-400 truncate">{{ $professional->email }}</p>
                            </div>
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium 
                                {{ $professional->is_active ? 'bg-success-100 dark:bg-success-500/20 text-success-700 dark:text-success-400' : 'bg-danger-100 dark:bg-danger-500/20 text-danger-700 dark:text-danger-400' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $professional->is_active ? 'bg-success-500' : 'bg-danger-500' }}"></span>
                                {{ $professional->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>

                        @if($professional->phone)
                            <p class="mt-3 text-sm text-dark-600 dark:text-dark-400">
                                <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $professional->phone }}
                            </p>
                        @endif

                        <!-- Stats -->
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div class="text-center p-3 rounded-xl bg-dark-50 dark:bg-dark-700/50">
                                <p class="text-2xl font-bold text-dark-900 dark:text-white">{{ $professional->services_count }}</p>
                                <p class="text-xs text-dark-500 dark:text-dark-400">Serviços</p>
                            </div>
                            <div class="text-center p-3 rounded-xl bg-dark-50 dark:bg-dark-700/50">
                                <p class="text-2xl font-bold text-dark-900 dark:text-white">{{ $professional->appointments_count }}</p>
                                <p class="text-xs text-dark-500 dark:text-dark-400">Agendamentos</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 flex items-center justify-end gap-2">
                            <form method="POST" action="{{ route('admin.professionals.toggle-status', $professional) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="rounded-lg p-2 text-dark-400 hover:bg-dark-100 dark:hover:bg-dark-700 hover:text-dark-600 dark:hover:text-dark-200 transition-colors"
                                        title="{{ $professional->is_active ? 'Desativar' : 'Ativar' }}">
                                    @if($professional->is_active)
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

                            <a href="{{ route('admin.professionals.edit', $professional) }}" 
                               class="rounded-lg p-2 text-dark-400 hover:bg-primary-100 dark:hover:bg-primary-500/20 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
                               title="Editar">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                            <form method="POST" 
                                  action="{{ route('admin.professionals.destroy', $professional) }}" 
                                  class="inline"
                                  x-data
                                  @submit.prevent="if(confirm('Tem certeza que deseja excluir este profissional?')) $el.submit()">
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
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-dark-100 dark:bg-dark-700">
                                <svg class="h-8 w-8 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="mt-4 text-lg font-medium text-dark-900 dark:text-white">Nenhum profissional encontrado</p>
                            <p class="mt-1 text-sm text-dark-500 dark:text-dark-400">Tente ajustar os filtros ou criar um novo profissional.</p>
                            <a href="{{ route('admin.professionals.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-primary-500 px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Criar profissional
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($professionals->hasPages())
            <div class="mt-6">
                {{ $professionals->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>

