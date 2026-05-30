<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
     */
    public function boot(): void
    {
        URL::forceScheme('https');

        // Implicitly grant "Super Admin" and "superadmin" roles all permissions
        Gate::before(function ($user, $ability) {
            return $user->hasRole(['Super Admin', 'superadmin']) ? true : null;
        });
    }
}
