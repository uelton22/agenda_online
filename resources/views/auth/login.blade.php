<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name', 'Agenda Online') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Left Panel - Decorative -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-dark-900 via-dark-800 to-dark-900 overflow-hidden">
            <!-- Background Pattern -->
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

            <!-- Gradient Orbs -->
            <div class="absolute -top-40 -left-40 w-80 h-80 bg-primary-500/30 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-secondary-500/30 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-accent-500/20 rounded-full blur-3xl"></div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center px-12 xl:px-20">
                <div class="flex items-center gap-3 mb-8">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-white">Agenda</span>
                        <span class="text-2xl font-light text-primary-400">Online</span>
                    </div>
                </div>

                <h1 class="text-4xl xl:text-5xl font-bold text-white leading-tight mb-6">
                    Gerencie seus<br>
                    <span class="bg-gradient-to-r from-primary-400 to-secondary-400 bg-clip-text text-transparent">
                        agendamentos
                    </span><br>
                    com facilidade.
                </h1>

                <p class="text-lg text-dark-300 mb-8 max-w-md">
                    Sistema completo de agendamento online com calendário inteligente, controle financeiro e API para integrações.
                </p>

                <!-- Features -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-success-500/20">
                            <svg class="h-4 w-4 text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-dark-200">Calendário inteligente</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-success-500/20">
                            <svg class="h-4 w-4 text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-dark-200">Controle financeiro completo</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-success-500/20">
                            <svg class="h-4 w-4 text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-dark-200">API REST para automações (n8n, Zapier)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-success-500/20">
                            <svg class="h-4 w-4 text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-dark-200">Multi-segmentos</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24 bg-white dark:bg-dark-900">
            <div class="mx-auto w-full max-w-sm lg:max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden flex items-center justify-center gap-3 mb-8">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-dark-900 dark:text-white">Agenda</span>
                        <span class="text-xl font-light text-primary-500">Online</span>
                    </div>
                </div>

                <div class="text-center lg:text-left mb-8">
                    <div class="inline-flex items-center gap-2 rounded-full bg-secondary-100 dark:bg-secondary-500/20 px-3 py-1 text-xs font-medium text-secondary-700 dark:text-secondary-400 mb-3">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Área Administrativa
                    </div>
                    <h2 class="text-2xl font-bold text-dark-900 dark:text-white">
                        Bem-vindo de volta! 👋
                    </h2>
                    <p class="mt-2 text-dark-500 dark:text-dark-400">
                        Entre com suas credenciais de administrador.
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 flex items-center gap-3 rounded-xl bg-success-50 dark:bg-success-500/10 border border-success-200 dark:border-success-500/20 p-4">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-success-100 dark:bg-success-500/20">
                            <svg class="h-4 w-4 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-success-700 dark:text-success-300">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            E-mail
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   autocomplete="username"
                                   class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-800 pl-11 pr-4 py-3.5 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('email') border-danger-500 @enderror"
                                   placeholder="seu@email.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-dark-700 dark:text-dark-300 mb-2">
                            Senha
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input :type="show ? 'text' : 'password'" 
                                   name="password" 
                                   id="password" 
                                   required
                                   autocomplete="current-password"
                                   class="block w-full rounded-xl border-dark-200 dark:border-dark-600 bg-dark-50 dark:bg-dark-800 pl-11 pr-12 py-3.5 text-dark-900 dark:text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('password') border-danger-500 @enderror"
                                   placeholder="••••••••">
                            <button type="button" 
                                    @click="show = !show"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-dark-400 hover:text-dark-600 dark:hover:text-dark-200">
                                <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" 
                                   name="remember" 
                                   id="remember_me"
                                   class="h-4 w-4 rounded border-dark-300 dark:border-dark-600 bg-dark-50 dark:bg-dark-700 text-primary-500 focus:ring-primary-500 transition-colors">
                            <span class="text-sm text-dark-600 dark:text-dark-400">Lembrar-me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                                Esqueceu a senha?
                            </a>
                        @endif
                    </div>

                    <!-- Submit -->
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-4 text-base font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 focus:outline-none focus:ring-4 focus:ring-primary-500/25 transition-all duration-300 hover:-translate-y-0.5">
                        <span>Entrar</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>

                <!-- Client Area Link -->
                <p class="mt-8 text-center text-sm text-dark-500 dark:text-dark-400">
                    É cliente?
                    <a href="{{ route('client.login') }}" class="font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                        Acesse a área do cliente
                    </a>
                </p>

                <!-- Demo credentials -->
                <div class="mt-8 p-4 rounded-xl bg-dark-50 dark:bg-dark-800 border border-dark-200 dark:border-dark-700">
                    <p class="text-xs font-medium text-dark-500 dark:text-dark-400 uppercase tracking-wider mb-2">Credenciais de Teste (Admin)</p>
                    <div class="text-sm">
                        <p class="text-dark-600 dark:text-dark-300">
                            <span class="font-medium">E-mail:</span> admin@agendaonline.com
                        </p>
                        <p class="text-dark-600 dark:text-dark-300">
                            <span class="font-medium">Senha:</span> admin123
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
