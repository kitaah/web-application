<?php

namespace App\Providers\Filament;

use App\{Filament\Pages\Auth\Login, Filament\Pages\Dashboard};
use Filament\{Http\Middleware\Authenticate,
    Http\Middleware\DisableBladeIconComponents,
    Http\Middleware\DispatchServingFilamentEvent,
    Pages\Auth\EmailVerification\EmailVerificationPrompt,
    Panel,
    PanelProvider,
    Support\Colors\Color,
    Widgets\AccountWidget};
use Illuminate\{Auth\Middleware\EnsureEmailIsVerified,
    Cookie\Middleware\AddQueuedCookiesToResponse,
    Cookie\Middleware\EncryptCookies,
    Foundation\Http\Middleware\VerifyCsrfToken,
    Routing\Middleware\SubstituteBindings,
    Session\Middleware\AuthenticateSession,
    Session\Middleware\StartSession,
    View\Middleware\ShareErrorsFromSession};
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;

class AdminPanelProvider extends PanelProvider
{
    /**
     * Admin panel configuration.
     *
     * @param Panel $panel
     * @return Panel
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->darkMode(false)
            ->spa()
            ->brandName('Espace administrateur')
            ->loginRouteSlug('connexion')
            ->emailVerification(EmailVerificationPrompt::class)
            ->plugins([
                FilamentApexChartsPlugin::make()
            ])
            ->colors(
                [
                    'danger' => Color::Red,
                    'gray' => Color::Gray,
                    'info' => Color::Blue,
                    'primary' => Color::Blue,
                    'success' => Color::Emerald,
                    'warning' => Color::Orange,
                ]
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages(
                [
                    Dashboard::class,
                ]
            )
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets(
                [
                    AccountWidget::class,
                ]
            )
            ->middleware(
                [
                    EncryptCookies::class,
                    AddQueuedCookiesToResponse::class,
                    StartSession::class,
                    AuthenticateSession::class,
                    ShareErrorsFromSession::class,
                    VerifyCsrfToken::class,
                    SubstituteBindings::class,
                    DisableBladeIconComponents::class,
                    DispatchServingFilamentEvent::class,
                ]
            )
            ->authMiddleware(
                [
                    Authenticate::class,
                ]
            );
    }
}
