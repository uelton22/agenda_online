<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Cliente - {{ config('app.name', 'Agenda Online') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased bg-gradient-to-br from-dark-900 via-dark-800 to-dark-900">
    <div class="min-h-screen flex">
        <!-- Left side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-600/20 via-secondary-600/20 to-accent-600/20"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%239C92AC\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
            
            <div class="relative z-10 flex flex-col justify-center px-12 xl:px-20">
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-secondary-500 shadow-2xl shadow-primary-500/30">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-3xl font-bold text-white">Agenda</span>
                            <span class="text-3xl font-light text-primary-400">Online</span>
                        </div>
                    </div>
                    <h1 class="text-4xl xl:text-5xl font-bold text-white mb-4">
                        Bem-vindo de volta!
                    </h1>
                    <p class="text-lg text-dark-300 max-w-md">
                        Acesse sua conta para gerenciar seus agendamentos de forma rápida e fácil.
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-500/20 text-primary-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-white">Agende online</p>
                            <p class="text-sm text-dark-400">24 horas por dia, 7 dias por semana</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-secondary-500/20 text-secondary-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-white">Acompanhe tudo</p>
                            <p class="text-sm text-dark-400">Histórico completo de agendamentos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side - Login form -->
        <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                <!-- Mobile logo -->
                <div class="lg:hidden mb-8 text-center">
                    <div class="inline-flex items-center gap-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-secondary-500">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">Agenda<span class="font-light text-primary-400">Online</span></span>
                    </div>
                </div>

                <div class="bg-dark-800/50 backdrop-blur-xl rounded-3xl p-8 shadow-2xl border border-dark-700/50">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-white mb-2">Área do Cliente</h2>
                        <p class="text-dark-400">Entre com suas credenciais</p>
                    </div>

                    <form method="POST" action="{{ route('client.login') }}" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-dark-300 mb-2">E-mail</label>
                            <div class="relative">
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                       class="w-full rounded-xl border-dark-600 bg-dark-700/50 text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 pl-12 py-3"
                                       placeholder="seu@email.com">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <svg class="h-5 w-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div x-data="{ show: false }">
                            <label for="password" class="block text-sm font-medium text-dark-300 mb-2">Senha</label>
                            <div class="relative">
                                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                                       class="w-full rounded-xl border-dark-600 bg-dark-700/50 text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 pl-12 pr-12 py-3"
                                       placeholder="••••••••">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <svg class="h-5 w-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-4 text-dark-400 hover:text-white">
                                    <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember me -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="rounded border-dark-600 bg-dark-700 text-primary-500 focus:ring-primary-500 focus:ring-offset-dark-800">
                                <span class="text-sm text-dark-400">Lembrar-me</span>
                            </label>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Entrar
                        </button>
                    </form>

                    <!-- Register link -->
                    <div class="mt-8 text-center">
                        <p class="text-dark-400">
                            Não tem uma conta? 
                            <a href="{{ route('client.register') }}" class="font-medium text-primary-400 hover:text-primary-300 transition-colors">
                                Criar conta
                            </a>
                        </p>
                    </div>

                    <!-- Admin link -->
                    <div class="mt-4 pt-4 border-t border-dark-700 text-center">
                        <p class="text-sm text-dark-500">
                            É administrador? 
                            <a href="{{ route('login') }}" class="font-medium text-dark-400 hover:text-white transition-colors">
                                Acesso Admin
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

