<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ProfessionalController;
use App\Http\Controllers\Api\AppointmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// ============================================================================
// PUBLIC ROUTES
// ============================================================================

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

// ============================================================================
// PROTECTED ROUTES (Require Authentication)
// ============================================================================

Route::middleware('auth:sanctum')->group(function () {
    
    // --------------------------------------------------------------------
    // Authentication
    // --------------------------------------------------------------------
    Route::prefix('auth')->group(function () {
        Route::get('/user', function (Request $request) {
            return response()->json([
                'success' => true,
                'data' => $request->user()->load('roles'),
            ]);
        });
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    });

    // --------------------------------------------------------------------
    // Users API
    // --------------------------------------------------------------------
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/statistics', [UserController::class, 'statistics']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::patch('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    // --------------------------------------------------------------------
    // Clients API
    // --------------------------------------------------------------------
    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index']);
        Route::post('/', [ClientController::class, 'store']);
        Route::get('/statistics', [ClientController::class, 'statistics']);
        Route::get('/cpf/{cpf}', [ClientController::class, 'findByCpf']);
        Route::get('/{client}', [ClientController::class, 'show']);
        Route::put('/{client}', [ClientController::class, 'update']);
        Route::patch('/{client}', [ClientController::class, 'update']);
        Route::delete('/{client}', [ClientController::class, 'destroy']);
    });

    // --------------------------------------------------------------------
    // Professionals API
    // --------------------------------------------------------------------
    Route::prefix('professionals')->group(function () {
        Route::get('/', [ProfessionalController::class, 'index']);
        Route::get('/active', [ProfessionalController::class, 'listActive']);
        Route::get('/available-for-slot', [ProfessionalController::class, 'availableForSlot']);
        Route::get('/statistics', [ProfessionalController::class, 'statistics']);
        Route::post('/', [ProfessionalController::class, 'store']);
        Route::get('/{professional}', [ProfessionalController::class, 'show']);
        Route::get('/{professional}/services', [ProfessionalController::class, 'services']);
        Route::get('/{professional}/available-slots', [ProfessionalController::class, 'availableSlots']);
        Route::put('/{professional}', [ProfessionalController::class, 'update']);
        Route::patch('/{professional}', [ProfessionalController::class, 'update']);
        Route::delete('/{professional}', [ProfessionalController::class, 'destroy']);
    });

    // --------------------------------------------------------------------
    // Services API
    // --------------------------------------------------------------------
    Route::prefix('services')->group(function () {
        Route::get('/', [ServiceController::class, 'index']);
        Route::get('/active', [ServiceController::class, 'listActive']); // Para n8n - lista serviços ativos
        Route::post('/', [ServiceController::class, 'store']);
        Route::get('/statistics', [ServiceController::class, 'statistics']);
        Route::get('/{service}', [ServiceController::class, 'show']);
        Route::get('/{service}/slots', [ServiceController::class, 'weeklySlots']); // Horários semanais
        Route::get('/{service}/available', [ServiceController::class, 'availableSlots']); // Horários disponíveis para data específica
        Route::put('/{service}', [ServiceController::class, 'update']);
        Route::patch('/{service}', [ServiceController::class, 'update']);
        Route::delete('/{service}', [ServiceController::class, 'destroy']);
    });

    // --------------------------------------------------------------------
    // Appointments API
    // --------------------------------------------------------------------
    Route::prefix('appointments')->group(function () {
        Route::get('/', [AppointmentController::class, 'index']);
        Route::post('/', [AppointmentController::class, 'store']);
        Route::get('/today', [AppointmentController::class, 'today']); // Agendamentos de hoje
        Route::get('/statistics', [AppointmentController::class, 'statistics']); // Estatísticas
        Route::get('/available-slots', [AppointmentController::class, 'availableSlots']); // Horários disponíveis
        Route::get('/professionals', [AppointmentController::class, 'professionals']); // Profissionais
        Route::get('/client/{cpf}', [AppointmentController::class, 'byClientCpf']); // Buscar por CPF do cliente
        Route::get('/{appointment}', [AppointmentController::class, 'show']);
        Route::put('/{appointment}', [AppointmentController::class, 'update']);
        Route::patch('/{appointment}', [AppointmentController::class, 'update']);
        Route::patch('/{appointment}/status', [AppointmentController::class, 'updateStatus']); // Atualizar status
        Route::post('/{appointment}/cancel', [AppointmentController::class, 'cancel']); // Cancelar
        Route::delete('/{appointment}', [AppointmentController::class, 'destroy']);
    });
});

// ============================================================================
// API INFO
// ============================================================================

