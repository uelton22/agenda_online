<x-client-layout>
    <x-slot name="header">Meus Agendamentos</x-slot>

    <div class="animate-fade-in space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-dark-500 dark:text-dark-400">Gerencie seus agendamentos</p>
            </div>
            <a href="{{ route('client.appointments.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Novo Agendamento
            </a>
        </div>

        <!-- Filters -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-4">
            <form method="GET" action="{{ route('client.appointments.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Buscar por serviço..."
                           class="w-full rounded-xl border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700/50 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 py-2.5">
                </div>
                <div class="min-w-[150px]">
                    <select name="status" class="w-full rounded-xl border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700/50 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 py-2.5">
                        <option value="">Todos os status</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="min-w-[150px]">
                    <select name="service_id" class="w-full rounded-xl border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700/50 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 py-2.5">
                        <option value="">Todos os serviços</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="min-w-[150px]">
                    <select name="period" class="w-full rounded-xl border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700/50 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 py-2.5">
                        <option value="">Todos os períodos</option>
                        <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Hoje</option>
                        <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Esta semana</option>
                        <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Este mês</option>
                        <option value="upcoming" {{ request('period') === 'upcoming' ? 'selected' : '' }}>Próximos</option>
                        <option value="past" {{ request('period') === 'past' ? 'selected' : '' }}>Passados</option>
                    </select>
                </div>
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-dark-100 dark:bg-dark-700 px-4 py-2.5 text-sm font-medium text-dark-700 dark:text-white hover:bg-dark-200 dark:hover:bg-dark-600 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filtrar
                </button>
                @if(request()->hasAny(['search', 'status', 'service_id', 'period']))
                    <a href="{{ route('client.appointments.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-dark-50 dark:bg-dark-700/50 px-4 py-2.5 text-sm font-medium text-dark-500 dark:text-dark-300 hover:bg-dark-100 dark:hover:bg-dark-700 hover:text-dark-700 dark:hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Limpar
                    </a>
                @endif
            </form>
        </div>

        <!-- Appointments List -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-dark-50 dark:bg-dark-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-500 dark:text-dark-400 uppercase tracking-wider">Serviço</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-500 dark:text-dark-400 uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-500 dark:text-dark-400 uppercase tracking-wider">Horário</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-500 dark:text-dark-400 uppercase tracking-wider">Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-dark-500 dark:text-dark-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-dark-500 dark:text-dark-400 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-100 dark:divide-dark-700">
                        @forelse($appointments as $appointment)
                            <tr class="hover:bg-dark-50 dark:hover:bg-dark-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $appointment->service?->color ?? '#6366f1' }}"></div>
                                        <span class="font-medium text-dark-900 dark:text-white">{{ $appointment->service?->name ?? 'Serviço removido' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-dark-600 dark:text-dark-300">
                                    {{ \Carbon\Carbon::parse($appointment->scheduled_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-dark-600 dark:text-dark-300">
                                    {{ \Carbon\Carbon::parse($appointment->scheduled_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-dark-900 dark:text-white">
                                    R$ {{ number_format($appointment->price, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium
                                        @if($appointment->status === 'confirmed') bg-success-100 dark:bg-success-500/20 text-success-700 dark:text-success-400
                                        @elseif($appointment->status === 'pending') bg-warning-100 dark:bg-warning-500/20 text-warning-700 dark:text-warning-400
                                        @elseif($appointment->status === 'completed') bg-primary-100 dark:bg-primary-500/20 text-primary-700 dark:text-primary-400
                                        @elseif($appointment->status === 'no_show') bg-dark-100 dark:bg-dark-500/20 text-dark-600 dark:text-dark-300
                                        @else bg-danger-100 dark:bg-danger-500/20 text-danger-700 dark:text-danger-400
                                        @endif">
                                        @if($appointment->status === 'confirmed') Confirmado
                                        @elseif($appointment->status === 'pending') Pendente
                                        @elseif($appointment->status === 'completed') Concluído
                                        @elseif($appointment->status === 'no_show') Não compareceu
                                        @else Cancelado
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('client.appointments.show', $appointment) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-dark-100 dark:bg-dark-700/50 text-dark-500 dark:text-dark-300 hover:bg-dark-200 dark:hover:bg-dark-600 hover:text-dark-700 dark:hover:text-white transition-colors" title="Ver detalhes">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        @if($appointment->canBeCancelled())
                                            <button type="button" 
                                                    onclick="openCancelModal({{ $appointment->id }})"
                                                    class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-danger-50 dark:bg-danger-500/10 text-danger-600 dark:text-danger-400 hover:bg-danger-100 dark:hover:bg-danger-500/20 transition-colors" 
                                                    title="Cancelar">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="h-16 w-16 rounded-full bg-dark-100 dark:bg-dark-700 flex items-center justify-center mb-4">
                                            <svg class="h-8 w-8 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <p class="text-dark-500 dark:text-dark-400 text-lg">Nenhum agendamento encontrado</p>
                                        <p class="text-dark-400 dark:text-dark-500 text-sm mt-1">Que tal criar seu primeiro agendamento?</p>
                                        <a href="{{ route('client.appointments.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-primary-50 dark:bg-primary-500/20 px-4 py-2 text-sm font-medium text-primary-600 dark:text-primary-400 hover:bg-primary-100 dark:hover:bg-primary-500/30 transition-colors">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Novo Agendamento
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($appointments->hasPages())
                <div class="px-6 py-4 border-t border-dark-100 dark:border-dark-700">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Cancel Modal -->
    <div id="cancelModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-dark-900/80 backdrop-blur-sm transition-opacity"></div>
            <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>
            <div class="relative inline-block transform overflow-hidden rounded-2xl bg-white dark:bg-dark-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                <form id="cancelForm" method="POST">
                    @csrf
                    <div class="p-6">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-danger-50 dark:bg-danger-500/20 text-danger-600 dark:text-danger-400 mx-auto mb-4">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white text-center mb-2">Cancelar Agendamento</h3>
                        <p class="text-dark-500 dark:text-dark-400 text-center text-sm mb-6">Tem certeza que deseja cancelar este agendamento? Esta ação não pode ser desfeita.</p>
                        <div>
                            <label for="cancellation_reason" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">Motivo do cancelamento (opcional)</label>
                            <textarea id="cancellation_reason" name="cancellation_reason" rows="3" 
                                      class="w-full rounded-xl border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700/50 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500"
                                      placeholder="Informe o motivo do cancelamento..."></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 px-6 py-4 bg-dark-50 dark:bg-dark-700/30 border-t border-dark-100 dark:border-dark-700">
                        <button type="button" onclick="closeCancelModal()" class="rounded-xl px-4 py-2.5 text-sm font-medium text-dark-500 dark:text-dark-300 hover:text-dark-700 dark:hover:text-white transition-colors">
                            Voltar
                        </button>
                        <button type="submit" class="rounded-xl bg-danger-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-danger-600 transition-colors">
                            Cancelar Agendamento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openCancelModal(appointmentId) {
            const modal = document.getElementById('cancelModal');
            const form = document.getElementById('cancelForm');
            form.action = '{{ url('cliente/agendamentos') }}/' + appointmentId + '/cancelar';
            modal.classList.remove('hidden');
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancelModal');
            modal.classList.add('hidden');
        }
    </script>
    @endpush
</x-client-layout>
