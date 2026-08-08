<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
     */
    public function boot(): void
    {
        // The super-admin role keeps working when new permissions are added,
        // so nobody has to remember to re-grant it after a release.
        Gate::before(fn (User $user) => $user->isSuperAdmin() ?: null);
    }
}
