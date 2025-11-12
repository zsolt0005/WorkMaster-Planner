<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

final class EditProfileController extends AController
{
    #[Get('/edit-profile', 'edit_profile')]
    public function default(): View
    {
        $user = auth()->user();

        return view('edit-profile', ['user' => $user]);
    }

    /**
     * @throws ValidationException
     */
    #[Post('/edit-profile', 'edit_profile')]
    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $FullNameMaxLength = 3;

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore(auth()->id()),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(auth()->id()),
            ],
            'full_name' => ['required', 'string', 'min:'.$FullNameMaxLength],
            'current_password' => ['nullable', 'string'],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).+$/',
            ],
        ]);

        if (! empty($validated['password'])) {
            if (empty($validated['current_password']) || ! Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Staré heslo je nesprávne.'])->withInput();
            }

            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect('profile')->with('success', 'Profil bol aktualizovaný.');
    }
}
