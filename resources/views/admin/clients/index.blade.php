<x-admin-layout>
    <x-slot name="header">Gerenciar Clientes</x-slot>

    <div class="animate-fade-in">
        <!-- Header with actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <p class="text-dark-500 dark:text-dark-400">
                    Gerencie os clientes cadastrados no sistema
                </p>
            </div>
            <a href="{{ route('admin.clients.create') }}" 
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Novo Cliente
            </a>
        </div>

        <!-- Filters -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 p-6 shadow-soft mb-6">
            <form method="GET" action="{{ route('admin.clients.index') }}" class="flex flex-col md:flex-row gap-4">
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
                               placeholder="Buscar por nome, CPF, e-mail ou telefone..."
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

        <!-- Clients Table -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-dark-50 dark:bg-dark-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Cliente</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">CPF</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Telefone</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Cadastro</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-dark-500 dark:text-dark-400">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-100 dark:divide-dark-700">
                        @forelse($clients as $client)
                            <tr class="group hover:bg-dark-50 dark:hover:bg-dark-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 text-white font-semibold text-sm">
                                            {{ $client->initials }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-dark-900 dark:text-white">{{ $client->name }}</p>
                                            <p class="text-sm text-dark-500 dark:text-dark-400">{{ $client->email ?? 'Sem e-mail' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-mono text-dark-600 dark:text-dark-300">
                                    {{ $client->formatted_cpf }}
                                </td>
                                <td class="px-6 py-4 text-sm text-dark-600 dark:text-dark-300">
                                    {{ $client->formatted_phone ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium 
                                        {{ $client->is_active ? 'bg-success-100 dark:bg-success-500/20 text-success-700 dark:text-success-400' : 'bg-danger-100 dark:bg-danger-500/20 text-danger-700 dark:text-danger-400' }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $client->is_active ? 'bg-success-500' : 'bg-danger-500' }}"></span>
                                        {{ $client->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-dark-600 dark:text-dark-300">
                                    {{ $client->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Toggle Status -->
                                        <form method="POST" action="{{ route('admin.clients.toggle-status', $client) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="rounded-lg p-2 text-dark-400 hover:bg-dark-100 dark:hover:bg-dark-700 hover:text-dark-600 dark:hover:text-dark-200 transition-colors"
                                                    title="{{ $client->is_active ? 'Desativar' : 'Ativar' }}">
                                                @if($client->is_active)
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
                                        <a href="{{ route('admin.clients.edit', $client) }}" 
                                           class="rounded-lg p-2 text-dark-400 hover:bg-primary-100 dark:hover:bg-primary-500/20 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
                                           title="Editar">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <!-- Delete -->
                                        <form method="POST" 
                                              action="{{ route('admin.clients.destroy', $client) }}" 
                                              class="inline"
                                              x-data
                                              @submit.prevent="if(confirm('Tem certeza que deseja excluir este cliente?')) $el.submit()">
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-dark-100 dark:bg-dark-700">
                                            <svg class="h-8 w-8 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <p class="mt-4 text-lg font-medium text-dark-900 dark:text-white">Nenhum cliente encontrado</p>
                                        <p class="mt-1 text-sm text-dark-500 dark:text-dark-400">Tente ajustar os filtros ou cadastre um novo cliente.</p>
                                        <a href="{{ route('admin.clients.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-primary-500 px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 transition-colors">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Cadastrar cliente
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($clients->hasPages())
                <div class="border-t border-dark-100 dark:border-dark-700 px-6 py-4">
                    {{ $clients->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

