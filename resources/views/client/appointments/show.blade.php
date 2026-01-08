<x-client-layout>
    <x-slot name="header">Agendamento #{{ $appointment->id }}</x-slot>

    <div class="animate-fade-in space-y-6">
        <!-- Breadcrumb & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('client.appointments.index') }}" class="text-dark-500 dark:text-dark-400 hover:text-dark-700 dark:hover:text-white transition-colors">Agendamentos</a>
                <svg class="h-4 w-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-dark-900 dark:text-white font-medium">Detalhes</span>
            </nav>
            <div class="flex items-center gap-3">
                @if($appointment->canBeCancelled())
                    <button type="button" onclick="openCancelModal()" class="inline-flex items-center gap-2 rounded-xl bg-danger-50 dark:bg-danger-500/10 border border-danger-200 dark:border-danger-500/30 px-4 py-2.5 text-sm font-medium text-danger-600 dark:text-danger-400 hover:bg-danger-100 dark:hover:bg-danger-500/20 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancelar
                    </button>
                @endif
                <a href="{{ route('client.appointments.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-dark-100 dark:bg-dark-700 px-4 py-2.5 text-sm font-medium text-dark-600 dark:text-dark-300 hover:bg-dark-200 dark:hover:bg-dark-600 hover:text-dark-900 dark:hover:text-white transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Appointment Details -->
                <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                    <div class="p-6 border-b border-dark-100 dark:border-dark-700">
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white">Detalhes do Agendamento</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm text-dark-500 dark:text-dark-400">Serviço</dt>
                                <dd class="mt-1 flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $appointment->service?->color ?? '#6366f1' }}"></div>
                                    <span class="text-dark-900 dark:text-white font-medium">{{ $appointment->service?->name ?? 'Serviço removido' }}</span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm text-dark-500 dark:text-dark-400">Status</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium
                                        @if($appointment->status === 'confirmed') bg-success-100 dark:bg-success-500/20 text-success-700 dark:text-success-400
                                        @elseif($appointment->status === 'pending') bg-warning-100 dark:bg-warning-500/20 text-warning-700 dark:text-warning-400
                                        @elseif($appointment->status === 'completed') bg-primary-100 dark:bg-primary-500/20 text-primary-700 dark:text-primary-400
                                        @elseif($appointment->status === 'no_show') bg-dark-100 dark:bg-dark-500/20 text-dark-600 dark:text-dark-300
                                        @else bg-danger-100 dark:bg-danger-500/20 text-danger-700 dark:text-danger-400
                                        @endif">
                                        @if($appointment->status === 'confirmed') Confirmado
                                        @elseif($appointment->status === 'pending') Aguardando Confirmação
                                        @elseif($appointment->status === 'completed') Concluído
                                        @elseif($appointment->status === 'no_show') Não compareceu
                                        @else Cancelado
                                        @endif
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm text-dark-500 dark:text-dark-400">Data</dt>
                                <dd class="mt-1 text-dark-900 dark:text-white font-medium">
                                    {{ \Carbon\Carbon::parse($appointment->scheduled_date)->format('d/m/Y') }}
                                    <span class="text-dark-500 dark:text-dark-400 font-normal">
                                        ({{ \Carbon\Carbon::parse($appointment->scheduled_date)->translatedFormat('l') }})
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm text-dark-500 dark:text-dark-400">Horário</dt>
                                <dd class="mt-1 text-dark-900 dark:text-white font-medium">
                                    {{ \Carbon\Carbon::parse($appointment->scheduled_time)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm text-dark-500 dark:text-dark-400">Duração</dt>
                                <dd class="mt-1 text-dark-900 dark:text-white">{{ $appointment->service?->duration ?? '-' }} minutos</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-dark-500 dark:text-dark-400">Valor</dt>
                                <dd class="mt-1 text-xl font-bold text-primary-600 dark:text-primary-400">
                                    R$ {{ number_format($appointment->price, 2, ',', '.') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Service Description -->
                @if($appointment->service && $appointment->service->description)
                    <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-3">Sobre o Serviço</h3>
                        <p class="text-dark-600 dark:text-dark-300">{{ $appointment->service->description }}</p>
                    </div>
                @endif

                <!-- Notes -->
                @if($appointment->notes)
                    <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-3">Observações</h3>
                        <p class="text-dark-600 dark:text-dark-300">{{ $appointment->notes }}</p>
                    </div>
                @endif

                <!-- Cancellation Info -->
                @if($appointment->status === 'cancelled' && $appointment->cancellation_reason)
                    <div class="rounded-2xl border border-danger-200 dark:border-danger-500/30 bg-danger-50 dark:bg-danger-500/10 p-6">
                        <h3 class="text-lg font-semibold text-danger-700 dark:text-danger-400 mb-3">Motivo do Cancelamento</h3>
                        <p class="text-dark-600 dark:text-dark-300">{{ $appointment->cancellation_reason }}</p>
                        @if($appointment->cancelled_at)
                            <p class="text-sm text-dark-500 dark:text-dark-400 mt-2">
                                Cancelado em {{ \Carbon\Carbon::parse($appointment->cancelled_at)->format('d/m/Y H:i') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Timeline -->
                <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6">
                    <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-4">Histórico</h3>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-500/20 text-primary-600 dark:text-primary-400 flex-shrink-0">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-dark-900 dark:text-white">Agendamento criado</p>
                                <p class="text-xs text-dark-500 dark:text-dark-400">{{ $appointment->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if($appointment->confirmed_at)
                            <div class="flex gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-success-100 dark:bg-success-500/20 text-success-600 dark:text-success-400 flex-shrink-0">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-dark-900 dark:text-white">Confirmado</p>
                                    <p class="text-xs text-dark-500 dark:text-dark-400">{{ \Carbon\Carbon::parse($appointment->confirmed_at)->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($appointment->completed_at)
                            <div class="flex gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-500/20 text-primary-600 dark:text-primary-400 flex-shrink-0">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-dark-900 dark:text-white">Concluído</p>
                                    <p class="text-xs text-dark-500 dark:text-dark-400">{{ \Carbon\Carbon::parse($appointment->completed_at)->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($appointment->cancelled_at)
                            <div class="flex gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-danger-100 dark:bg-danger-500/20 text-danger-600 dark:text-danger-400 flex-shrink-0">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-dark-900 dark:text-white">Cancelado</p>
                                    <p class="text-xs text-dark-500 dark:text-dark-400">{{ \Carbon\Carbon::parse($appointment->cancelled_at)->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                @if($appointment->canBeCancelled())
                    <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-4">Ações</h3>
                        <button type="button" onclick="openCancelModal()" class="w-full flex items-center justify-center gap-2 rounded-xl bg-danger-50 dark:bg-danger-500/10 border border-danger-200 dark:border-danger-500/30 px-4 py-3 text-sm font-medium text-danger-600 dark:text-danger-400 hover:bg-danger-100 dark:hover:bg-danger-500/20 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancelar Agendamento
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Cancel Modal -->
    @if($appointment->canBeCancelled())
        <div id="cancelModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-dark-900/80 backdrop-blur-sm transition-opacity" onclick="closeCancelModal()"></div>
                <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>
                <div class="relative inline-block transform overflow-hidden rounded-2xl bg-white dark:bg-dark-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                    <form action="{{ route('client.appointments.cancel', $appointment) }}" method="POST">
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
            function openCancelModal() {
                document.getElementById('cancelModal').classList.remove('hidden');
            }

            function closeCancelModal() {
                document.getElementById('cancelModal').classList.add('hidden');
            }
        </script>
        @endpush
    @endif
</x-client-layout>
