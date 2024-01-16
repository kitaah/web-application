<?php

namespace App\Policies;

use App\Models\{Statistic, User};

class StatisticPolicy
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
        return true; // Allow all users to view
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true; // Allow all users to create
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Statistic $statistic
     * @return bool
     */
    public function update(User $user, Statistic $statistic): bool
    {
        return $this->hasRole($user, [self::SUPER_ADMINISTRATOR, self::MODERATOR]);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Statistic $statistic
     * @return bool
     */
    public function delete(User $user, Statistic $statistic): bool
    {
        return $this->hasRole($user, [self::SUPER_ADMINISTRATOR]);
    }

    /**
     * Determine whether the user can export.
     *
     * @param User $user
     * @param Statistic $statistic
     * @return bool
     */
    public function export(User $user, Statistic $statistic): bool
    {
        return true; // Allow all users to export
    }
}
