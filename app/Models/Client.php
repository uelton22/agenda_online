<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cpf',
        'email',
        'phone',
        'password',
        'notes',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Accessor for full_name (alias for name)
     */
    public function getFullNameAttribute(): string
    {
        return $this->name ?? '';
    }

    /**
     * Get avatar URL
     */
    public function getAvatarUrlAttribute(): string
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name ?? 'C') . '&color=FFFFFF&background=6366F1&bold=true&format=svg';
    }

    /**
     * Format CPF for display (XXX.XXX.XXX-XX)
     */
    public function getFormattedCpfAttribute(): string
    {
        $cpf = preg_replace('/\D/', '', $this->cpf);
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }

    /**
     * Format phone for display
     */
    public function getFormattedPhoneAttribute(): ?string
    {
        if (!$this->phone) {
            return null;
        }
        
        $phone = preg_replace('/\D/', '', $this->phone);
        
        if (strlen($phone) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $phone);
        } elseif (strlen($phone) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $phone);
        }
        
        return $this->phone;
    }

    /**
     * Set CPF attribute (remove formatting)
     */
    public function setCpfAttribute($value): void
    {
        $this->attributes['cpf'] = preg_replace('/\D/', '', $value);
    }

    /**
     * Get appointments for this client.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get initials for avatar
     */
    public function getInitialsAttribute(): string
    {
        $names = explode(' ', $this->name ?? '');
        $initials = '';
        
        foreach (array_slice($names, 0, 2) as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }
        
        return $initials;
    }

    /**
     * Scope a query to search clients.
     */
    public function scopeSearch($query, ?string $search)
    {
        if (!$search) {
            return $query;
        }

        $searchClean = preg_replace('/\D/', '', $search);

        return $query->where(function ($q) use ($search, $searchClean) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('cpf', 'like', "%{$searchClean}%");
        });
    }

    /**
     * Scope a query to filter by CPF.
     */
    public function scopeByCpf($query, string $cpf)
    {
        $cpfClean = preg_replace('/\D/', '', $cpf);
        return $query->where('cpf', $cpfClean);
    }

    /**
     * Scope for active clients
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
