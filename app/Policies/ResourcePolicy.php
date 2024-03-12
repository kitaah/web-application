<?php

namespace App\Policies;

use App\{Models\Resource, Models\User};

class ResourcePolicy
{
    /**
     * The role of a super administrator.
     *
     * @var string
     */
    const SUPER_ADMINISTRATOR = 'Super-Administrateur';

    /**
     * The role of an administrator.
     *
     * @var string
     */
    const ADMINISTRATOR = 'Administrateur';

    /**
     * Check if the user has any of the specified roles.
     *
     * @param User $user
     * @param array $roles
     * @return bool
     */
    public function hasRole(User $user, array $roles): bool
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
     * @param Resource $resource
     * @return bool
     */
    public function update(User $user, Resource $resource): bool
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
     * @param Resource $resource
     * @return bool
     */
    public function delete(User $user, Resource $resource): bool
    {
        $allowedRoles = [
            self::SUPER_ADMINISTRATOR,
            self::ADMINISTRATOR,
        ];

        return $this->hasRole($user, $allowedRoles);
    }
}
