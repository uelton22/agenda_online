<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Client::query();

        // Search by name, email, phone or CPF
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by CPF (exact match)
        if ($request->filled('cpf')) {
            $query->byCpf($request->cpf);
        }

        // Filter by status
        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        // Pagination
        $perPage = $request->input('per_page', 15);
        $clients = $query->orderBy('name', 'asc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $clients->items(),
            'meta' => [
                'current_page' => $clients->currentPage(),
                'last_page' => $clients->lastPage(),
                'per_page' => $clients->perPage(),
                'total' => $clients->total(),
            ],
        ]);
    }

    /**
     * Store a newly created client.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'min:11', 'max:14', 'unique:clients,cpf'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.email' => 'Digite um e-mail válido.',
        ]);

        // Clean CPF
        $cpfClean = preg_replace('/\D/', '', $validated['cpf']);

        $client = Client::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'cpf' => $cpfClean,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente cadastrado com sucesso!',
            'data' => $client,
        ], 201);
    }

    /**
     * Display the specified client.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Client $client)
    {
        return response()->json([
            'success' => true,
            'data' => $client,
        ]);
    }

    /**
     * Find client by CPF.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function findByCpf(string $cpf)
    {
        $cpfClean = preg_replace('/\D/', '', $cpf);

        $client = Client::byCpf($cpfClean)->first();

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente não encontrado.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $client,
        ]);
    }

    /**
     * Update the specified client.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'cpf' => ['sometimes', 'string', 'min:11', 'max:14', Rule::unique('clients')->ignore($client->id)],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.email' => 'Digite um e-mail válido.',
        ]);

        $updateData = [];

        if (isset($validated['name'])) {
            $updateData['name'] = $validated['name'];
        }

        if (isset($validated['cpf'])) {
            $updateData['cpf'] = preg_replace('/\D/', '', $validated['cpf']);
        }

        if (array_key_exists('email', $validated)) {
            $updateData['email'] = $validated['email'];
        }

        if (array_key_exists('phone', $validated)) {
            $updateData['phone'] = $validated['phone'];
        }

        if (array_key_exists('notes', $validated)) {
            $updateData['notes'] = $validated['notes'];
        }

        if (isset($validated['is_active'])) {
            $updateData['is_active'] = $validated['is_active'];
        }

        $client->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Cliente atualizado com sucesso!',
            'data' => $client->fresh(),
        ]);
    }

    /**
     * Remove the specified client.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cliente excluído com sucesso!',
        ]);
    }

    /**
     * Get client statistics.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics()
    {
        $stats = [
            'total' => Client::count(),
            'active' => Client::where('is_active', true)->count(),
            'inactive' => Client::where('is_active', false)->count(),
            'recent' => Client::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}

