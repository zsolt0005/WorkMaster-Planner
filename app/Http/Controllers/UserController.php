<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Permissions;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use LogicException;

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
        Gate::authorize(Permissions::ASSIGN_ROLE);

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

    /**
     * @throws ValidationException
     */
    #[Post('/people-management/users', 'create_user')]
    public function createUser(Request $request): RedirectResponse
    {
        Gate::authorize(Permissions::CREATE_USER);

        $data = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,'.User::EMAIL, 'max:255'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        User::create([
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $this->flashSuccess('User created.');

        return back();
    }

    /**
     * @throws ValidationException
     */
    #[Post('/people-management/users/{user}', 'update_user')]
    public function updateUser(Request $request, User $user): RedirectResponse
    {
        Gate::authorize(Permissions::EDIT_USER);

        $data = $request->validate([
            'username' => ['required', 'string', 'max:50', "unique:users,username,{$user->id}"],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,'.User::EMAIL.','.$user->id, 'max:255'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $updateData = [
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
        ];

        if (! empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $full_name = $user->full_name;
        $user->update($updateData);

        $this->flashSuccess('User '.$full_name.' updated successfully.');

        return back();
    }

    /**
     * @throws ValidationException
     * @throws LogicException
     */
    #[Post('/people-management/users/delete/{user}', 'delete_user')]
    public function deleteUser(User $user): RedirectResponse
    {
        Gate::authorize(Permissions::DELETE_USER);

        $full_name = $user->full_name;
        $user->delete();

        $this->flashSuccess('User '.$full_name.' successfully deleted.');

        return back();
    }
}
