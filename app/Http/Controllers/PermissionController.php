<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Permissions;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use LogicException;

class PermissionController extends AController
{
    #[Get('/people-management/permissions', 'permissions')]
    public function default(): View
    {
        Gate::authorize(Permissions::VIEW_PERMISSION);
        Gate::authorize(Permissions::VIEW_ROLE);

        return view('people-management.permissions', [
            'roles' => Role::with('permissions')->orderBy('role_name')->get(),
            'permissions' => Permission::orderBy('perm_name')->get(),
        ]);
    }

    /**
     * @throws ValidationException
     */
    #[Post('/people-management/permission', 'create_permission')]
    public function createPermission(Request $request): RedirectResponse
    {
        Gate::authorize(Permissions::CREATE_PERMISSION);

        $data = $request->validate([
            'perm_name' => ['required', 'string', 'max:255', 'unique:permissions,perm_name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Permission::create($data);

        $this->flashSuccess('Permission created.');

        return back();
    }

    /**
     * @throws ValidationException
     */
    #[Post('/people-management/role-permission', 'assign_permission')]
    public function assignPermission(Request $request): RedirectResponse
    {
        Gate::authorize(Permissions::ASSIGN_PERMISSION);

        $data = $request->validate([
            'permission_id' => ['required', 'integer', 'exists:permissions,id'],
            'role_ids' => ['sometimes', 'array'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
        ]);

        $permission = Permission::with('roles')->findOrFail($data['permission_id']);

        $permission->roles()->sync($request->input('role_ids', []));

        $this->flashSuccess('Roles updated for permission: '.$permission->perm_name);

        return back();
    }

    /**
     * @throws ValidationException
     */
    #[Post('/people-management/update-permission/{permission}', 'update_permission')]
    public function updatePermission(Request $request, Permission $permission): RedirectResponse
    {
        Gate::authorize(Permissions::EDIT_PERMISSION);

        $data = $request->validate([
            'perm_name' => ['required', 'string', 'max:255',
                Rule::unique('permissions', 'perm_name')->ignore($permission->id),
            ],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $permission->update([
            'perm_name' => $data['perm_name'],
            'description' => $data['description'] ?? null,
        ]);

        $this->flashSuccess('Permission updated successfully.');

        return back();
    }

    /**
     * @throws ValidationException
     * @throws LogicException
     */
    #[Post('/people-management/delete-permission/{permission}', 'delete_permission')]
    public function deletePermission(Permission $permission): RedirectResponse
    {
        Gate::authorize(Permissions::DELETE_PERMISSION);

        $permission->roles()->detach();

        $permission->delete();

        $this->flashSuccess('Permission "'.$permission->perm_name.'" deleted successfully.');

        return back();
    }
}
