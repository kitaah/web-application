<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
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
     * The role of a moderator.
     *
     * @var string
     */
    const MODERATOR = 'Modérateur';

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
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function view(User $user, User $model): bool
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
        return $this->hasRole($user, [self::SUPER_ADMINISTRATOR]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        $allowedRoles = [
            self::SUPER_ADMINISTRATOR,
            self::MODERATOR,
        ];

        return $this->hasRole($user, $allowedRoles);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        return $this->hasRole($user, [self::SUPER_ADMINISTRATOR]);
    }
}
