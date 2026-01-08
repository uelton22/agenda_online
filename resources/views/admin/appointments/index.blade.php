<x-admin-layout>
    <x-slot name="header">Agendamentos</x-slot>

    <div class="animate-fade-in">
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-4 md:p-6">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="flex h-10 w-10 md:h-12 md:w-12 items-center justify-center rounded-xl bg-primary-100 dark:bg-primary-500/20 flex-shrink-0">
                        <svg class="h-5 w-5 md:h-6 md:w-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xl md:text-2xl font-bold text-dark-900 dark:text-white">{{ $stats['today'] }}</p>
                        <p class="text-xs md:text-sm text-dark-500 dark:text-dark-400">Hoje</p>
                    </div>
                </div>
            </div>
            
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-4 md:p-6">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="flex h-10 w-10 md:h-12 md:w-12 items-center justify-center rounded-xl bg-warning-100 dark:bg-warning-500/20 flex-shrink-0">
                        <svg class="h-5 w-5 md:h-6 md:w-6 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xl md:text-2xl font-bold text-dark-900 dark:text-white">{{ $stats['pending'] }}</p>
                        <p class="text-xs md:text-sm text-dark-500 dark:text-dark-400">Pendentes</p>
                    </div>
                </div>
            </div>
            
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-4 md:p-6">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="flex h-10 w-10 md:h-12 md:w-12 items-center justify-center rounded-xl bg-info-100 dark:bg-info-500/20 flex-shrink-0">
                        <svg class="h-5 w-5 md:h-6 md:w-6 text-info-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xl md:text-2xl font-bold text-dark-900 dark:text-white">{{ $stats['confirmed'] }}</p>
                        <p class="text-xs md:text-sm text-dark-500 dark:text-dark-400">Confirmados</p>
                    </div>
                </div>
            </div>
            
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-4 md:p-6">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="flex h-10 w-10 md:h-12 md:w-12 items-center justify-center rounded-xl bg-success-100 dark:bg-success-500/20 flex-shrink-0">
                        <svg class="h-5 w-5 md:h-6 md:w-6 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xl md:text-2xl font-bold text-dark-900 dark:text-white">{{ $stats['completed_month'] }}</p>
                        <p class="text-xs md:text-sm text-dark-500 dark:text-dark-400 truncate">Concluídos (mês)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
            <!-- Header -->
            <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-dark-900 dark:text-white">Lista de Agendamentos</h2>
                        <p class="text-sm text-dark-500 dark:text-dark-400">Gerencie todos os agendamentos do sistema</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.calendar.index') }}" 
                           class="inline-flex items-center gap-2 rounded-xl border border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700 px-4 py-2.5 text-sm font-semibold text-dark-700 dark:text-dark-300 hover:bg-dark-50 dark:hover:bg-dark-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Ver Calendário
                        </a>
                        <a href="{{ route('admin.appointments.create') }}" 
                           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-0.5">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Novo Agendamento
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 bg-dark-50 dark:bg-dark-700/50">
                <form method="GET" action="{{ route('admin.appointments.index') }}" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1">Buscar</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nome, CPF ou telefone do cliente..."
                               class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700 px-4 py-2 text-sm text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div class="w-40">
                        <label class="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1">Status</label>
                        <select name="status" class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700 px-4 py-2 text-sm text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Todos</option>
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-48">
                        <label class="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1">Serviço</label>
                        <select name="service_id" class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700 px-4 py-2 text-sm text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Todos</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-40">
                        <label class="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1">Período</label>
                        <select name="period" class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700 px-4 py-2 text-sm text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Todos</option>
                            <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Hoje</option>
                            <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Esta semana</option>
                            <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Este mês</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-dark-100 dark:bg-dark-600 px-4 py-2 text-sm font-medium text-dark-700 dark:text-dark-300 hover:bg-dark-200 dark:hover:bg-dark-500 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Filtrar
                        </button>
                        @if(request()->hasAny(['search', 'status', 'service_id', 'period']))
                            <a href="{{ route('admin.appointments.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-dark-100 dark:bg-dark-600 px-4 py-2 text-sm font-medium text-dark-700 dark:text-dark-300 hover:bg-dark-200 dark:hover:bg-dark-500 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Limpar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-dark-100 dark:border-dark-700 bg-dark-50 dark:bg-dark-700/50">
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Data/Hora</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Serviço</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-100 dark:divide-dark-700">
                        @forelse($appointments as $appointment)
                            <tr class="hover:bg-dark-50 dark:hover:bg-dark-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-dark-100 dark:bg-dark-700">
                                            <svg class="h-5 w-5 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-dark-900 dark:text-white">{{ $appointment->formatted_date }}</p>
                                            <p class="text-sm text-dark-500 dark:text-dark-400">{{ $appointment->time_range }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <p class="font-medium text-dark-900 dark:text-white">{{ $appointment->client?->full_name ?? 'Cliente removido' }}</p>
                                        <p class="text-sm text-dark-500 dark:text-dark-400">{{ $appointment->client?->formatted_phone ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="h-3 w-3 rounded-full" style="background-color: {{ $appointment->service?->color ?? '#6B7280' }}"></span>
                                        <span class="text-dark-900 dark:text-white">{{ $appointment->service?->name ?? 'Serviço removido' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-medium text-dark-900 dark:text-white">{{ $appointment->formatted_price }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium" style="background-color: {{ $appointment->status_color }}20; color: {{ $appointment->status_color }}">
                                        {{ $appointment->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($appointment->canBeEdited())
                                            <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                                               class="rounded-lg p-2 text-dark-400 hover:bg-dark-100 dark:hover:bg-dark-700 hover:text-dark-600 dark:hover:text-dark-200 transition-colors"
                                               title="Editar">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        @endif
                                        
                                        <!-- Status dropdown -->
                                        <div x-data="{ 
                                            open: false,
                                            toggle() {
                                                this.open = !this.open;
                                                if (this.open) {
                                                    this.$nextTick(() => this.positionDropdown());
                                                }
                                            },
                                            positionDropdown() {
                                                const btn = this.$refs.btn;
                                                const dropdown = this.$refs.dropdown;
                                                const rect = btn.getBoundingClientRect();
                                                const spaceBelow = window.innerHeight - rect.bottom;
                                                const dropdownHeight = dropdown.offsetHeight;
                                                
                                                dropdown.style.position = 'fixed';
                                                dropdown.style.right = (window.innerWidth - rect.right) + 'px';
                                                
                                                if (spaceBelow < dropdownHeight + 10) {
                                                    dropdown.style.top = (rect.top - dropdownHeight - 5) + 'px';
                                                } else {
                                                    dropdown.style.top = (rect.bottom + 5) + 'px';
                                                }
                                            }
                                        }" 
                                        @scroll.window="if(open) positionDropdown()"
                                        @resize.window="if(open) positionDropdown()"
                                        class="relative">
                                            <button x-ref="btn"
                                                    @click="toggle()" 
                                                    class="rounded-lg p-2 text-dark-400 hover:bg-dark-100 dark:hover:bg-dark-700 hover:text-dark-600 dark:hover:text-dark-200 transition-colors"
                                                    title="Alterar status">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                </svg>
                                            </button>
                                            <div x-ref="dropdown"
                                                 x-show="open" 
                                                 @click.away="open = false"
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="opacity-0 scale-95"
                                                 x-transition:enter-end="opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="opacity-100 scale-100"
                                                 x-transition:leave-end="opacity-0 scale-95"
                                                 class="w-52 rounded-xl bg-white dark:bg-dark-800 shadow-xl ring-1 ring-dark-200 dark:ring-dark-700 z-[9999]"
                                                 style="position: fixed;">
                                                <div class="py-2">
                                                    @foreach($statuses as $key => $label)
                                                        @if($key !== $appointment->status)
                                                            <form method="POST" action="{{ route('admin.appointments.update-status', $appointment) }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="{{ $key }}">
                                                                <button type="submit" class="w-full px-4 py-2.5 text-left text-sm text-dark-700 dark:text-dark-300 hover:bg-dark-100 dark:hover:bg-dark-700 transition-colors">
                                                                    Marcar como {{ $label }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <form method="POST" 
                                              action="{{ route('admin.appointments.destroy', $appointment) }}"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="rounded-lg p-2 text-dark-400 hover:bg-danger-100 dark:hover:bg-danger-500/20 hover:text-danger-600 transition-colors"
                                                    title="Excluir">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-dark-100 dark:bg-dark-700 mb-4">
                                            <svg class="h-8 w-8 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-dark-500 dark:text-dark-400 mb-2">Nenhum agendamento encontrado</p>
                                        <a href="{{ route('admin.appointments.create') }}" class="text-primary-500 hover:text-primary-600 font-medium">
                                            Criar primeiro agendamento
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($appointments->hasPages())
                <div class="border-t border-dark-100 dark:border-dark-700 px-6 py-4">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

