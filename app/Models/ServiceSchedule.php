<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceSchedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'day_of_week',
        'start_time',
        'end_time',
        'available_slots',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'day_of_week' => 'integer',
        'is_active' => 'boolean',
        'available_slots' => 'array',
    ];

    /**
     * Get the service that owns the schedule.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get day name
     */
    public function getDayNameAttribute(): string
    {
        return Service::DAYS_OF_WEEK[$this->day_of_week] ?? 'Desconhecido';
    }

    /**
     * Get short day name
     */
    public function getShortDayNameAttribute(): string
    {
        return Service::SHORT_DAYS[$this->day_of_week] ?? '???';
    }

    /**
     * Get formatted start time
     */
    public function getFormattedStartTimeAttribute(): string
    {
        return date('H:i', strtotime($this->start_time));
    }

    /**
     * Get formatted end time
     */
    public function getFormattedEndTimeAttribute(): string
    {
        return date('H:i', strtotime($this->end_time));
    }

    /**
     * Get formatted time range
     */
    public function getTimeRangeAttribute(): string
    {
        return $this->formatted_start_time . ' - ' . $this->formatted_end_time;
    }

    /**
     * Generate all possible time slots based on service duration
     */
    public function getAllPossibleSlots(): array
    {
        if (!$this->service) {
            return [];
        }

        return $this->service->generateTimeSlots(
            $this->start_time,
            $this->end_time,
            $this->service->duration
        );
    }

    /**
     * Get available time slots - either selected ones or all possible slots
     * If available_slots is set, use those; otherwise, generate all possible slots
     */
    public function getAvailableSlots(): array
    {
        if (!$this->is_active || !$this->service) {
            return [];
        }

        // If specific slots are selected, use them
        if (!empty($this->available_slots) && is_array($this->available_slots)) {
            return $this->available_slots;
        }

        // Otherwise, return all possible slots
        return $this->getAllPossibleSlots();
    }

    /**
     * Get slots attribute for API/views
     */
    public function getSlotsAttribute(): array
    {
        return $this->getAvailableSlots();
    }

    /**
     * Count available slots
     */
    public function getSlotsCountAttribute(): int
    {
        return count($this->getAvailableSlots());
    }

    /**
     * Check if a specific slot is available
     */
    public function isSlotAvailable(string $time): bool
    {
        return in_array($time, $this->getAvailableSlots());
    }
}
