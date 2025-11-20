<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends AController
{
    #[Get('/people-management/users', 'users')]
    public function default(): View
    {
        return view('people-management.users', [
            'roles' => Role::with('permissions')->orderBy('role_name')->get(),
            'users' => User::with('roles')->orderBy('email')->get(),
        ]);
    }

    /**
     * @throws ValidationException
     */
    #[Post('/people-management/user-role', 'assign_roles')]
    public function assignRoles(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'role_ids' => ['sometimes', 'array'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
        ]);

        $user = User::with('roles')->findOrFail($data['user_id']);

        $ids = $request->input('role_ids', []);

        $user->roles()->sync($ids);

        $this->flashSuccess('Roles updated for user: '.$user->email);

        return back();
    }
}
