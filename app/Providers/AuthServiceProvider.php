<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\{Association, Category, Competition, CreateCompetition, Game, Resource, Statistic, User};
use App\Policies\{AssociationPolicy,
    CategoryPolicy,
    CompetitionPolicy,
    CreateCompetitionPolicy,
    GamePolicy,
    PermissionPolicy,
    ResourcePolicy,
    RolePolicy,
    StatisticPolicy,
    UserPolicy};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\{Permission\Models\Permission, Permission\Models\Role};

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
