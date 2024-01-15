<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->setApplicationLocale();
    }

    /**
     * Set the application locale.
     *
     * @return void
     */
    private function setApplicationLocale(): void
    {
        /** @var $defaultLocale */
        $defaultLocale = 'fr';
        app()->setLocale($defaultLocale);
    }
}
