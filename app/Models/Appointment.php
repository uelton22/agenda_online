<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'service_id',
        'professional_id',
        'user_id',
        'scheduled_date',
        'scheduled_time',
        'end_time',
        'price',
        'status',
        'notes',
        'cancellation_reason',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'scheduled_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'price' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_NO_SHOW = 'no_show';

    const STATUSES = [
        self::STATUS_PENDING => 'Pendente',
        self::STATUS_CONFIRMED => 'Confirmado',
        self::STATUS_COMPLETED => 'Concluído',
        self::STATUS_CANCELLED => 'Cancelado',
        self::STATUS_NO_SHOW => 'Não compareceu',
    ];

    const STATUS_COLORS = [
        self::STATUS_PENDING => '#F59E0B',    // Amber
        self::STATUS_CONFIRMED => '#3B82F6',  // Blue
        self::STATUS_COMPLETED => '#10B981',  // Green
        self::STATUS_CANCELLED => '#EF4444',  // Red
        self::STATUS_NO_SHOW => '#6B7280',    // Gray
    ];

    /**
     * Relationships
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Accessors
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? '#6B7280';
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'R$ ' . number_format($this->price, 2, ',', '.');
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->scheduled_date->format('d/m/Y');
    }

    public function getFormattedTimeAttribute(): string
    {
        return Carbon::parse($this->scheduled_time)->format('H:i');
    }

    public function getFormattedEndTimeAttribute(): string
    {
        return Carbon::parse($this->end_time)->format('H:i');
    }

    public function getTimeRangeAttribute(): string
    {
        return $this->formatted_time . ' - ' . $this->formatted_end_time;
    }

    public function getFormattedDateTimeAttribute(): string
    {
        return $this->formatted_date . ' às ' . $this->formatted_time;
    }

    public function getDayOfWeekAttribute(): string
    {
        $days = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
        return $days[$this->scheduled_date->dayOfWeek];
    }

    public function getCalendarColorAttribute(): string
    {
        // Use service color for calendar display, with status overlay
        return $this->service ? $this->service->color : '#6366F1';
    }

    /**
     * Scopes
     */
    public function scopeToday($query)
    {
        return $query->whereDate('scheduled_date', Carbon::today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('scheduled_date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('scheduled_date', Carbon::now()->month)
                     ->whereYear('scheduled_date', Carbon::now()->year);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_date', '>=', Carbon::today())
                     ->orderBy('scheduled_date')
                     ->orderBy('scheduled_time');
    }

    public function scopePast($query)
    {
        return $query->where('scheduled_date', '<', Carbon::today())
                     ->orderBy('scheduled_date', 'desc')
                     ->orderBy('scheduled_time', 'desc');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    public function scopeForRevenue($query)
    {
        return $query->whereIn('status', [self::STATUS_COMPLETED, self::STATUS_CONFIRMED]);
    }

    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('scheduled_date', [$startDate, $endDate]);
    }

    /**
     * Methods
     */
    public function confirm(): bool
    {
        $this->status = self::STATUS_CONFIRMED;
        $this->confirmed_at = now();
        return $this->save();
    }

    public function complete(): bool
    {
        $this->status = self::STATUS_COMPLETED;
        $this->completed_at = now();
        return $this->save();
    }

    public function cancel(?string $reason = null): bool
    {
        $this->status = self::STATUS_CANCELLED;
        $this->cancelled_at = now();
        $this->cancellation_reason = $reason;
        return $this->save();
    }

    public function markAsNoShow(): bool
    {
        $this->status = self::STATUS_NO_SHOW;
        return $this->save();
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function canBeEdited(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED]);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED]);
    }

    /**
     * Check if the time slot is available for a specific professional
     */
    public static function isSlotAvailable(int $serviceId, string $date, string $time, ?int $professionalId = null, ?int $excludeId = null): bool
    {
        $service = Service::find($serviceId);
        if (!$service) {
            return false;
        }

        // Determinar a duração com base no profissional ou serviço
        $duration = $service->duration;
        if ($professionalId) {
            $professional = Professional::find($professionalId);
            if ($professional) {
                $duration = $professional->getDurationForService($service);
            }
        }

        $startTime = Carbon::parse($time);
        $endTime = $startTime->copy()->addMinutes($duration);

        $query = self::where('scheduled_date', $date)
            ->whereNotIn('status', [self::STATUS_CANCELLED])
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where(function ($inner) use ($startTime, $endTime) {
                    // New appointment starts during existing appointment
                    $inner->where('scheduled_time', '<=', $startTime->format('H:i'))
                          ->where('end_time', '>', $startTime->format('H:i'));
                })->orWhere(function ($inner) use ($startTime, $endTime) {
                    // New appointment ends during existing appointment
                    $inner->where('scheduled_time', '<', $endTime->format('H:i'))
                          ->where('end_time', '>=', $endTime->format('H:i'));
                })->orWhere(function ($inner) use ($startTime, $endTime) {
                    // New appointment contains existing appointment
                    $inner->where('scheduled_time', '>=', $startTime->format('H:i'))
                          ->where('end_time', '<=', $endTime->format('H:i'));
                });
            });

        // Se um profissional for especificado, verificar apenas os agendamentos dele
        if ($professionalId) {
            $query->where('professional_id', $professionalId);
        } else {
            // Se não houver profissional, verificar conflitos com o serviço em geral
            $query->where('service_id', $serviceId);
        }

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->count() === 0;
    }

    /**
     * Check if any professional is available for the slot
     */
    public static function getAvailableProfessionalsForSlot(int $serviceId, string $date, string $time): array
    {
        $service = Service::with('activeProfessionals')->find($serviceId);
        if (!$service) {
            return [];
        }

        $availableProfessionals = [];

        foreach ($service->activeProfessionals as $professional) {
            if (self::isSlotAvailable($serviceId, $date, $time, $professional->id)) {
                $availableProfessionals[] = $professional;
            }
        }

        return $availableProfessionals;
    }

    /**
     * Get calendar event format for FullCalendar
     */
    public function toCalendarEvent(): array
    {
        $title = $this->client->full_name . ' - ' . $this->service->name;
        if ($this->professional) {
            $title .= ' (' . $this->professional->name . ')';
        }

        return [
            'id' => $this->id,
            'title' => $title,
            'start' => $this->scheduled_date->format('Y-m-d') . 'T' . $this->formatted_time,
            'end' => $this->scheduled_date->format('Y-m-d') . 'T' . $this->formatted_end_time,
            'backgroundColor' => $this->professional ? $this->professional->color : $this->calendar_color,
            'borderColor' => $this->status_color,
            'textColor' => '#ffffff',
            'extendedProps' => [
                'client_id' => $this->client_id,
                'client_name' => $this->client->full_name,
                'client_phone' => $this->client->phone,
                'service_id' => $this->service_id,
                'service_name' => $this->service->name,
                'service_color' => $this->service->color,
                'professional_id' => $this->professional_id,
                'professional_name' => $this->professional?->name,
                'professional_color' => $this->professional?->color,
                'price' => $this->price,
                'price_formatted' => $this->formatted_price,
                'status' => $this->status,
                'status_label' => $this->status_label,
                'status_color' => $this->status_color,
                'notes' => $this->notes,
                'time_range' => $this->time_range,
            ],
        ];
    }

    /**
     * Get the professional name or a default value
     */
    public function getProfessionalNameAttribute(): string
    {
        return $this->professional?->name ?? 'Sem profissional';
    }
}

