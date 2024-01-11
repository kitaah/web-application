<?php

namespace App\Policies;

use App\Models\CreateCompetition;
use App\Models\User;

class CreateCompetitionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Super-Administrateur', 'Administrateur', 'Modérateur']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['Super-Administrateur', 'Administrateur']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CreateCompetition $createCompetition): bool
    {
        return $user->hasRole(['Super-Administrateur', 'Administrateur']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CreateCompetition $createCompetition): bool
    {
        return $user->hasRole(['Super-Administrateur', 'Administrateur']);
    }
}
