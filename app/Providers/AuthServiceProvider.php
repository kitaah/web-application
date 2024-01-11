<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Association;
use App\Models\Category;
use App\Models\Competition;
use App\Models\CreateCompetition;
use App\Models\Game;
use App\Models\Resource;
use App\Models\Statistic;
use App\Models\User;
use App\Policies\AssociationPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CompetitionPolicy;
use App\Policies\CreateCompetitionPolicy;
use App\Policies\GamePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ResourcePolicy;
use App\Policies\RolePolicy;
use App\Policies\StatisticPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Association::class => AssociationPolicy::class,
        Game::class => GamePolicy::class,
        Category::class => CategoryPolicy::class,
        Competition::class => CompetitionPolicy::class,
        CreateCompetition::class => CreateCompetitionPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        Resource::class => ResourcePolicy::class,
        Statistic::class => StatisticPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
