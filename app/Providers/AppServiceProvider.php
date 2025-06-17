<?php

namespace App\Providers;

use App\Services\CustomHashManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
        Connection::resolverFor('pgsql', function ($connection, $database, $prefix, $config) {
            return new \App\Support\PostgresConnection($connection, $database, $prefix, $config);
        });

        // permite configurar y redirigir todo el trafico a https
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
