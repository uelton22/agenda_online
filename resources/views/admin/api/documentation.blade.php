<x-admin-layout>
    <x-slot name="header">Documentação da API</x-slot>

    <div class="animate-fade-in">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <p class="text-dark-500 dark:text-dark-400">
                    Documentação completa dos endpoints disponíveis
                </p>
            </div>
            <a href="{{ route('admin.api.tokens') }}" 
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
                Gerenciar Tokens
            </a>
        </div>

        <!-- API Info Card -->
        <div class="rounded-2xl bg-gradient-to-r from-primary-500 to-secondary-500 p-6 mb-8 shadow-soft">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="text-white">
                    <h3 class="text-xl font-bold">Agenda Online API v1.1</h3>
                    <p class="mt-1 text-primary-100">
                        Base URL: <code class="bg-white/20 px-2 py-1 rounded">{{ url('/api') }}</code>
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur px-4 py-2 text-sm font-medium text-white">
                        <span class="h-2 w-2 rounded-full bg-success-400 animate-pulse"></span>
                        Online
                    </span>
                </div>
            </div>
        </div>

        <!-- Authentication Section -->
        <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden mb-8">
            <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 bg-dark-50 dark:bg-dark-700/50">
                <h2 class="text-lg font-semibold text-dark-900 dark:text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Autenticação
                </h2>
            </div>
            <div class="p-6">
                <p class="text-dark-600 dark:text-dark-300 mb-4">
                    A API utiliza autenticação via <strong>Bearer Token</strong>. Você deve incluir o token em todas as requisições que requerem autenticação.
                </p>
                
                <div class="bg-dark-900 rounded-xl p-4 mb-4">
                    <p class="text-xs text-dark-400 mb-2">Header de Autenticação</p>
                    <code class="text-sm text-primary-400 font-mono">
                        Authorization: Bearer seu_token_aqui
                    </code>
                </div>

                <div class="flex items-start gap-3 p-4 rounded-xl bg-warning-50 dark:bg-warning-500/10 border border-warning-200 dark:border-warning-500/20">
                    <svg class="h-5 w-5 text-warning-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <p class="font-medium text-warning-800 dark:text-warning-300">Importante</p>
                        <p class="text-sm text-warning-700 dark:text-warning-400">
                            Mantenha seus tokens seguros. Nunca compartilhe ou exponha tokens em código público.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Endpoints -->
        <div class="space-y-6">
            <!-- Auth Endpoints -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 bg-dark-50 dark:bg-dark-700/50">
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Autenticação
                    </h2>
                </div>
                <div class="divide-y divide-dark-100 dark:divide-dark-700">
                    <!-- Login -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-success-100 dark:bg-success-500/20 px-3 py-1 text-xs font-bold text-success-700 dark:text-success-400">
                                POST
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/auth/login</code>
                            <span class="rounded-full bg-dark-100 dark:bg-dark-700 px-2 py-0.5 text-xs text-dark-500">Público</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Autentica um usuário e retorna um token de acesso.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Request Body</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "email": "admin@agendaonline.com",
  "password": "admin123",
  "device_name": "n8n" <span class="text-dark-500">// opcional</span>
}</pre>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "message": "Login realizado com sucesso!",
  "data": {
    "user": { ... },
    "token": "1|abc123...",
    "token_type": "Bearer"
  }
}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Get User -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/auth/user</code>
                            <span class="rounded-full bg-warning-100 dark:bg-warning-500/20 px-2 py-0.5 text-xs text-warning-700 dark:text-warning-400">Autenticado</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Retorna os dados do usuário autenticado.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": {
    "id": 1,
    "name": "Administrador",
    "email": "admin@agendaonline.com",
    "roles": [{ "name": "admin" }]
  }
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- Logout -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-success-100 dark:bg-success-500/20 px-3 py-1 text-xs font-bold text-success-700 dark:text-success-400">
                                POST
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/auth/logout</code>
                            <span class="rounded-full bg-warning-100 dark:bg-warning-500/20 px-2 py-0.5 text-xs text-warning-700 dark:text-warning-400">Autenticado</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Revoga o token atual do usuário.</p>
                    </div>
                </div>
            </div>

            <!-- Users Endpoints -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 bg-dark-50 dark:bg-dark-700/50">
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Usuários
                    </h2>
                    <p class="text-sm text-dark-500 dark:text-dark-400">Todos os endpoints requerem autenticação</p>
                </div>
                <div class="divide-y divide-dark-100 dark:divide-dark-700">
                    <!-- List Users -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/users</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Lista todos os usuários com paginação.</p>
                        
                        <div class="mb-4">
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Query Parameters</p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="text-left border-b border-dark-200 dark:border-dark-700">
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Parâmetro</th>
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Tipo</th>
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Descrição</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-dark-600 dark:text-dark-300">
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">search</code></td>
                                            <td class="py-2">string</td>
                                            <td class="py-2">Busca por nome, email ou telefone</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">role</code></td>
                                            <td class="py-2">string</td>
                                            <td class="py-2">Filtrar por função (admin, user)</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">is_active</code></td>
                                            <td class="py-2">boolean</td>
                                            <td class="py-2">Filtrar por status</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2"><code class="text-primary-500">per_page</code></td>
                                            <td class="py-2">integer</td>
                                            <td class="py-2">Itens por página (padrão: 15)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Exemplo de Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Administrador",
      "email": "admin@agendaonline.com",
      "phone": null,
      "is_active": true,
      "roles": [{ "name": "admin" }]
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 1
  }
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- Create User -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-success-100 dark:bg-success-500/20 px-3 py-1 text-xs font-bold text-success-700 dark:text-success-400">
                                POST
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/users</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Cria um novo usuário.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Request Body</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "name": "João Silva",
  "email": "joao@email.com",
  "password": "senha123",
  "phone": "(11) 99999-9999",
  "role": "user",
  "is_active": true
}</pre>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response (201)</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "message": "Usuário criado...",
  "data": { ... }
}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Get User -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/users/{id}</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Retorna os dados de um usuário específico.</p>
                    </div>

                    <!-- Update User -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-warning-100 dark:bg-warning-500/20 px-3 py-1 text-xs font-bold text-warning-700 dark:text-warning-400">
                                PUT
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/users/{id}</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Atualiza os dados de um usuário. Envie apenas os campos que deseja alterar.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Request Body (parcial)</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "name": "João Silva Atualizado",
  "phone": "(11) 88888-8888",
  "is_active": false
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- Delete User -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-danger-100 dark:bg-danger-500/20 px-3 py-1 text-xs font-bold text-danger-700 dark:text-danger-400">
                                DELETE
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/users/{id}</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Remove um usuário do sistema (soft delete).</p>
                    </div>

                    <!-- Statistics -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/users/statistics</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Retorna estatísticas sobre os usuários.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": {
    "total": 10,
    "active": 8,
    "inactive": 2,
    "admins": 2,
    "users": 8,
    "recent": 3
  }
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clients Endpoints -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 bg-dark-50 dark:bg-dark-700/50">
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Clientes
                    </h2>
                    <p class="text-sm text-dark-500 dark:text-dark-400">Todos os endpoints requerem autenticação</p>
                </div>
                <div class="divide-y divide-dark-100 dark:divide-dark-700">
                    <!-- List Clients -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/clients</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Lista todos os clientes com paginação.</p>
                        
                        <div class="mb-4">
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Query Parameters</p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="text-left border-b border-dark-200 dark:border-dark-700">
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Parâmetro</th>
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Tipo</th>
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Descrição</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-dark-600 dark:text-dark-300">
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">search</code></td>
                                            <td class="py-2">string</td>
                                            <td class="py-2">Busca por nome, CPF, email ou telefone</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">cpf</code></td>
                                            <td class="py-2">string</td>
                                            <td class="py-2">Filtrar por CPF (busca exata)</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">is_active</code></td>
                                            <td class="py-2">boolean</td>
                                            <td class="py-2">Filtrar por status</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2"><code class="text-primary-500">per_page</code></td>
                                            <td class="py-2">integer</td>
                                            <td class="py-2">Itens por página (padrão: 15)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Find by CPF -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/clients/cpf/{cpf}</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Busca um cliente pelo CPF. Ideal para integrações com n8n.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Exemplo</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <code class="text-sm text-dark-300 font-mono">GET /api/clients/cpf/12345678900</code>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": {
    "id": 1,
    "name": "João Silva",
    "cpf": "12345678900",
    "email": "joao@email.com",
    "phone": "11999999999"
  }
}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Create Client -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-success-100 dark:bg-success-500/20 px-3 py-1 text-xs font-bold text-success-700 dark:text-success-400">
                                POST
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/clients</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Cadastra um novo cliente.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Request Body</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "name": "João Silva",
  "cpf": "123.456.789-00",
  "email": "joao@email.com",
  "phone": "(11) 99999-9999",
  "notes": "Cliente VIP",
  "is_active": true
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- Get Client -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/clients/{id}</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Retorna os dados de um cliente específico pelo ID.</p>
                    </div>

                    <!-- Update Client -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-warning-100 dark:bg-warning-500/20 px-3 py-1 text-xs font-bold text-warning-700 dark:text-warning-400">
                                PUT
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/clients/{id}</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Atualiza os dados de um cliente. Envie apenas os campos que deseja alterar.</p>
                    </div>

                    <!-- Delete Client -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-danger-100 dark:bg-danger-500/20 px-3 py-1 text-xs font-bold text-danger-700 dark:text-danger-400">
                                DELETE
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/clients/{id}</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Remove um cliente do sistema (soft delete).</p>
                    </div>

                    <!-- Statistics -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/clients/statistics</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Retorna estatísticas sobre os clientes.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": {
    "total": 50,
    "active": 45,
    "inactive": 5,
    "recent": 10
  }
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professionals Endpoints -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 bg-dark-50 dark:bg-dark-700/50">
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Profissionais
                    </h2>
                    <p class="text-sm text-dark-500 dark:text-dark-400">Gerenciamento de profissionais que realizam os serviços. Todos os endpoints requerem autenticação.</p>
                </div>
                <div class="divide-y divide-dark-100 dark:divide-dark-700">
                    <!-- List Professionals -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/professionals</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Lista todos os profissionais com paginação e filtros.</p>
                        
                        <div class="mb-4">
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Query Parameters</p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="text-left border-b border-dark-200 dark:border-dark-700">
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Parâmetro</th>
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Tipo</th>
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Descrição</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-dark-600 dark:text-dark-300">
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">search</code></td>
                                            <td class="py-2">string</td>
                                            <td class="py-2">Busca por nome, email ou especialidade</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">is_active</code></td>
                                            <td class="py-2">boolean</td>
                                            <td class="py-2">Filtrar por status (true/false)</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">service_id</code></td>
                                            <td class="py-2">integer</td>
                                            <td class="py-2">Filtrar por serviço</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2"><code class="text-primary-500">per_page</code></td>
                                            <td class="py-2">integer</td>
                                            <td class="py-2">Itens por página (padrão: 15)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Exemplo de Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Maria Silva",
      "email": "maria@email.com",
      "phone": "11999999999",
      "specialty": "Cabeleireira",
      "color": "#6366F1",
      "avatar_url": null,
      "is_active": true,
      "services_count": 3
    }
  ],
  "meta": { "current_page": 1, ... }
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- List Active Professionals -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/professionals/active</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado n8n</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Lista apenas profissionais ativos. Pode filtrar por serviço.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Query Parameters</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <code class="text-sm text-dark-300 font-mono">GET /api/professionals/active?service_id=1</code>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": [...],
  "count": 5
}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Create Professional -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-success-100 dark:bg-success-500/20 px-3 py-1 text-xs font-bold text-success-700 dark:text-success-400">
                                POST
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/professionals</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Cadastra um novo profissional.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Request Body</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "name": "Maria Silva",
  "email": "maria@email.com",
  "phone": "(11) 99999-9999",
  "specialty": "Cabeleireira",
  "bio": "Profissional experiente",
  "color": "#6366F1",
  "is_active": true,
  "services": [1, 2, 3] <span class="text-dark-500">// IDs dos serviços</span>
}</pre>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response (201)</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "message": "Profissional criado...",
  "data": { ... }
}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Get Professional -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/professionals/{id}</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Retorna os dados completos de um profissional específico, incluindo os serviços que realiza.</p>
                    </div>

                    <!-- Get Professional Services -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/professionals/{id}/services</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Lista os serviços ativos que o profissional realiza.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "professional": {
    "id": 1,
    "name": "Maria Silva"
  },
  "services": [
    {
      "id": 1,
      "name": "Corte de Cabelo",
      "price": 50.00,
      "duration": 30,
      "color": "#6366F1",
      "pivot_price": null, <span class="text-dark-500">// Preço específico do profissional</span>
      "pivot_duration": null <span class="text-dark-500">// Duração específica do profissional</span>
    }
  ],
  "count": 3
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- Get Professional Available Slots -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/professionals/{id}/available-slots</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado n8n</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Retorna os horários disponíveis de um profissional para um serviço em uma data específica.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Query Parameters</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <code class="text-sm text-dark-300 font-mono">GET /api/professionals/1/available-slots?service_id=1&date=2026-01-15</code>
                                </div>
                                <p class="text-xs text-dark-500 mt-2">
                                    <strong>service_id</strong> (obrigatório): ID do serviço<br>
                                    <strong>date</strong> (obrigatório): Data no formato YYYY-MM-DD
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "available": true,
  "data": {
    "professional": { "id": 1, "name": "Maria" },
    "service": { "id": 1, "name": "Corte" },
    "date": "2026-01-15",
    "day_name": "Quarta-feira",
    "duration": 30,
    "price": 50.00,
    "all_slots": ["08:00", "08:30", ...],
    "booked_slots": ["10:00"],
    "available_slots": ["08:00", "08:30", ...],
    "available_count": 18
  }
}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Available for Slot -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/professionals/available-for-slot</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado n8n</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Retorna quais profissionais estão disponíveis para um serviço em uma data e horário específicos. Ideal para chatbots.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Query Parameters</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <code class="text-sm text-dark-300 font-mono">GET /api/professionals/available-for-slot?service_id=1&date=2026-01-15&time=10:00</code>
                                </div>
                                <p class="text-xs text-dark-500 mt-2">
                                    <strong>service_id</strong> (obrigatório): ID do serviço<br>
                                    <strong>date</strong> (obrigatório): Data no formato YYYY-MM-DD<br>
                                    <strong>time</strong> (obrigatório): Horário no formato HH:mm
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "service": { "id": 1, "name": "Corte" },
  "date": "2026-01-15",
  "time": "10:00",
  "professionals": [
    { "id": 1, "name": "Maria Silva", ... },
    { "id": 2, "name": "João Santos", ... }
  ],
  "count": 2
}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Professional -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-warning-100 dark:bg-warning-500/20 px-3 py-1 text-xs font-bold text-warning-700 dark:text-warning-400">
                                PUT
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/professionals/{id}</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Atualiza os dados de um profissional. Envie apenas os campos que deseja alterar. Se enviar services, todos os vínculos serão substituídos.</p>
                    </div>

                    <!-- Delete Professional -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-danger-100 dark:bg-danger-500/20 px-3 py-1 text-xs font-bold text-danger-700 dark:text-danger-400">
                                DELETE
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/professionals/{id}</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Remove um profissional do sistema (soft delete). Não é possível excluir profissionais com agendamentos vinculados.</p>
                    </div>

                    <!-- Statistics -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/professionals/statistics</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Retorna estatísticas sobre os profissionais, incluindo os mais ativos.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": {
    "total": 10,
    "active": 8,
    "inactive": 2,
    "top_professionals": [
      { "id": 1, "name": "Maria", "specialty": "Cabelo", "appointments_count": 50 },
      ...
    ]
  }
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Endpoints -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 bg-dark-50 dark:bg-dark-700/50">
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Serviços
                    </h2>
                    <p class="text-sm text-dark-500 dark:text-dark-400">Gerenciamento de serviços e horários disponíveis</p>
                </div>
                <div class="divide-y divide-dark-100 dark:divide-dark-700">
                    <!-- List Services -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/services</code>
                            <span class="rounded-full bg-warning-100 dark:bg-warning-500/20 px-2 py-0.5 text-xs text-warning-700 dark:text-warning-400">Admin</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Lista todos os serviços com paginação e filtros.</p>
                        
                        <div class="mb-4">
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Query Parameters</p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="text-left border-b border-dark-200 dark:border-dark-700">
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Parâmetro</th>
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Tipo</th>
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Descrição</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-dark-600 dark:text-dark-300">
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">search</code></td>
                                            <td class="py-2">string</td>
                                            <td class="py-2">Busca por nome ou descrição</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">is_active</code></td>
                                            <td class="py-2">boolean</td>
                                            <td class="py-2">Filtrar por status (true/false)</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2"><code class="text-primary-500">per_page</code></td>
                                            <td class="py-2">integer</td>
                                            <td class="py-2">Itens por página (padrão: 15)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Exemplo de Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Corte de Cabelo",
      "description": "Corte masculino",
      "price": 50.00,
      "price_formatted": "R$ 50,00",
      "duration": 30,
      "duration_formatted": "30min",
      "color": "#6366F1",
      "is_active": true,
      "working_days": [1, 2, 3, 4, 5],
      "working_days_names": ["Segunda", "Terça", ...],
      "schedules": [...]
    }
  ],
  "meta": { "current_page": 1, ... }
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- List Active Services -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/services/active</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado n8n</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Lista apenas serviços ativos. Ideal para integrações com n8n e chatbots.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Corte de Cabelo",
      "description": "Corte masculino",
      "price": 50.00,
      "price_formatted": "R$ 50,00",
      "duration": 30,
      "duration_formatted": "30min",
      "color": "#6366F1",
      "working_days": ["Segunda", "Terça", ...]
    }
  ],
  "count": 5
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- Create Service -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-success-100 dark:bg-success-500/20 px-3 py-1 text-xs font-bold text-success-700 dark:text-success-400">
                                POST
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/services</code>
                            <span class="rounded-full bg-warning-100 dark:bg-warning-500/20 px-2 py-0.5 text-xs text-warning-700 dark:text-warning-400">Admin</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Cadastra um novo serviço com seus horários de atendimento.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Request Body</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "name": "Corte de Cabelo",
  "description": "Corte masculino",
  "price": 50.00,
  "duration": 30, <span class="text-dark-500">// minutos</span>
  "color": "#6366F1",
  "is_active": true,
  "schedules": [
    {
      "day_of_week": 1, <span class="text-dark-500">// 0=Dom, 6=Sáb</span>
      "start_time": "08:00",
      "end_time": "18:00"
    },
    {
      "day_of_week": 2,
      "start_time": "08:00",
      "end_time": "18:00"
    }
  ]
}</pre>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response (201)</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "message": "Serviço cadastrado...",
  "data": { ... }
}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Get Service -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/services/{id}</code>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Retorna os dados completos de um serviço específico, incluindo todos os horários configurados.</p>
                    </div>

                    <!-- Weekly Slots -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/services/{id}/slots</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado n8n</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Retorna todos os horários disponíveis da semana para o serviço. Os slots são calculados automaticamente com base na duração do serviço.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": {
    "service_id": 1,
    "service_name": "Corte de Cabelo",
    "duration": 30,
    "duration_formatted": "30min",
    "price": 50.00,
    "price_formatted": "R$ 50,00",
    "weekly_schedule": {
      "1": {
        "day_name": "Segunda-feira",
        "slots": ["08:00", "08:30", "09:00", ...]
      },
      "2": {
        "day_name": "Terça-feira",
        "slots": ["08:00", "08:30", "09:00", ...]
      }
    }
  }
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- Available Slots by Date -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/services/{id}/available</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado n8n</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Retorna os horários disponíveis para uma data específica. Ideal para agendamentos via n8n.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Query Parameters</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <code class="text-sm text-dark-300 font-mono">GET /api/services/1/available?date=2026-01-10</code>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": {
    "date": "2026-01-10",
    "day_of_week": 6,
    "day_name": "Sábado",
    "available": true,
    "slots": ["08:00", "08:30", ...],
    "slots_count": 8
  }
}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Service -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-warning-100 dark:bg-warning-500/20 px-3 py-1 text-xs font-bold text-warning-700 dark:text-warning-400">
                                PUT
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/services/{id}</code>
                            <span class="rounded-full bg-warning-100 dark:bg-warning-500/20 px-2 py-0.5 text-xs text-warning-700 dark:text-warning-400">Admin</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Atualiza os dados de um serviço. Envie apenas os campos que deseja alterar. Se enviar schedules, todos os horários serão substituídos.</p>
                    </div>

                    <!-- Delete Service -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-danger-100 dark:bg-danger-500/20 px-3 py-1 text-xs font-bold text-danger-700 dark:text-danger-400">
                                DELETE
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/services/{id}</code>
                            <span class="rounded-full bg-warning-100 dark:bg-warning-500/20 px-2 py-0.5 text-xs text-warning-700 dark:text-warning-400">Admin</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Remove um serviço do sistema (soft delete).</p>
                    </div>

                    <!-- Statistics -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/services/statistics</code>
                            <span class="rounded-full bg-warning-100 dark:bg-warning-500/20 px-2 py-0.5 text-xs text-warning-700 dark:text-warning-400">Admin</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Retorna estatísticas sobre os serviços cadastrados.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": {
    "total": 10,
    "active": 8,
    "inactive": 2,
    "average_price": 75.50,
    "average_duration": 45
  }
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointments Endpoints -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 bg-dark-50 dark:bg-dark-700/50">
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Agendamentos
                    </h2>
                    <p class="text-sm text-dark-500 dark:text-dark-400">Endpoints para criar, gerenciar e consultar agendamentos. Ideal para integração com n8n.</p>
                </div>
                <div class="divide-y divide-dark-100 dark:divide-dark-700">
                    <!-- List Appointments -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/appointments</code>
                            <span class="rounded-full bg-warning-100 dark:bg-warning-500/20 px-2 py-0.5 text-xs text-warning-700 dark:text-warning-400">Autenticado</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Lista todos os agendamentos com paginação e filtros avançados.</p>
                        
                        <div class="mb-4">
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Query Parameters</p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="text-left border-b border-dark-200 dark:border-dark-700">
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Parâmetro</th>
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Tipo</th>
                                            <th class="pb-2 font-medium text-dark-900 dark:text-white">Descrição</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-dark-600 dark:text-dark-300">
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">status</code></td>
                                            <td class="py-2">string</td>
                                            <td class="py-2">Filtrar por status (pending, confirmed, completed, cancelled, no_show)</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">client_id</code></td>
                                            <td class="py-2">integer</td>
                                            <td class="py-2">Filtrar por ID do cliente</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">service_id</code></td>
                                            <td class="py-2">integer</td>
                                            <td class="py-2">Filtrar por ID do serviço</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">date</code></td>
                                            <td class="py-2">date</td>
                                            <td class="py-2">Filtrar por data específica (YYYY-MM-DD)</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">date_from</code></td>
                                            <td class="py-2">date</td>
                                            <td class="py-2">Data inicial do período</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">date_to</code></td>
                                            <td class="py-2">date</td>
                                            <td class="py-2">Data final do período</td>
                                        </tr>
                                        <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                            <td class="py-2"><code class="text-primary-500">period</code></td>
                                            <td class="py-2">string</td>
                                            <td class="py-2">Período pré-definido (today, week, month, upcoming)</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2"><code class="text-primary-500">per_page</code></td>
                                            <td class="py-2">integer</td>
                                            <td class="py-2">Itens por página (padrão: 15)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Exemplo de Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": [
    {
      "id": 1,
      "client": {
        "id": 1,
        "name": "João Silva",
        "cpf": "12345678900",
        "phone": "11999999999"
      },
      "service": {
        "id": 1,
        "name": "Corte de Cabelo",
        "duration": 30,
        "color": "#6366F1"
      },
      "professional": { <span class="text-dark-500">// null se não tiver</span>
        "id": 1,
        "name": "Maria Silva",
        "color": "#6366F1"
      },
      "scheduled_date": "2026-01-15",
      "scheduled_date_formatted": "15/01/2026",
      "scheduled_time": "10:00",
      "end_time": "10:30",
      "time_range": "10:00 - 10:30",
      "price": 50.00,
      "price_formatted": "R$ 50,00",
      "status": "confirmed",
      "status_label": "Confirmado",
      "status_color": "#3B82F6"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 1
  }
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- Create Appointment -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-success-100 dark:bg-success-500/20 px-3 py-1 text-xs font-bold text-success-700 dark:text-success-400">
                                POST
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/appointments</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado n8n</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Cria um novo agendamento. O sistema valida automaticamente a disponibilidade do horário e do profissional.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Request Body</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "client_id": 1,
  "service_id": 1,
  "professional_id": 1, <span class="text-dark-500">// opcional</span>
  "scheduled_date": "2026-01-15",
  "scheduled_time": "10:00",
  "notes": "Cliente prefere horário pela manhã"
}</pre>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response (201)</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "message": "Agendamento criado...",
  "data": {
    "id": 1,
    "scheduled_date": "2026-01-15",
    "scheduled_time": "10:00",
    "end_time": "10:30",
    "price": 50.00,
    "status": "pending",
    "professional": { <span class="text-dark-500">// se informado</span>
      "id": 1,
      "name": "Maria Silva"
    },
    ...
  }
}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Get Appointment -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/appointments/{id}</code>
                            <span class="rounded-full bg-warning-100 dark:bg-warning-500/20 px-2 py-0.5 text-xs text-warning-700 dark:text-warning-400">Autenticado</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Retorna os dados completos de um agendamento específico, incluindo informações detalhadas do cliente, serviço e timestamps de status.</p>
                    </div>

                    <!-- Today's Appointments -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/appointments/today</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado n8n</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Retorna todos os agendamentos do dia atual, ordenados por horário. Ideal para dashboards e notificações.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "date": "2026-01-07",
  "date_formatted": "07/01/2026",
  "data": [...],
  "count": 5
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- Available Slots -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/appointments/available-slots</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado n8n</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Retorna os horários disponíveis para agendamento em uma data específica, já considerando agendamentos existentes. Se informado professional_id, filtra apenas pelos horários do profissional.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Query Parameters</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <code class="text-sm text-dark-300 font-mono">GET /api/appointments/available-slots?service_id=1&date=2026-01-15&professional_id=1</code>
                                </div>
                                <p class="text-xs text-dark-500 mt-2">
                                    <strong>service_id</strong> (obrigatório): ID do serviço<br>
                                    <strong>date</strong> (obrigatório): Data no formato YYYY-MM-DD<br>
                                    <strong>professional_id</strong> (opcional): ID do profissional
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "available": true,
  "data": {
    "date": "2026-01-15",
    "day_of_week": 3,
    "day_name": "Quarta-feira",
    "service_id": 1,
    "service_name": "Corte de Cabelo",
    "professional_id": 1, <span class="text-dark-500">// se informado</span>
    "professional_name": "Maria Silva",
    "duration": 30,
    "price": 50.00,
    "all_slots": ["08:00", "08:30", ...],
    "booked_slots": ["10:00", "14:30"],
    "available_slots": ["08:00", "08:30", ...],
    "available_count": 18
  }
}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Appointments by Client CPF -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/appointments/client/{cpf}</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado n8n</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Busca todos os agendamentos de um cliente pelo CPF. Ideal para consultas via chatbot.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Query Parameters</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <code class="text-sm text-dark-300 font-mono">GET /api/appointments/client/12345678900?upcoming=true</code>
                                </div>
                                <p class="text-xs text-dark-500 mt-2">
                                    <strong>status</strong> (opcional): Filtrar por status<br>
                                    <strong>upcoming</strong> (opcional): true para apenas agendamentos futuros
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "client": {
    "id": 1,
    "name": "João Silva",
    "cpf": "12345678900",
    "email": "joao@email.com",
    "phone": "11999999999"
  },
  "appointments": [...],
  "count": 3
}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Appointment -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-warning-100 dark:bg-warning-500/20 px-3 py-1 text-xs font-bold text-warning-700 dark:text-warning-400">
                                PUT
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/appointments/{id}</code>
                            <span class="rounded-full bg-warning-100 dark:bg-warning-500/20 px-2 py-0.5 text-xs text-warning-700 dark:text-warning-400">Autenticado</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Atualiza os dados de um agendamento. Só pode alterar agendamentos pendentes ou confirmados.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Request Body (parcial)</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "scheduled_date": "2026-01-16",
  "scheduled_time": "14:00",
  "notes": "Remarcação solicitada pelo cliente"
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- Update Status -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-warning-100 dark:bg-warning-500/20 px-3 py-1 text-xs font-bold text-warning-700 dark:text-warning-400">
                                PATCH
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/appointments/{id}/status</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado n8n</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Atualiza apenas o status de um agendamento. Útil para confirmações e conclusões automatizadas.</p>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Request Body</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <pre class="text-sm text-dark-300 font-mono">{
  "status": "confirmed",
  <span class="text-dark-500">// Opcional para cancelamento:</span>
  "cancellation_reason": "Cliente solicitou"
}</pre>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Status Disponíveis</p>
                                <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                    <ul class="text-sm text-dark-300 font-mono space-y-1">
                                        <li><span class="text-warning-400">pending</span> - Pendente</li>
                                        <li><span class="text-primary-400">confirmed</span> - Confirmado</li>
                                        <li><span class="text-success-400">completed</span> - Concluído</li>
                                        <li><span class="text-danger-400">cancelled</span> - Cancelado</li>
                                        <li><span class="text-dark-500">no_show</span> - Não compareceu</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cancel Appointment -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-danger-100 dark:bg-danger-500/20 px-3 py-1 text-xs font-bold text-danger-700 dark:text-danger-400">
                                POST
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/appointments/{id}/cancel</code>
                            <span class="rounded-full bg-success-100 dark:bg-success-500/20 px-2 py-0.5 text-xs text-success-700 dark:text-success-400">Recomendado n8n</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Cancela um agendamento. Só pode cancelar agendamentos pendentes ou confirmados.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Request Body (opcional)</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "reason": "Cliente solicitou cancelamento"
}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Appointment -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-danger-100 dark:bg-danger-500/20 px-3 py-1 text-xs font-bold text-danger-700 dark:text-danger-400">
                                DELETE
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/appointments/{id}</code>
                            <span class="rounded-full bg-warning-100 dark:bg-warning-500/20 px-2 py-0.5 text-xs text-warning-700 dark:text-warning-400">Autenticado</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300">Remove um agendamento do sistema (soft delete). Use com cautela.</p>
                    </div>

                    <!-- Statistics -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center rounded-lg bg-primary-100 dark:bg-primary-500/20 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                                GET
                            </span>
                            <code class="text-sm font-mono text-dark-900 dark:text-white">/api/appointments/statistics</code>
                            <span class="rounded-full bg-warning-100 dark:bg-warning-500/20 px-2 py-0.5 text-xs text-warning-700 dark:text-warning-400">Autenticado</span>
                        </div>
                        <p class="text-dark-600 dark:text-dark-300 mb-4">Retorna estatísticas completas dos agendamentos, incluindo receita e serviços populares.</p>
                        
                        <div>
                            <p class="text-xs font-semibold text-dark-500 uppercase tracking-wider mb-2">Response</p>
                            <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                                <pre class="text-sm text-dark-300 font-mono">{
  "success": true,
  "data": {
    "revenue": {
      "total": 5000.00,
      "total_formatted": "R$ 5.000,00",
      "month": 1500.00,
      "month_formatted": "R$ 1.500,00",
      "today": 200.00,
      "today_formatted": "R$ 200,00"
    },
    "appointments": {
      "total": 100,
      "month": 30,
      "today": 5,
      "pending": 10,
      "confirmed": 8
    },
    "status_breakdown": {
      "pending": {"label": "Pendente", "count": 10},
      "confirmed": {"label": "Confirmado", "count": 8},
      ...
    },
    "popular_services": [
      {"id": 1, "name": "Corte de Cabelo", "appointments_count": 50},
      ...
    ]
  }
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error Responses -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 bg-dark-50 dark:bg-dark-700/50">
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Códigos de Erro
                    </h2>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left border-b border-dark-200 dark:border-dark-700">
                                    <th class="pb-3 font-medium text-dark-900 dark:text-white">Código</th>
                                    <th class="pb-3 font-medium text-dark-900 dark:text-white">Descrição</th>
                                    <th class="pb-3 font-medium text-dark-900 dark:text-white">Causa Comum</th>
                                </tr>
                            </thead>
                            <tbody class="text-dark-600 dark:text-dark-300">
                                <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                    <td class="py-3"><span class="font-mono text-warning-500">400</span></td>
                                    <td class="py-3">Bad Request</td>
                                    <td class="py-3">Dados de requisição inválidos</td>
                                </tr>
                                <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                    <td class="py-3"><span class="font-mono text-danger-500">401</span></td>
                                    <td class="py-3">Unauthorized</td>
                                    <td class="py-3">Token inválido ou expirado</td>
                                </tr>
                                <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                    <td class="py-3"><span class="font-mono text-danger-500">403</span></td>
                                    <td class="py-3">Forbidden</td>
                                    <td class="py-3">Sem permissão para a ação</td>
                                </tr>
                                <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                    <td class="py-3"><span class="font-mono text-warning-500">404</span></td>
                                    <td class="py-3">Not Found</td>
                                    <td class="py-3">Recurso não encontrado</td>
                                </tr>
                                <tr class="border-b border-dark-100 dark:border-dark-700/50">
                                    <td class="py-3"><span class="font-mono text-warning-500">422</span></td>
                                    <td class="py-3">Unprocessable Entity</td>
                                    <td class="py-3">Erro de validação</td>
                                </tr>
                                <tr>
                                    <td class="py-3"><span class="font-mono text-danger-500">500</span></td>
                                    <td class="py-3">Internal Server Error</td>
                                    <td class="py-3">Erro interno do servidor</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- cURL Examples -->
            <div class="rounded-2xl bg-white dark:bg-dark-800 shadow-soft overflow-hidden">
                <div class="border-b border-dark-100 dark:border-dark-700 px-6 py-4 bg-dark-50 dark:bg-dark-700/50">
                    <h2 class="text-lg font-semibold text-dark-900 dark:text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Exemplos com cURL
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Login Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Login e obter token:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X POST {{ url('/api/auth/login') }} \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"admin@agendaonline.com","password":"admin123"}'</pre>
                        </div>
                    </div>

                    <!-- List Users Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Listar usuários:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X GET "{{ url('/api/users') }}?per_page=10" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Accept: application/json"</pre>
                        </div>
                    </div>

                    <!-- Create User Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Criar usuário:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X POST {{ url('/api/users') }} \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"Novo Usuário","email":"novo@email.com","password":"senha123","role":"user"}'</pre>
                        </div>
                    </div>

                    <!-- List Active Services Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Listar serviços ativos (ideal para n8n):</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X GET "{{ url('/api/services/active') }}" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Accept: application/json"</pre>
                        </div>
                    </div>

                    <!-- Get Service Slots Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Obter horários disponíveis do serviço:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X GET "{{ url('/api/services/1/slots') }}" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Accept: application/json"</pre>
                        </div>
                    </div>

                    <!-- Get Available Slots by Date Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Horários disponíveis para uma data específica:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X GET "{{ url('/api/services/1/available') }}?date=2026-01-10" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Accept: application/json"</pre>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-dark-200 dark:border-dark-700">
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-4">👨‍⚕️ Profissionais (n8n)</h3>
                    </div>

                    <!-- List Active Professionals Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Listar profissionais ativos:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X GET "{{ url('/api/professionals/active') }}" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Accept: application/json"</pre>
                        </div>
                    </div>

                    <!-- List Professionals by Service Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Listar profissionais por serviço:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X GET "{{ url('/api/professionals/active') }}?service_id=1" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Accept: application/json"</pre>
                        </div>
                    </div>

                    <!-- Get Professional Available Slots Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Horários disponíveis do profissional:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X GET "{{ url('/api/professionals/1/available-slots') }}?service_id=1&date=2026-01-15" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Accept: application/json"</pre>
                        </div>
                    </div>

                    <!-- Get Available Professionals for Slot Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Profissionais disponíveis para um horário:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X GET "{{ url('/api/professionals/available-for-slot') }}?service_id=1&date=2026-01-15&time=10:00" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Accept: application/json"</pre>
                        </div>
                    </div>

                    <!-- Create Service Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Criar serviço com horários:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X POST {{ url('/api/services') }} \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name":"Corte de Cabelo",
    "price":50.00,
    "duration":30,
    "color":"#6366F1",
    "schedules":[
      {"day_of_week":1,"start_time":"08:00","end_time":"18:00"},
      {"day_of_week":2,"start_time":"08:00","end_time":"18:00"}
    ]
  }'</pre>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-dark-200 dark:border-dark-700">
                        <h3 class="text-lg font-semibold text-dark-900 dark:text-white mb-4">📅 Agendamentos (n8n)</h3>
                    </div>

                    <!-- Check Available Slots Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Verificar horários disponíveis:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X GET "{{ url('/api/appointments/available-slots') }}?service_id=1&date=2026-01-15" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Accept: application/json"</pre>
                        </div>
                    </div>

                    <!-- Create Appointment Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Criar agendamento:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X POST {{ url('/api/appointments') }} \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "client_id": 1,
    "service_id": 1,
    "professional_id": 1,
    "scheduled_date": "2026-01-15",
    "scheduled_time": "10:00",
    "notes": "Agendamento via n8n"
  }'</pre>
                        </div>
                    </div>

                    <!-- Get Today Appointments Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Agendamentos de hoje:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X GET "{{ url('/api/appointments/today') }}" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Accept: application/json"</pre>
                        </div>
                    </div>

                    <!-- Get Client Appointments by CPF Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Buscar agendamentos por CPF do cliente:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X GET "{{ url('/api/appointments/client/12345678900') }}?upcoming=true" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Accept: application/json"</pre>
                        </div>
                    </div>

                    <!-- Update Appointment Status Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Confirmar agendamento:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X PATCH "{{ url('/api/appointments/1/status') }}" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"status": "confirmed"}'</pre>
                        </div>
                    </div>

                    <!-- Cancel Appointment Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Cancelar agendamento:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X POST "{{ url('/api/appointments/1/cancel') }}" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"reason": "Cliente solicitou cancelamento"}'</pre>
                        </div>
                    </div>

                    <!-- Get Appointment Statistics Example -->
                    <div>
                        <p class="text-sm font-medium text-dark-900 dark:text-white mb-2">Estatísticas de agendamentos:</p>
                        <div class="bg-dark-900 rounded-xl p-4 overflow-x-auto">
                            <pre class="text-sm text-dark-300 font-mono whitespace-pre-wrap">curl -X GET "{{ url('/api/appointments/statistics') }}" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Accept: application/json"</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

