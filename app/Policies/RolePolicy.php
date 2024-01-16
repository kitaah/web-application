<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * The role of a super administrator.
     *
     * @var string
     */
    const SUPER_ADMINISTRATOR = 'Super-Administrateur';

    /**
     * Check if the user has the specified role.
     *
     * @param User $user
     * @return bool
     */
    private function hasRole(User $user): bool
    {
        return $user->hasRole([self::SUPER_ADMINISTRATOR]);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $this->hasRole($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $this->hasRole($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Role $role
     * @return bool
     */
    public function update(User $user, Role $role): bool
    {
        return $this->hasRole($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Role $role
     * @return bool
     */
    public function delete(User $user, Role $role): bool
    {
        return $this->hasRole($user);
    }
}
