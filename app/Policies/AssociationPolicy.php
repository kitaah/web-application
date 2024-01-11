<?php

namespace App\Policies;

use App\Models\Association;
use App\Models\User;

class AssociationPolicy
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
    public function update(User $user, Association $association): bool
    {
        return $user->hasRole(['Super-Administrateur', 'Administrateur']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Association $association): bool
    {
        return $user->hasRole(['Super-Administrateur', 'Administrateur']);
    }
}
