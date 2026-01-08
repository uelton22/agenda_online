<x-admin-layout>
    <x-slot name="header">Tokens de API</x-slot>

    <div class="animate-fade-in">
        <!-- Header with actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <p class="text-dark-500 dark:text-dark-400">
                    Gerencie seus tokens de acesso à API
                </p>
            </div>
            <a href="{{ route('admin.api.documentation') }}" 
               class="inline-flex items-center justify-center gap-2 rounded-xl border border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700 px-5 py-2.5 text-sm font-semibold text-dark-700 dark:text-dark-300 hover:bg-dark-50 dark:hover:bg-dark-600 transition-colors">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Ver Documentação
            </a>
        </div>

        <!-- New Token Alert -->
        @if(session('newToken'))
            <div class="mb-6 rounded-2xl bg-success-50 dark:bg-success-500/10 border border-success-200 dark:border-success-500/20 p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-success-100 dark:bg-success-500/20 flex-shrink-0">
                        <svg class="h-6 w-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-success-800 dark:text-success-300">
                            Token "{{ session('tokenName') }}" criado com sucesso!
                        </h3>
                        <p class="mt-1 text-sm text-success-700 dark:text-success-400">
                            Copie o token abaixo. <strong>Por segurança, ele não será exibido novamente.</strong>
                        </p>
                        <div class="mt-4 flex items-center gap-2">
                            <code id="newToken" class="flex-1 rounded-lg bg-dark-800 border border-dark-600 px-4 py-3 text-sm font-mono text-emerald-400 break-all select-all">
                                {{ session('newToken') }}
                            </code>
                            <button onclick="copyToken()" 
                                    class="flex-shrink-0 rounded-lg bg-success-600 px-4 py-3 text-sm font-medium text-white hover:bg-success-700 transition-colors"
                                    title="Copiar token">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function copyToken() {
                    const token = document.getElementById('newToken').textContent;
                    navigator.clipboard.writeText(token).then(() => {
                        alert('Token copiado para a área de transferência!');
                    });
                }
            </script>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Create Token Form -->
            <div class="lg:col-span-1">
                <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                    <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4">
                        <h2 class="text-lg font-semibold text-dark-900 dark:text-white">Criar Novo Token</h2>
                        <p class="text-sm text-dark-500 dark:text-dark-400">Gere uma nova credencial de acesso</p>
                    </div>

                    <form method="POST" action="{{ route('admin.api.tokens.store') }}" class="p-6">
                        @csrf

                        <div class="space-y-4">
                            <!-- Token Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                    Nome do Token <span class="text-danger-500">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       required
                                       class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('name') border-danger-500 @enderror"
                                       placeholder="Ex: n8n Integration">
                                @error('name')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-dark-400">Identifique o token para referência futura</p>
                            </div>

                            <!-- Expiration -->
                            <div>
                                <label for="expires_at" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                                    Expiração
                                </label>
                                <select name="expires_at" 
                                        id="expires_at"
                                        class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 px-4 py-3 text-dark-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 transition-colors">
                                    <option value="7">7 dias</option>
                                    <option value="30" selected>30 dias</option>
                                    <option value="60">60 dias</option>
                                    <option value="90">90 dias</option>
                                    <option value="365">1 ano</option>
                                    <option value="never">Nunca expira</option>
                                </select>
                                <p class="mt-1 text-xs text-dark-400">Após expirar, o token será invalidado automaticamente</p>
                            </div>
                        </div>

                        <button type="submit" 
                                class="mt-6 w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-0.5">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Gerar Token
                        </button>
                    </form>
                </div>

                <!-- Info Box -->
                <div class="mt-6 rounded-2xl bg-primary-50 dark:bg-primary-500/10 border border-primary-200 dark:border-primary-500/20 p-6">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-500/20 flex-shrink-0">
                            <svg class="h-5 w-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-primary-800 dark:text-primary-300">Como usar</h4>
                            <p class="mt-1 text-sm text-primary-700 dark:text-primary-400">
                                Use o token no header <code class="bg-primary-100 dark:bg-primary-500/20 px-1 rounded">Authorization</code> de suas requisições:
                            </p>
                            <code class="mt-2 block text-xs bg-dark-900 text-primary-300 px-3 py-2 rounded-lg font-mono">
                                Authorization: Bearer seu_token_aqui
                            </code>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tokens List -->
            <div class="lg:col-span-2">
                <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                    <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4">
                        <h2 class="text-lg font-semibold text-dark-900 dark:text-white">Tokens Ativos</h2>
                        <p class="text-sm text-dark-500 dark:text-dark-400">{{ $tokens->count() }} token(s) cadastrado(s)</p>
                    </div>

                    @if($tokens->count() > 0)
                        <div class="divide-y divide-dark-100 dark:divide-dark-700">
                            @foreach($tokens as $token)
                                <div class="px-6 py-4 hover:bg-dark-50 dark:hover:bg-dark-700/30 transition-colors">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-dark-100 dark:bg-dark-700">
                                                <svg class="h-6 w-6 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-dark-900 dark:text-white">{{ $token->name }}</h4>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <span class="text-xs text-dark-500 dark:text-dark-400">
                                                        Criado em {{ $token->created_at->format('d/m/Y H:i') }}
                                                    </span>
                                                    @if($token->last_used_at)
                                                        <span class="text-xs text-dark-400">•</span>
                                                        <span class="text-xs text-dark-500 dark:text-dark-400">
                                                            Último uso: {{ $token->last_used_at->diffForHumans() }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            @if($token->expires_at)
                                                @if($token->expires_at->isPast())
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-danger-100 dark:bg-danger-500/20 px-3 py-1 text-xs font-medium text-danger-700 dark:text-danger-400">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-danger-500"></span>
                                                        Expirado
                                                    </span>
                                                @elseif($token->expires_at->diffInDays() <= 7)
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-warning-100 dark:bg-warning-500/20 px-3 py-1 text-xs font-medium text-warning-700 dark:text-warning-400">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-warning-500"></span>
                                                        Expira em {{ $token->expires_at->diffForHumans() }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-success-100 dark:bg-success-500/20 px-3 py-1 text-xs font-medium text-success-700 dark:text-success-400">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-success-500"></span>
                                                        Expira em {{ $token->expires_at->format('d/m/Y') }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="inline-flex items-center gap-1 rounded-full bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-medium text-primary-700 dark:text-primary-400">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-primary-500"></span>
                                                    Nunca expira
                                                </span>
                                            @endif

                                            <form method="POST" 
                                                  action="{{ route('admin.api.tokens.destroy', $token->id) }}" 
                                                  class="inline"
                                                  x-data
                                                  @submit.prevent="if(confirm('Tem certeza que deseja revogar este token? Aplicações que usam este token perderão acesso.')) $el.submit()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="rounded-lg p-2 text-dark-400 hover:bg-danger-100 dark:hover:bg-danger-500/20 hover:text-danger-600 dark:hover:text-danger-400 transition-colors"
                                                        title="Revogar token">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="px-6 py-12 text-center">
                            <div class="flex h-16 w-16 mx-auto items-center justify-center rounded-full bg-dark-100 dark:bg-dark-700">
                                <svg class="h-8 w-8 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <p class="mt-4 text-lg font-medium text-dark-900 dark:text-white">Nenhum token criado</p>
                            <p class="mt-1 text-sm text-dark-500 dark:text-dark-400">Crie seu primeiro token para começar a usar a API.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

