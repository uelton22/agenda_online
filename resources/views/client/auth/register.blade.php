<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Criar Conta - {{ config('app.name', 'Agenda Online') }}</title>

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
                        Crie sua conta
                    </h1>
                    <p class="text-lg text-dark-300 max-w-md">
                        Cadastre-se gratuitamente e comece a agendar seus serviços de forma rápida e prática.
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-500/20 text-primary-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-white">Cadastro gratuito</p>
                            <p class="text-sm text-dark-400">Sem taxas ou custos ocultos</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-secondary-500/20 text-secondary-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-white">Dados seguros</p>
                            <p class="text-sm text-dark-400">Suas informações estão protegidas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side - Register form -->
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
                        <h2 class="text-2xl font-bold text-white mb-2">Criar Conta</h2>
                        <p class="text-dark-400">Preencha seus dados para se cadastrar</p>
                    </div>

                    <form method="POST" action="{{ route('client.register') }}" class="space-y-5" x-data="{ cpf: '' }">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-dark-300 mb-2">Nome Completo</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="w-full rounded-xl border-dark-600 bg-dark-700/50 text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 py-3"
                                   placeholder="Seu nome completo">
                            @error('name')
                                <p class="mt-2 text-sm text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-dark-300 mb-2">E-mail</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full rounded-xl border-dark-600 bg-dark-700/50 text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 py-3"
                                   placeholder="seu@email.com">
                            @error('email')
                                <p class="mt-2 text-sm text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- CPF -->
                        <div>
                            <label for="cpf" class="block text-sm font-medium text-dark-300 mb-2">CPF</label>
                            <input id="cpf" type="text" name="cpf" value="{{ old('cpf') }}" required
                                   x-model="cpf"
                                   x-on:input="cpf = cpf.replace(/\D/g, '').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})/, '$1-$2').replace(/(-\d{2})\d+?$/, '$1')"
                                   maxlength="14"
                                   class="w-full rounded-xl border-dark-600 bg-dark-700/50 text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 py-3"
                                   placeholder="000.000.000-00">
                            @error('cpf')
                                <p class="mt-2 text-sm text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-dark-300 mb-2">Telefone</label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                                   class="w-full rounded-xl border-dark-600 bg-dark-700/50 text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 py-3"
                                   placeholder="(00) 00000-0000">
                            @error('phone')
                                <p class="mt-2 text-sm text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-dark-300 mb-2">Senha</label>
                            <input id="password" type="password" name="password" required
                                   class="w-full rounded-xl border-dark-600 bg-dark-700/50 text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 py-3"
                                   placeholder="••••••••">
                            @error('password')
                                <p class="mt-2 text-sm text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-dark-300 mb-2">Confirmar Senha</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   class="w-full rounded-xl border-dark-600 bg-dark-700/50 text-white placeholder-dark-400 focus:border-primary-500 focus:ring-primary-500 py-3"
                                   placeholder="••••••••">
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Criar Conta
                        </button>
                    </form>

                    <!-- Login link -->
                    <div class="mt-8 text-center">
                        <p class="text-dark-400">
                            Já tem uma conta? 
                            <a href="{{ route('client.login') }}" class="font-medium text-primary-400 hover:text-primary-300 transition-colors">
                                Fazer login
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

