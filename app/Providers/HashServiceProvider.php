<?php

namespace App\Providers;

use App\Services\CustomHashManager;
use Illuminate\Support\ServiceProvider;

class HashServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Sobrescribimos el singleton 'hash' con tu CustomHashManager
        $this->app->singleton('hash', function ($app) {
            return new CustomHashManager($app);
        });
    }
}
