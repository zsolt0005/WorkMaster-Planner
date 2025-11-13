<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\AdminOnly;
use App\Models\Role;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Middleware;
use Illuminate\Contracts\View\View;

final class PeopleManagementController extends AController
{
    #[Get('/people-management', 'people_management')]
    #[Middleware(AdminOnly::class)]
    public function default(): View
    {
        return view('people-management.roles', [
            'roles' => Role::with('permissions')->orderBy('role_name')->get(),
        ]);
    }
}
