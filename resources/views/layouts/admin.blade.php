<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Agenda Online') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased bg-dark-100 dark:bg-dark-900">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-dark-900/80 lg:hidden" 
             @click="sidebarOpen = false">
        </div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-72 transform bg-gradient-to-b from-dark-900 via-dark-800 to-dark-900 transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col">
            
            <!-- Logo -->
            <div class="flex h-20 items-center justify-between px-6 border-b border-dark-700/50 flex-shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-lg font-bold text-white">Agenda</span>
                        <span class="text-lg font-light text-primary-400">Online</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-dark-400 hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation with scroll -->
            <nav class="flex-1 space-y-1 px-4 py-6 overflow-y-auto scrollbar-thin scrollbar-thumb-dark-600 scrollbar-track-transparent">
                <p class="px-3 mb-3 text-xs font-semibold uppercase tracking-wider text-dark-500">Menu Principal</p>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>
                    <span>Administradores</span>
                </a>

                <p class="px-3 mt-8 mb-3 text-xs font-semibold uppercase tracking-wider text-dark-500">Agendamentos</p>

                <a href="{{ route('admin.calendar.index') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.calendar.*') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('admin.calendar.*') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <span>Calendário</span>
                </a>

                <a href="{{ route('admin.appointments.index') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.appointments.*') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('admin.appointments.*') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </span>
                    <span>Agendamentos</span>
                </a>

                <a href="{{ route('admin.services.index') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.services.*') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('admin.services.*') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <span>Serviços</span>
                </a>

                <a href="{{ route('admin.professionals.index') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.professionals.*') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('admin.professionals.*') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <span>Profissionais</span>
                </a>

                <a href="{{ route('admin.clients.index') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.clients.*') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('admin.clients.*') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </span>
                    <span>Clientes</span>
                </a>

                <!-- <p class="px-3 mt-8 mb-3 text-xs font-semibold uppercase tracking-wider text-dark-500">Financeiro</p>

                <a href="#" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-dark-400 hover:bg-dark-700/50 hover:text-white transition-all duration-200">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-dark-700 group-hover:bg-dark-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <span>Contas a Receber</span>
                    <span class="ml-auto rounded-full bg-primary-500/20 px-2.5 py-0.5 text-xs font-medium text-primary-400">Em breve</span>
                </a>

                <a href="#" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-dark-400 hover:bg-dark-700/50 hover:text-white transition-all duration-200">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-dark-700 group-hover:bg-dark-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </span>
                    <span>Contas a Pagar</span>
                    <span class="ml-auto rounded-full bg-primary-500/20 px-2.5 py-0.5 text-xs font-medium text-primary-400">Em breve</span>
                </a> -->

                <p class="px-3 mt-8 mb-3 text-xs font-semibold uppercase tracking-wider text-dark-500">Integrações</p>

                <a href="{{ route('admin.api.tokens') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.api.tokens') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('admin.api.tokens') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </span>
                    <span>Tokens de API</span>
                </a>

                <a href="{{ route('admin.api.documentation') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.api.documentation') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('admin.api.documentation') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    <span>Documentação</span>
                </a>
            </nav>

            <!-- User section - Fixed at bottom -->
            <div class="border-t border-dark-700/50 p-4 flex-shrink-0 bg-dark-900">
                <div class="flex items-center gap-3 rounded-xl bg-dark-800/50 p-3">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" 
                         class="h-10 w-10 rounded-full object-cover ring-2 ring-primary-500/30">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-dark-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg p-2 text-dark-400 hover:bg-dark-700 hover:text-white transition-colors" title="Sair">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main content -->
        <div class="lg:pl-72">
            <!-- Top navbar -->
            <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-dark-200 dark:border-dark-700/50 bg-white/80 dark:bg-dark-900/80 backdrop-blur-xl px-4 sm:px-6 lg:px-8">
                <button @click="sidebarOpen = true" class="lg:hidden text-dark-500 hover:text-dark-900 dark:text-dark-400 dark:hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex-1">
                    @isset($header)
                        <h1 class="text-xl font-semibold text-dark-900 dark:text-white">{{ $header }}</h1>
                    @endisset
                </div>

                <div class="flex items-center gap-4">
                    <!-- Notifications -->
                    <button class="relative rounded-full p-2 text-dark-500 hover:bg-dark-100 dark:text-dark-400 dark:hover:bg-dark-800 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-danger-500"></span>
                    </button>

                    <!-- Profile dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 rounded-full p-1 hover:bg-dark-100 dark:hover:bg-dark-800 transition-colors">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" 
                                 class="h-8 w-8 rounded-full object-cover">
                            <svg class="h-4 w-4 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 rounded-xl bg-white dark:bg-dark-800 shadow-lg ring-1 ring-dark-200 dark:ring-dark-700 py-2">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-dark-700 dark:text-dark-300 hover:bg-dark-100 dark:hover:bg-dark-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Meu Perfil
                            </a>
                            <hr class="my-2 border-dark-200 dark:border-dark-700">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-danger-600 dark:text-danger-400 hover:bg-dark-100 dark:hover:bg-dark-700">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="p-4 sm:p-6 lg:p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-init="setTimeout(() => show = false, 5000)"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="mb-6 flex items-center gap-3 rounded-xl bg-success-50 dark:bg-success-500/10 border border-success-200 dark:border-success-500/20 p-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-success-100 dark:bg-success-500/20">
                            <svg class="h-5 w-5 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <p class="flex-1 text-sm font-medium text-success-700 dark:text-success-300">{{ session('success') }}</p>
                        <button @click="show = false" class="text-success-500 hover:text-success-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-init="setTimeout(() => show = false, 5000)"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="mb-6 flex items-center gap-3 rounded-xl bg-danger-50 dark:bg-danger-500/10 border border-danger-200 dark:border-danger-500/20 p-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-danger-100 dark:bg-danger-500/20">
                            <svg class="h-5 w-5 text-danger-600 dark:text-danger-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="flex-1 text-sm font-medium text-danger-700 dark:text-danger-300">{{ session('error') }}</p>
                        <button @click="show = false" class="text-danger-500 hover:text-danger-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>

