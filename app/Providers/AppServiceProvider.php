<?php declare(strict_types=1);

namespace App\Providers;

use App\Models\Permission;
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
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            Gate::define($permission->perm_name, static function (User $user) use ($permission) {
                if ($user->is_admin) {
                    return Response::allow();
                }

                return $user->hasPermission($permission->perm_name)
                    ? Response::allow()
                    : Response::deny('You do not have permission for this action.');
            });
        }
    }
}
