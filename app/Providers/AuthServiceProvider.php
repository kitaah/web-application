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
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
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
        VerifyEmail::toMailUsing(callback: static function (object $notifiable, string $url) {
            return (new MailMessage)
                ->from('contact@re-r.fr', 'L\'équipe de (RE)SOURCES RELATIONNELLES')
                ->greeting('Bonjour ' . $notifiable->name . ' !')
                ->subject('Activation du compte')
                ->line('Veuillez cliquer sur le bouton ci-dessous pour activer votre compte.')
                ->action('Activation du compte', $url)
                ->line(Lang::get('Ce lien expira dans :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                ->line("Ceci est un message automatique, aucune réponse de votre part n'est requise.")
                ->salutation('L\'équipe de (RE)SOURCES RELATIONNELLES');
        });

    }
}
