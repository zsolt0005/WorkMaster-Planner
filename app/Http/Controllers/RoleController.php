<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use LogicException;

class RoleController extends AController
{
    #[Get('/people-management/roles', 'roles')]
    public function default(): View
    {
        return view('people-management.roles', [
            'roles' => Role::with('permissions')->orderBy('role_name')->get(),
        ]);
    }

    /**
     * @throws ValidationException
     */
    #[Post('/people-management/create-role', 'create_role')]
    public function createRole(Request $request): RedirectResponse
    {
        Gate::authorize('create_role');

        Log::info('POST create role');
        $data = $request->validate([
            'role_name' => ['required', 'string', 'max:255', 'unique:roles,role_name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Role::create($data);

        $this->flashSuccess('Role created.');

        return back();
    }

    /**
     * @throws ValidationException
     */
    #[Post('/people-management/update-role/{role}', 'update_role')]
    public function updateRole(Request $request, Role $role): RedirectResponse
    {
        $data = $request->validate([
            'role_name' => ['required', 'string', 'max:255', "unique:roles,role_name,{$role->id}"],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $role->update([
            'role_name' => $data['role_name'],
            'description' => $data['description'] ?? null,
        ]);

        $this->flashSuccess('Role updated successfully.');

        return back();
    }

    /**
     * @throws ValidationException
     * @throws LogicException
     */
    #[Post('/people-management/delete-role/{role}', 'delete_role')]
    public function deleteRole(Request $request, Role $role): RedirectResponse
    {
        $role->users()->detach();
        $role->permissions()->detach();

        $role->delete();

        $this->flashSuccess('Role deleted successfully.');

        return back();
    }
}
