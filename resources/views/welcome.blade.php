<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Agenda Online') }} - Sistema de Agendamento</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased bg-dark-900 text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-dark-900/80 backdrop-blur-xl border-b border-dark-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-lg font-bold text-white">Agenda</span>
                        <span class="text-lg font-light text-primary-400">Online</span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @if(auth()->guard('client')->check())
                        <a href="{{ route('client.dashboard') }}" class="text-sm font-medium text-dark-300 hover:text-white transition-colors">
                            Meus Agendamentos
                        </a>
                    @elseif(auth()->check())
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-dark-300 hover:text-white transition-colors">
                            Painel Admin
                        </a>
                    @else
                        <a href="{{ route('client.login') }}" class="text-sm font-medium text-dark-300 hover:text-white transition-colors">
                            Entrar
                        </a>
                        <a href="{{ route('client.register') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-0.5">
                            Criar Conta
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-16 overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <defs>
                        <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5" class="text-white"/>
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#grid)"/>
                </svg>
            </div>
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-accent-500/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <span class="inline-flex items-center gap-2 rounded-full bg-primary-500/10 border border-primary-500/20 px-4 py-2 text-sm font-medium text-primary-400 mb-8">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Sistema profissional de agendamento
                </span>

                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold leading-tight mb-6">
                    Gerencie seus<br>
                    <span class="bg-gradient-to-r from-primary-400 via-secondary-400 to-accent-400 bg-clip-text text-transparent">
                        agendamentos online
                    </span>
                </h1>

                <p class="text-xl text-dark-300 max-w-2xl mx-auto mb-10">
                    Sistema completo com calendário inteligente, controle financeiro, gestão de clientes e API para automações com n8n, Zapier e muito mais.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('client.login') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 hover:-translate-y-1">
                        <span>Acessar Minha Conta</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="{{ route('client.register') }}" class="inline-flex items-center gap-2 rounded-xl border border-dark-600 bg-dark-800/50 backdrop-blur px-8 py-4 text-base font-semibold text-white hover:bg-dark-700/50 transition-all duration-300">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <span>Criar Conta Grátis</span>
                    </a>
                </div>
            </div>

            <!-- Dashboard Preview -->
            <div class="mt-16 animate-slide-up">
                <div class="relative mx-auto max-w-5xl">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-500/20 via-secondary-500/20 to-accent-500/20 rounded-3xl blur-2xl"></div>
                    <div class="relative rounded-2xl bg-dark-800/50 backdrop-blur border border-dark-700/50 p-2 shadow-2xl">
                        <div class="rounded-xl bg-dark-800 p-4 sm:p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="flex gap-2">
                                    <div class="h-3 w-3 rounded-full bg-danger-500"></div>
                                    <div class="h-3 w-3 rounded-full bg-warning-500"></div>
                                    <div class="h-3 w-3 rounded-full bg-success-500"></div>
                                </div>
                                <div class="flex-1 h-6 bg-dark-700 rounded-lg"></div>
                            </div>
                            <div class="grid grid-cols-4 gap-4 mb-6">
                                <div class="col-span-1 h-32 bg-dark-700/50 rounded-xl"></div>
                                <div class="col-span-3 h-32 bg-gradient-to-r from-primary-500/20 to-secondary-500/20 rounded-xl border border-primary-500/30"></div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="h-20 bg-dark-700/50 rounded-xl"></div>
                                <div class="h-20 bg-dark-700/50 rounded-xl"></div>
                                <div class="h-20 bg-dark-700/50 rounded-xl"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-dark-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                    Tudo que você precisa em um só lugar
                </h2>
                <p class="text-lg text-dark-300 max-w-2xl mx-auto">
                    Recursos poderosos para gerenciar seu negócio de forma eficiente
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group p-8 rounded-2xl bg-dark-800 border border-dark-700/50 hover:border-primary-500/50 transition-all duration-300">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 shadow-lg shadow-primary-500/30 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Calendário Inteligente</h3>
                    <p class="text-dark-400">
                        Visualize e gerencie todos os agendamentos em um calendário interativo e intuitivo.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group p-8 rounded-2xl bg-dark-800 border border-dark-700/50 hover:border-secondary-500/50 transition-all duration-300">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-secondary-500 to-secondary-600 shadow-lg shadow-secondary-500/30 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Gestão de Clientes</h3>
                    <p class="text-dark-400">
                        Cadastre e acompanhe todos os seus clientes com histórico de agendamentos.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group p-8 rounded-2xl bg-dark-800 border border-dark-700/50 hover:border-success-500/50 transition-all duration-300">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-success-500 to-success-600 shadow-lg shadow-success-500/30 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Controle Financeiro</h3>
                    <p class="text-dark-400">
                        Acompanhe receitas, despesas, contas a pagar e receber em tempo real.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="group p-8 rounded-2xl bg-dark-800 border border-dark-700/50 hover:border-accent-500/50 transition-all duration-300">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-accent-500 to-accent-600 shadow-lg shadow-accent-500/30 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">API REST</h3>
                    <p class="text-dark-400">
                        Integre com n8n, Zapier, Make e outras ferramentas de automação facilmente.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="group p-8 rounded-2xl bg-dark-800 border border-dark-700/50 hover:border-warning-500/50 transition-all duration-300">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-warning-500 to-warning-600 shadow-lg shadow-warning-500/30 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Multi-Segmentos</h3>
                    <p class="text-dark-400">
                        Ideal para salões, clínicas, consultórios, academias e muito mais.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="group p-8 rounded-2xl bg-dark-800 border border-dark-700/50 hover:border-danger-500/50 transition-all duration-300">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-danger-500 to-danger-600 shadow-lg shadow-danger-500/30 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Segurança Avançada</h3>
                    <p class="text-dark-400">
                        Sistema de permissões robusto e autenticação segura para seus dados.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-3xl bg-gradient-to-r from-primary-500 to-secondary-500 p-12 lg:p-16 overflow-hidden">
                <div class="absolute inset-0 opacity-20">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="cta-grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5" class="text-white"/>
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#cta-grid)"/>
                    </svg>
                </div>

                <div class="relative z-10 text-center">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                        Pronto para começar?
                    </h2>
                    <p class="text-lg text-primary-100 max-w-2xl mx-auto mb-8">
                        Crie sua conta gratuitamente e comece a gerenciar seus agendamentos hoje mesmo.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('client.register') }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-8 py-4 text-base font-semibold text-primary-600 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <span>Criar Conta Grátis</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        <a href="{{ route('client.login') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/10 backdrop-blur border border-white/30 px-8 py-4 text-base font-semibold text-white hover:bg-white/20 transition-all duration-300">
                            <span>Já tenho conta</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-dark-700/50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-primary-500 to-secondary-500">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-white">Agenda</span>
                        <span class="text-sm font-light text-primary-400">Online</span>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <a href="{{ route('client.login') }}" class="text-sm text-dark-400 hover:text-white transition-colors">
                        Área do Cliente
                    </a>
                    <span class="text-dark-600">|</span>
                    <a href="{{ route('login') }}" class="text-sm text-dark-400 hover:text-white transition-colors">
                        Área Administrativa
                    </a>
                </div>

                <p class="text-sm text-dark-400">
                    &copy; {{ date('Y') }} Agenda Online. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
