<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Post;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

final class ProfileController extends AController
{
    #[Get('/profile', 'profile')]
    public function default(): View
    {
        $user = $this->getAuthUser();

        return view('profile', ['user' => $user]);
    }

    /**
     * @throws ValidationException
     */
    #[Post('/profile/edit/{user}', 'profile__edit')]
    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->id !== $this->getAuthUser()->id) {
            $this->flashError(__('profile.errors.not_your_profile'));
            return back();
        }

        $data = $request->all();
        $isUpdated = false;

        // Handle password change
        $oldPassword = $request->input('current_password', null);
        if ($oldPassword !== null) {
            if (!$user->comparePassword($oldPassword)) {
                $this->flashError(__('profile.errors.current_password'));
                return back();
            }

            $newPassword = $request->input('password');
            $newPasswordConfirmation = $request->input('password_confirmation');
            if ($newPassword !== $newPasswordConfirmation) {
                $this->flashError(__('profile.errors.password_confirmation'));
                return back();
            }

            $validator = Validator::make($data, [
                'password' => [
                    'required',
                    'string',
                    'min:5',
                    'confirmed',
                ]
            ]);

            if ($validator->fails()) {
                $message = $validator->errors()->first('password') ?: $validator->errors()->first();

                $this->flashError($message);

                return back();
            }

            $user->password = Hash::make($newPassword);
            $isUpdated = true;
        }

        if (Gate::allows('edit_profile_data', $user)) {
            unset($data['password'], $data['current_password'], $data['password_confirmation']);

            $validator = Validator::make($data, [
                'username' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users', 'username')->ignore($user->id),
                ],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($user->id),
                ],
                'full_name' => ['required', 'string', 'min:3'],
            ]);

            if ($validator->fails()) {
                $this->flashError($validator->errors()->first());

                return back();
            }

            $user->fill($data);
            $isUpdated = true;
        }

        try {
            if ($isUpdated) {
                $user->save();
            }

            $this->flashSuccess(__('profile.success.updated'));
        } catch (Exception $e) {
            $this->flashError(__('profile.errors.update_failed'));
        }

        return back();
    }
}
