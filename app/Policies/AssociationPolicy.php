<?php

namespace App\Policies;

use App\Models\{Association, User};

class AssociationPolicy
{
    /**
     * Define constants for allowed roles
     *
     */
    const string SUPER_ADMINISTRATOR = 'Super-Administrateur';
    const string ADMINISTRATOR = 'Administrateur';
    const string MODERATOR = 'Modérateur';

    /**
     * Check if the user has any of the specified roles.
     *
     * @param User $user
     * @param array $roles
     * @return bool
     */
    private function hasRole(User $user, array $roles): bool
    {
        return $user->hasRole($roles);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        $allowedRoles = [
            self::SUPER_ADMINISTRATOR,
            self::ADMINISTRATOR,
            self::MODERATOR,
        ];

        return $this->hasRole($user, $allowedRoles);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        $allowedRoles = [
            self::SUPER_ADMINISTRATOR,
            self::ADMINISTRATOR,
        ];

        return $this->hasRole($user, $allowedRoles);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Association $association
     * @return bool
     */
    public function update(User $user, Association $association): bool
    {
        $allowedRoles = [
            self::SUPER_ADMINISTRATOR,
            self::ADMINISTRATOR,
        ];

        return $this->hasRole($user, $allowedRoles);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Association $association
     * @return bool
     */
    public function delete(User $user, Association $association): bool
    {
        $allowedRoles = [
            self::SUPER_ADMINISTRATOR,
            self::ADMINISTRATOR,
        ];

        return $this->hasRole($user, $allowedRoles);
    }
}
