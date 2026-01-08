<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Professional extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'specialty',
        'bio',
        'color',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the services associated with the professional.
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'professional_service')
            ->withPivot(['price', 'duration', 'available_slots', 'is_active'])
            ->withTimestamps();
    }

    /**
     * Get the active services associated with the professional.
     */
    public function activeServices(): BelongsToMany
    {
        return $this->services()->wherePivot('is_active', true);
    }

    /**
     * Get the appointments for the professional.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get avatar URL attribute.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=fff&size=128';
    }

    /**
     * Get the initials for the professional's name.
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= mb_strtoupper(mb_substr($word, 0, 1));
        }
        
        return $initials;
    }

    /**
     * Scope to get only active professionals.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the price for a specific service.
     */
    public function getPriceForService(Service $service): float
    {
        $pivot = $this->services()->where('service_id', $service->id)->first()?->pivot;
        
        return $pivot?->price ?? $service->price;
    }

    /**
     * Get the duration for a specific service.
     */
    public function getDurationForService(Service $service): int
    {
        $pivot = $this->services()->where('service_id', $service->id)->first()?->pivot;
        
        return $pivot?->duration ?? $service->duration;
    }

    /**
     * Get the available slots for a specific service.
     */
    public function getAvailableSlotsForService(Service $service): ?array
    {
        $pivot = $this->services()->where('service_id', $service->id)->first()?->pivot;
        
        if ($pivot?->available_slots) {
            return is_string($pivot->available_slots) 
                ? json_decode($pivot->available_slots, true) 
                : $pivot->available_slots;
        }
        
        return $service->available_slots;
    }

    /**
     * Check if professional is available at a specific date and time.
     */
    public function isAvailableAt(string $date, string $time, ?int $excludeAppointmentId = null): bool
    {
        $query = $this->appointments()
            ->where('scheduled_date', $date)
            ->where('scheduled_time', '<=', $time)
            ->where('end_time', '>', $time)
            ->whereNotIn('status', [Appointment::STATUS_CANCELLED]);

        if ($excludeAppointmentId) {
            $query->where('id', '!=', $excludeAppointmentId);
        }

        return $query->count() === 0;
    }

    /**
     * Get available time slots for a specific date and service.
     */
    public function getAvailableTimeSlotsForDate(string $date, Service $service): array
    {
        $dayOfWeek = strtolower(date('l', strtotime($date)));
        $availableSlots = $this->getAvailableSlotsForService($service);

        if (!$availableSlots || !isset($availableSlots[$dayOfWeek]) || empty($availableSlots[$dayOfWeek])) {
            return [];
        }

        $daySlots = $availableSlots[$dayOfWeek];
        $duration = $this->getDurationForService($service);
        $availableTimeSlots = [];

        // Get all appointments for this professional on this date
        $appointments = $this->appointments()
            ->where('scheduled_date', $date)
            ->whereNotIn('status', [Appointment::STATUS_CANCELLED])
            ->get(['scheduled_time', 'end_time']);

        foreach ($daySlots as $slot) {
            $time = $slot;
            $endTime = date('H:i', strtotime($time) + ($duration * 60));

            // Check if this slot conflicts with any existing appointment
            $isAvailable = true;
            foreach ($appointments as $appointment) {
                $appointmentStart = $appointment->scheduled_time;
                $appointmentEnd = $appointment->end_time;

                // Check for overlap
                if ($time < $appointmentEnd && $endTime > $appointmentStart) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable) {
                $availableTimeSlots[] = $time;
            }
        }

        return $availableTimeSlots;
    }

    /**
     * Get today's appointments count.
     */
    public function getTodayAppointmentsCountAttribute(): int
    {
        return $this->appointments()
            ->whereDate('scheduled_date', today())
            ->whereNotIn('status', [Appointment::STATUS_CANCELLED])
            ->count();
    }

    /**
     * Get total appointments count.
     */
    public function getTotalAppointmentsCountAttribute(): int
    {
        return $this->appointments()
            ->whereNotIn('status', [Appointment::STATUS_CANCELLED])
            ->count();
    }
}

