<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Agenda Online') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="h-full font-sans antialiased bg-dark-100 dark:bg-dark-900">
    @php
        $client = auth()->guard('client')->user();
    @endphp
    
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
               class="fixed inset-y-0 left-0 z-50 w-72 transform bg-gradient-to-b from-dark-900 via-dark-800 to-dark-900 transition-transform duration-300 ease-in-out lg:translate-x-0">
            
            <!-- Logo -->
            <div class="flex h-20 items-center justify-between px-6 border-b border-dark-700/50">
                <a href="{{ route('client.dashboard') }}" class="flex items-center gap-3">
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

            <!-- Navigation -->
            <nav class="flex-1 space-y-1 px-4 py-6">
                <p class="px-3 mb-3 text-xs font-semibold uppercase tracking-wider text-dark-500">Menu</p>
                
                <a href="{{ route('client.dashboard') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('client.dashboard') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('client.dashboard') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </span>
                    <span>Início</span>
                </a>

                <p class="px-3 mt-8 mb-3 text-xs font-semibold uppercase tracking-wider text-dark-500">Minha Agenda</p>

                <a href="{{ route('client.calendar.index') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('client.calendar.*') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('client.calendar.*') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <span>Calendário</span>
                </a>

                <a href="{{ route('client.appointments.index') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('client.appointments.index') || request()->routeIs('client.appointments.show') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('client.appointments.index') || request()->routeIs('client.appointments.show') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </span>
                    <span>Meus Agendamentos</span>
                </a>

                <a href="{{ route('client.appointments.create') }}" 
                   class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition-all duration-200 {{ request()->routeIs('client.appointments.create') ? 'bg-gradient-to-r from-primary-500/20 to-secondary-500/20 text-white border border-primary-500/30' : 'text-dark-400 hover:bg-dark-700/50 hover:text-white' }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ request()->routeIs('client.appointments.create') ? 'bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30' : 'bg-dark-700 group-hover:bg-dark-600' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </span>
                    <span>Novo Agendamento</span>
                </a>
            </nav>

            <!-- Client section -->
            <div class="border-t border-dark-700/50 p-4">
                <div class="flex items-center gap-3 rounded-xl bg-dark-800/50 p-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 text-white font-medium text-sm">
                        {{ $client->initials }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ $client->name }}</p>
                        <p class="text-xs text-dark-400 truncate">{{ $client->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('client.logout') }}">
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
                    <!-- Profile dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 rounded-full p-1 hover:bg-dark-100 dark:hover:bg-dark-800 transition-colors">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 text-white font-medium text-xs">
                                {{ $client->initials }}
                            </div>
                            <svg class="h-4 w-4 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition
                             class="absolute right-0 mt-2 w-56 rounded-xl bg-white dark:bg-dark-800 shadow-lg ring-1 ring-dark-200 dark:ring-dark-700 py-2">
                            <div class="px-4 py-2 border-b border-dark-200 dark:border-dark-700">
                                <p class="text-sm font-medium text-dark-900 dark:text-white">{{ $client->name }}</p>
                                <p class="text-xs text-dark-500 dark:text-dark-400">{{ $client->email }}</p>
                            </div>
                            <form method="POST" action="{{ route('client.logout') }}">
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
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
