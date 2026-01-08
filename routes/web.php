<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProfessionalController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\ApiTokenController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\AppointmentController as ClientAppointmentController;
use App\Http\Controllers\Client\CalendarController as ClientCalendarController;
use App\Http\Controllers\Client\Auth\LoginController as ClientLoginController;
use App\Http\Controllers\Client\Auth\RegisterController as ClientRegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Página Inicial
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Se admin logado, vai para admin dashboard
    if (auth()->check() && auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    // Se cliente logado, vai para client dashboard
    if (auth()->guard('client')->check()) {
        return redirect()->route('client.dashboard');
    }
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard - Redireciona para o painel correto
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    if (auth()->guard('client')->check()) {
        return redirect()->route('client.dashboard');
    }
    return redirect()->route('home');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação do Cliente
|--------------------------------------------------------------------------
*/
Route::prefix('cliente')->name('client.')->group(function () {
    // Guest routes (login, register)
    Route::middleware('guest.client')->group(function () {
        Route::get('/login', [ClientLoginController::class, 'create'])->name('login');
        Route::post('/login', [ClientLoginController::class, 'store']);
        Route::get('/registro', [ClientRegisterController::class, 'create'])->name('register');
        Route::post('/registro', [ClientRegisterController::class, 'store']);
    });

    // Authenticated client routes
    Route::middleware('auth.client')->group(function () {
        Route::post('/logout', [ClientLoginController::class, 'destroy'])->name('logout');
        
        // Dashboard
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
        
        // Meus Agendamentos
        Route::get('/agendamentos', [ClientAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/agendamentos/novo', [ClientAppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/agendamentos', [ClientAppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/agendamentos/{appointment}', [ClientAppointmentController::class, 'show'])->name('appointments.show');
        Route::post('/agendamentos/{appointment}/cancelar', [ClientAppointmentController::class, 'cancel'])->name('appointments.cancel');
        Route::get('/horarios-disponiveis', [ClientAppointmentController::class, 'getAvailableSlots'])->name('appointments.available-slots');
        
        // Calendário
        Route::get('/calendario', [ClientCalendarController::class, 'index'])->name('calendar.index');
        Route::get('/calendario/eventos', [ClientCalendarController::class, 'events'])->name('calendar.events');
        Route::get('/calendario/agendamento/{appointment}', [ClientCalendarController::class, 'getAppointment'])->name('calendar.appointment');
    });
});

/*
|--------------------------------------------------------------------------
| Rotas Autenticadas do Admin (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rotas do Administrador
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // CRUD de Administradores (gerenciar outros admins)
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');

        // CRUD de Clientes (admin gerencia clientes)
        Route::resource('clients', ClientController::class);
        Route::patch('clients/{client}/toggle-status', [ClientController::class, 'toggleStatus'])
            ->name('clients.toggle-status');

        // CRUD de Profissionais
        Route::resource('professionals', ProfessionalController::class);
        Route::patch('professionals/{professional}/toggle-status', [ProfessionalController::class, 'toggleStatus'])
            ->name('professionals.toggle-status');
        Route::post('professionals/{professional}/services/{service}', [ProfessionalController::class, 'configureService'])
            ->name('professionals.configure-service');

        // CRUD de Serviços
        Route::resource('services', ServiceController::class);
        Route::patch('services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])
            ->name('services.toggle-status');
        Route::post('services/preview-slots', [ServiceController::class, 'previewSlots'])
            ->name('services.preview-slots');

        // CRUD de Agendamentos (admin pode selecionar cliente)
        Route::resource('appointments', AppointmentController::class);
        Route::patch('appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])
            ->name('appointments.update-status');
        Route::get('appointments-slots', [AppointmentController::class, 'getAvailableSlots'])
            ->name('appointments.available-slots');
        Route::get('appointments-professionals', [AppointmentController::class, 'getProfessionalsForService'])
            ->name('appointments.professionals');

        // Calendário
        Route::prefix('calendar')->name('calendar.')->group(function () {
            Route::get('/', [CalendarController::class, 'index'])->name('index');
            Route::get('/events', [CalendarController::class, 'events'])->name('events');
            Route::get('/appointment/{appointment}', [CalendarController::class, 'getAppointment'])->name('appointment');
            Route::post('/quick-store', [CalendarController::class, 'quickStore'])->name('quick-store');
            Route::patch('/event/{appointment}', [CalendarController::class, 'updateEvent'])->name('update-event');
        });

        // API Management
        Route::prefix('api')->name('api.')->group(function () {
            Route::get('/tokens', [ApiTokenController::class, 'index'])->name('tokens');
            Route::post('/tokens', [ApiTokenController::class, 'store'])->name('tokens.store');
            Route::delete('/tokens/{token}', [ApiTokenController::class, 'destroy'])->name('tokens.destroy');
            Route::get('/documentation', [ApiTokenController::class, 'documentation'])->name('documentation');
        });
    });

require __DIR__.'/auth.php';
