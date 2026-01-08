<x-admin-layout>
    <x-slot name="header">Gerenciar Serviços</x-slot>

    <div class="animate-fade-in">
        <!-- Header with actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <p class="text-dark-500 dark:text-dark-400">
                    Configure os serviços oferecidos e seus horários de atendimento
                </p>
            </div>
            <a href="{{ route('admin.services.create') }}" 
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Novo Serviço
            </a>
        </div>

        <!-- Filters -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 p-6 shadow-soft mb-6">
            <form method="GET" action="{{ route('admin.services.index') }}" class="flex flex-col md:flex-row gap-4">
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
                               placeholder="Buscar por nome ou descrição..."
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
                </div>
            </form>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($services as $service)
                <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden group hover:shadow-lg transition-shadow">
                    <!-- Color Header -->
                    <div class="h-2" style="background-color: {{ $service->color }}"></div>
                    
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl text-white font-semibold text-sm" style="background-color: {{ $service->color }}">
                                    {{ $service->initials }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-dark-900 dark:text-white">{{ $service->name }}</h3>
                                    <span class="inline-flex items-center gap-1 text-xs {{ $service->is_active ? 'text-success-600 dark:text-success-400' : 'text-danger-600 dark:text-danger-400' }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $service->is_active ? 'bg-success-500' : 'bg-danger-500' }}"></span>
                                        {{ $service->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($service->description)
                            <p class="text-sm text-dark-500 dark:text-dark-400 mb-4 line-clamp-2">{{ $service->description }}</p>
                        @endif

                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="rounded-xl bg-dark-50 dark:bg-dark-700/50 p-3">
                                <p class="text-xs text-dark-500 dark:text-dark-400 mb-1">Preço</p>
                                <p class="font-semibold text-dark-900 dark:text-white">{{ $service->formatted_price }}</p>
                            </div>
                            <div class="rounded-xl bg-dark-50 dark:bg-dark-700/50 p-3">
                                <p class="text-xs text-dark-500 dark:text-dark-400 mb-1">Duração</p>
                                <p class="font-semibold text-dark-900 dark:text-white">{{ $service->formatted_duration }}</p>
                            </div>
                        </div>

                        <!-- Working Days -->
                        <div class="mb-4">
                            <p class="text-xs text-dark-500 dark:text-dark-400 mb-2">Dias de atendimento</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach(\App\Models\Service::SHORT_DAYS as $dayNum => $dayName)
                                    <span class="px-2 py-1 rounded-lg text-xs font-medium {{ in_array($dayNum, $service->working_days) ? 'bg-primary-100 dark:bg-primary-500/20 text-primary-700 dark:text-primary-400' : 'bg-dark-100 dark:bg-dark-700 text-dark-400' }}">
                                        {{ $dayName }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-dark-100 dark:border-dark-700">
                            <div class="flex items-center gap-2">
                                <!-- Toggle Status -->
                                <form method="POST" action="{{ route('admin.services.toggle-status', $service) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="rounded-lg p-2 text-dark-400 hover:bg-dark-100 dark:hover:bg-dark-700 hover:text-dark-600 dark:hover:text-dark-200 transition-colors"
                                            title="{{ $service->is_active ? 'Desativar' : 'Ativar' }}">
                                        @if($service->is_active)
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

                                <!-- Edit -->
                                <a href="{{ route('admin.services.edit', $service) }}" 
                                   class="rounded-lg p-2 text-dark-400 hover:bg-primary-100 dark:hover:bg-primary-500/20 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
                                   title="Editar">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <!-- Delete -->
                                <form method="POST" 
                                      action="{{ route('admin.services.destroy', $service) }}" 
                                      class="inline"
                                      x-data
                                      @submit.prevent="if(confirm('Tem certeza que deseja excluir este serviço?')) $el.submit()">
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

                            <span class="text-xs text-dark-400">
                                {{ $service->schedules->count() }} dia(s) configurado(s)
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-dark-100 dark:bg-dark-700">
                                <svg class="h-8 w-8 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <p class="mt-4 text-lg font-medium text-dark-900 dark:text-white">Nenhum serviço cadastrado</p>
                            <p class="mt-1 text-sm text-dark-500 dark:text-dark-400">Cadastre seu primeiro serviço para começar a receber agendamentos.</p>
                            <a href="{{ route('admin.services.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-primary-500 px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Cadastrar serviço
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
            <div class="mt-6">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>

