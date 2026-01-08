<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'duration',
        'color',
        'is_active',
    ];

    /**
     * Get the professionals associated with the service.
     */
    public function professionals(): BelongsToMany
    {
        return $this->belongsToMany(Professional::class, 'professional_service')
            ->withPivot(['price', 'duration', 'available_slots', 'is_active'])
            ->withTimestamps();
    }

    /**
     * Get the active professionals associated with the service.
     */
    public function activeProfessionals(): BelongsToMany
    {
        return $this->professionals()
            ->where('professionals.is_active', true)
            ->wherePivot('is_active', true);
    }

    /**
     * Check if service has professionals assigned.
     */
    public function hasProfessionals(): bool
    {
        return $this->professionals()->count() > 0;
    }

    /**
     * Get professionals count.
     */
    public function getProfessionalsCountAttribute(): int
    {
        return $this->professionals()->count();
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'duration' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Days of week in Portuguese
     */
    public const DAYS_OF_WEEK = [
        0 => 'Domingo',
        1 => 'Segunda-feira',
        2 => 'Terça-feira',
        3 => 'Quarta-feira',
        4 => 'Quinta-feira',
        5 => 'Sexta-feira',
        6 => 'Sábado',
    ];

    /**
     * Short days of week
     */
    public const SHORT_DAYS = [
        0 => 'Dom',
        1 => 'Seg',
        2 => 'Ter',
        3 => 'Qua',
        4 => 'Qui',
        5 => 'Sex',
        6 => 'Sáb',
    ];

    /**
     * Get the user that owns the service.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the schedules for the service.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(ServiceSchedule::class)->orderBy('day_of_week');
    }

    /**
     * Get active schedules
     */
    public function activeSchedules(): HasMany
    {
        return $this->schedules()->where('is_active', true);
    }

    /**
     * Get appointments for this service.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'R$ ' . number_format($this->price, 2, ',', '.');
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute(): string
    {
        $hours = intdiv($this->duration, 60);
        $minutes = $this->duration % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}min";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}min";
        }
    }

    /**
     * Get initials for avatar
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';

        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return $initials;
    }

    /**
     * Generate time slots based on duration for a specific day
     */
    public function getTimeSlotsForDay(int $dayOfWeek): array
    {
        $schedule = $this->schedules->firstWhere('day_of_week', $dayOfWeek);

        if (!$schedule || !$schedule->is_active) {
            return [];
        }

        return $this->generateTimeSlots(
            $schedule->start_time,
            $schedule->end_time,
            $this->duration
        );
    }

    /**
     * Generate time slots between start and end time
     */
    public function generateTimeSlots(string $startTime, string $endTime, int $intervalMinutes): array
    {
        $slots = [];
        $start = strtotime($startTime);
        $end = strtotime($endTime);
        $interval = $intervalMinutes * 60; // Convert to seconds

        // The last slot should be at least duration minutes before end time
        $lastSlotTime = $end - ($intervalMinutes * 60);

        while ($start <= $lastSlotTime) {
            $slots[] = date('H:i', $start);
            $start += $interval;
        }

        return $slots;
    }

    /**
     * Get all available time slots organized by day
     */
    public function getAllTimeSlots(): array
    {
        $allSlots = [];

        foreach ($this->activeSchedules as $schedule) {
            $allSlots[$schedule->day_of_week] = [
                'day_name' => self::DAYS_OF_WEEK[$schedule->day_of_week],
                'short_name' => self::SHORT_DAYS[$schedule->day_of_week],
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'slots' => $this->generateTimeSlots(
                    $schedule->start_time,
                    $schedule->end_time,
                    $this->duration
                ),
            ];
        }

        return $allSlots;
    }

    /**
     * Get working days as array
     */
    public function getWorkingDaysAttribute(): array
    {
        return $this->activeSchedules->pluck('day_of_week')->toArray();
    }

    /**
     * Get working days names
     */
    public function getWorkingDaysNamesAttribute(): array
    {
        $names = [];
        foreach ($this->activeSchedules as $schedule) {
            $names[] = self::SHORT_DAYS[$schedule->day_of_week];
        }
        return $names;
    }

    /**
     * Scope a query to search services.
     */
    public function scopeSearch($query, ?string $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Scope for active services
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if service is available on a specific day
     */
    public function isAvailableOnDay(int $dayOfWeek): bool
    {
        return $this->activeSchedules->contains('day_of_week', $dayOfWeek);
    }

    /**
     * Check if service is available at a specific time on a specific day
     */
    public function isAvailableAt(int $dayOfWeek, string $time): bool
    {
        $schedule = $this->activeSchedules->firstWhere('day_of_week', $dayOfWeek);

        if (!$schedule) {
            return false;
        }

        $requestedTime = strtotime($time);
        $startTime = strtotime($schedule->start_time);
        $endTime = strtotime($schedule->end_time) - ($this->duration * 60);

        return $requestedTime >= $startTime && $requestedTime <= $endTime;
    }
}

