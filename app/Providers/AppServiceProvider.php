<?php declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
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
        Gate::define('create.role', function (User $user) {
            return $user->hasPermission('create_role')
                ? Response::allow()
                : Response::deny('You cannot create role.');
        });

        Gate::define('admin-only', function ($user) {
            return $user->is_admin;
        });
    }
}
