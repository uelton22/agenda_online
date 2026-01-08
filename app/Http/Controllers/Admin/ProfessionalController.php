<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Professional::withCount(['services', 'appointments']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('specialty', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $professionals = $query->orderBy('name')->paginate(15);

        return view('admin.professionals.index', compact('professionals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::active()->orderBy('name')->get();
        return view('admin.professionals.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:professionals'],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'color' => ['required', 'string', 'max:7'],
            'is_active' => ['boolean'],
            'services' => ['nullable', 'array'],
            'services.*' => ['exists:services,id'],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Digite um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'color.required' => 'A cor é obrigatória.',
        ]);

        $professional = Professional::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'specialty' => $validated['specialty'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'color' => $validated['color'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Attach services if provided
        if (!empty($validated['services'])) {
            $professional->services()->attach($validated['services']);
        }

        return redirect()
            ->route('admin.professionals.index')
            ->with('success', 'Profissional criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Professional $professional)
    {
        $professional->load(['services', 'appointments' => function ($query) {
            $query->with(['client', 'service'])
                ->orderBy('scheduled_date', 'desc')
                ->orderBy('scheduled_time', 'desc')
                ->limit(10);
        }]);

        return view('admin.professionals.show', compact('professional'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Professional $professional)
    {
        $services = Service::active()->orderBy('name')->get();
        $professional->load('services');
        
        return view('admin.professionals.edit', compact('professional', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Professional $professional)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('professionals')->ignore($professional->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'color' => ['required', 'string', 'max:7'],
            'is_active' => ['boolean'],
            'services' => ['nullable', 'array'],
            'services.*' => ['exists:services,id'],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Digite um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'color.required' => 'A cor é obrigatória.',
        ]);

        $professional->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'specialty' => $validated['specialty'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'color' => $validated['color'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Sync services
        $professional->services()->sync($validated['services'] ?? []);

        return redirect()
            ->route('admin.professionals.index')
            ->with('success', 'Profissional atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Professional $professional)
    {
        // Check for appointments
        if ($professional->appointments()->count() > 0) {
            return back()->with('error', 'Não é possível excluir um profissional com agendamentos. Desative-o ao invés disso.');
        }

        $professional->delete();

        return redirect()
            ->route('admin.professionals.index')
            ->with('success', 'Profissional excluído com sucesso!');
    }

    /**
     * Toggle professional active status
     */
    public function toggleStatus(Professional $professional)
    {
        $professional->update(['is_active' => !$professional->is_active]);

        $status = $professional->is_active ? 'ativado' : 'desativado';

        return back()->with('success', "Profissional {$status} com sucesso!");
    }

    /**
     * Configure service pricing and availability for professional
     */
    public function configureService(Request $request, Professional $professional, Service $service)
    {
        $validated = $request->validate([
            'price' => ['nullable', 'numeric', 'min:0'],
            'duration' => ['nullable', 'integer', 'min:5'],
            'available_slots' => ['nullable', 'array'],
            'is_active' => ['boolean'],
        ]);

        $professional->services()->syncWithoutDetaching([
            $service->id => [
                'price' => $validated['price'] ?? null,
                'duration' => $validated['duration'] ?? null,
                'available_slots' => isset($validated['available_slots']) ? json_encode($validated['available_slots']) : null,
                'is_active' => $request->boolean('is_active', true),
            ],
        ]);

        return back()->with('success', 'Configurações do serviço atualizadas com sucesso!');
    }
}

