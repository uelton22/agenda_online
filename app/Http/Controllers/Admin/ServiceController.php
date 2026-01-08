<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceSchedule;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Service::with('schedules');

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $services = $query->orderBy('name', 'asc')->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $daysOfWeek = Service::DAYS_OF_WEEK;
        $professionals = Professional::active()->orderBy('name')->get();
        return view('admin.services.create', compact('daysOfWeek', 'professionals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:5', 'max:480'],
            'color' => ['required', 'string', 'size:7', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'is_active' => ['boolean'],
            'professionals' => ['nullable', 'array'],
            'professionals.*' => ['exists:professionals,id'],
            'schedules' => ['required', 'array', 'min:1'],
            'schedules.*.day_of_week' => ['required', 'integer', 'between:0,6'],
            'schedules.*.start_time' => ['required', 'date_format:H:i'],
            'schedules.*.end_time' => ['required', 'date_format:H:i', 'after:schedules.*.start_time'],
            'schedules.*.is_active' => ['boolean'],
            'schedules.*.available_slots' => ['nullable', 'array'],
            'schedules.*.available_slots.*' => ['date_format:H:i'],
        ], [
            'name.required' => 'O nome do serviço é obrigatório.',
            'price.required' => 'O preço é obrigatório.',
            'price.min' => 'O preço não pode ser negativo.',
            'duration.required' => 'A duração é obrigatória.',
            'duration.min' => 'A duração mínima é de 5 minutos.',
            'duration.max' => 'A duração máxima é de 8 horas (480 minutos).',
            'color.required' => 'Selecione uma cor para o serviço.',
            'schedules.required' => 'Configure pelo menos um dia de atendimento.',
            'schedules.min' => 'Configure pelo menos um dia de atendimento.',
            'schedules.*.end_time.after' => 'O horário de término deve ser após o horário de início.',
        ]);

        DB::beginTransaction();

        try {
            $service = Service::create([
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'duration' => $validated['duration'],
                'color' => $validated['color'],
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Attach professionals to the service
            if (!empty($validated['professionals'])) {
                $service->professionals()->attach($validated['professionals']);
            }

            // Create schedules with available slots
            foreach ($validated['schedules'] as $scheduleData) {
                $availableSlots = $scheduleData['available_slots'] ?? null;
                
                // If available_slots is empty array or not set, store null (all slots available)
                if (empty($availableSlots)) {
                    $availableSlots = null;
                }

                $service->schedules()->create([
                    'day_of_week' => $scheduleData['day_of_week'],
                    'start_time' => $scheduleData['start_time'],
                    'end_time' => $scheduleData['end_time'],
                    'available_slots' => $availableSlots,
                    'is_active' => $scheduleData['is_active'] ?? true,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Serviço cadastrado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar serviço: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $service->load('schedules');
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $service->load('schedules', 'professionals');
        $daysOfWeek = Service::DAYS_OF_WEEK;
        $professionals = Professional::active()->orderBy('name')->get();

        // Organize schedules by day of week for easy access
        $schedulesByDay = $service->schedules->keyBy('day_of_week');

        // Get IDs of professionals assigned to this service
        $assignedProfessionals = $service->professionals->pluck('id')->toArray();

        return view('admin.services.edit', compact('service', 'daysOfWeek', 'schedulesByDay', 'professionals', 'assignedProfessionals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:5', 'max:480'],
            'color' => ['required', 'string', 'size:7', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'is_active' => ['boolean'],
            'professionals' => ['nullable', 'array'],
            'professionals.*' => ['exists:professionals,id'],
            'schedules' => ['required', 'array', 'min:1'],
            'schedules.*.day_of_week' => ['required', 'integer', 'between:0,6'],
            'schedules.*.start_time' => ['required', 'date_format:H:i'],
            'schedules.*.end_time' => ['required', 'date_format:H:i', 'after:schedules.*.start_time'],
            'schedules.*.is_active' => ['boolean'],
            'schedules.*.available_slots' => ['nullable', 'array'],
            'schedules.*.available_slots.*' => ['date_format:H:i'],
        ], [
            'name.required' => 'O nome do serviço é obrigatório.',
            'price.required' => 'O preço é obrigatório.',
            'price.min' => 'O preço não pode ser negativo.',
            'duration.required' => 'A duração é obrigatória.',
            'duration.min' => 'A duração mínima é de 5 minutos.',
            'duration.max' => 'A duração máxima é de 8 horas (480 minutos).',
            'color.required' => 'Selecione uma cor para o serviço.',
            'schedules.required' => 'Configure pelo menos um dia de atendimento.',
            'schedules.min' => 'Configure pelo menos um dia de atendimento.',
            'schedules.*.end_time.after' => 'O horário de término deve ser após o horário de início.',
        ]);

        DB::beginTransaction();

        try {
            $service->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'duration' => $validated['duration'],
                'color' => $validated['color'],
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Sync professionals
            $service->professionals()->sync($validated['professionals'] ?? []);

            // Delete existing schedules and recreate
            $service->schedules()->delete();

            foreach ($validated['schedules'] as $scheduleData) {
                $availableSlots = $scheduleData['available_slots'] ?? null;
                
                // If available_slots is empty array or not set, store null (all slots available)
                if (empty($availableSlots)) {
                    $availableSlots = null;
                }

                $service->schedules()->create([
                    'day_of_week' => $scheduleData['day_of_week'],
                    'start_time' => $scheduleData['start_time'],
                    'end_time' => $scheduleData['end_time'],
                    'available_slots' => $availableSlots,
                    'is_active' => $scheduleData['is_active'] ?? true,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Serviço atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Erro ao atualizar serviço: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Serviço excluído com sucesso!');
    }

    /**
     * Toggle service active status
     */
    public function toggleStatus(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);

        $status = $service->is_active ? 'ativado' : 'desativado';

        return back()->with('success', "Serviço {$status} com sucesso!");
    }

    /**
     * Preview time slots for a service
     */
    public function previewSlots(Request $request)
    {
        $request->validate([
            'duration' => ['required', 'integer', 'min:5'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        $service = new Service(['duration' => $request->duration]);
        $slots = $service->generateTimeSlots(
            $request->start_time,
            $request->end_time,
            $request->duration
        );

        return response()->json([
            'success' => true,
            'slots' => $slots,
            'count' => count($slots),
        ]);
    }
}