Route::get('/', function () {
    return response()->json([
        'name' => 'Agenda Online API',
        'version' => '1.1.0',
        'description' => 'API REST para integração com sistemas de agendamento',
        'documentation' => url('/admin/api/documentation'),
        'endpoints' => [
            'auth' => [
                'POST /api/auth/login' => 'Autenticar usuário',
                'POST /api/auth/register' => 'Registrar novo usuário',
                'POST /api/auth/logout' => 'Encerrar sessão (requer auth)',
                'GET /api/auth/user' => 'Obter dados do usuário autenticado (requer auth)',
            ],
            'users' => [
                'GET /api/users' => 'Listar usuários (requer auth)',
                'POST /api/users' => 'Criar usuário (requer auth)',
                'GET /api/users/{id}' => 'Obter usuário (requer auth)',
                'PUT /api/users/{id}' => 'Atualizar usuário (requer auth)',
                'DELETE /api/users/{id}' => 'Excluir usuário (requer auth)',
                'GET /api/users/statistics' => 'Estatísticas de usuários (requer auth)',
            ],
            'clients' => [
                'GET /api/clients' => 'Listar clientes (requer auth)',
                'POST /api/clients' => 'Criar cliente (requer auth)',
                'GET /api/clients/{id}' => 'Obter cliente (requer auth)',
                'GET /api/clients/cpf/{cpf}' => 'Buscar cliente por CPF (requer auth)',
                'PUT /api/clients/{id}' => 'Atualizar cliente (requer auth)',
                'DELETE /api/clients/{id}' => 'Excluir cliente (requer auth)',
                'GET /api/clients/statistics' => 'Estatísticas de clientes (requer auth)',
            ],
            'professionals' => [
                'GET /api/professionals' => 'Listar profissionais (requer auth)',
                'GET /api/professionals/active' => 'Listar profissionais ativos (requer auth)',
                'GET /api/professionals/available-for-slot?service_id=X&date=YYYY-MM-DD&time=HH:mm' => 'Profissionais disponíveis para horário (requer auth)',
                'GET /api/professionals/statistics' => 'Estatísticas de profissionais (requer auth)',
                'POST /api/professionals' => 'Criar profissional (requer auth)',
                'GET /api/professionals/{id}' => 'Obter profissional (requer auth)',
                'GET /api/professionals/{id}/services' => 'Serviços do profissional (requer auth)',
                'GET /api/professionals/{id}/available-slots?service_id=X&date=YYYY-MM-DD' => 'Horários disponíveis do profissional (requer auth)',
                'PUT /api/professionals/{id}' => 'Atualizar profissional (requer auth)',
                'DELETE /api/professionals/{id}' => 'Excluir profissional (requer auth)',
            ],
            'services' => [
                'GET /api/services' => 'Listar serviços (requer auth)',
                'GET /api/services/active' => 'Listar serviços ativos para n8n (requer auth)',
                'POST /api/services' => 'Criar serviço (requer auth)',
                'GET /api/services/{id}' => 'Obter serviço com horários e profissionais (requer auth)',
                'GET /api/services/{id}/slots' => 'Horários semanais do serviço (requer auth)',
                'GET /api/services/{id}/available?date=YYYY-MM-DD' => 'Horários disponíveis para data (requer auth)',
                'PUT /api/services/{id}' => 'Atualizar serviço (requer auth)',
                'DELETE /api/services/{id}' => 'Excluir serviço (requer auth)',
                'GET /api/services/statistics' => 'Estatísticas de serviços (requer auth)',
            ],
            'appointments' => [
                'GET /api/appointments' => 'Listar agendamentos (requer auth)',
                'POST /api/appointments' => 'Criar agendamento com professional_id opcional (requer auth)',
                'GET /api/appointments/today' => 'Agendamentos de hoje (requer auth)',
                'GET /api/appointments/statistics' => 'Estatísticas de agendamentos (requer auth)',
                'GET /api/appointments/available-slots?service_id=X&date=YYYY-MM-DD&professional_id=Y' => 'Horários disponíveis (requer auth)',
                'GET /api/appointments/client/{cpf}' => 'Agendamentos por CPF do cliente (requer auth)',
                'GET /api/appointments/{id}' => 'Obter agendamento com profissional (requer auth)',
                'PUT /api/appointments/{id}' => 'Atualizar agendamento (requer auth)',
                'PATCH /api/appointments/{id}/status' => 'Atualizar status (requer auth)',
                'POST /api/appointments/{id}/cancel' => 'Cancelar agendamento (requer auth)',
                'DELETE /api/appointments/{id}' => 'Excluir agendamento (requer auth)',
            ],
        ],
    ]);
});
