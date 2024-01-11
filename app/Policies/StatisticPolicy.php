<?php

namespace App\Policies;

use App\Models\Statistic;
use App\Models\User;

class StatisticPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Statistic $statistic): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Statistic $statistic): bool
    {
        return true;
    }

    /**
     * Determine whether the user can export.
     */
    public function export(User $user, Statistic $statistic): bool
    {
        return true;
    }
}
