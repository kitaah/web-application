<?php

namespace App\Providers;

use Illuminate\{Support\Facades\Broadcast, Support\ServiceProvider};

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot(): void
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
