<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    /**
     * Determine if the user can view any appointments.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the appointment.
     */
    public function view(User $user, Appointment $appointment): bool
    {
        // Admin can view all appointments
        if ($user->hasRole('admin')) {
            return true;
        }

        // User can only view their own appointments
        return $user->id === $appointment->user_id;
    }

    /**
     * Determine if the user can create appointments.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the appointment.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        // Admin can update all appointments
        if ($user->hasRole('admin')) {
            return true;
        }

        // User can only update their own appointments
        return $user->id === $appointment->user_id;
    }

    /**
     * Determine if the user can delete the appointment.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        // Admin can delete all appointments
        if ($user->hasRole('admin')) {
            return true;
        }

        // User can only delete their own appointments
        return $user->id === $appointment->user_id;
    }
}

