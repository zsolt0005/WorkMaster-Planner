<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Middleware;
use App\Services\Router\Attributes\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final class LoginController extends AController
{
    #[Get('/login', 'login')]
    #[Middleware('guest')]
    public function default(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }

        return view('login');
    }

    /**
     * @throws ValidationException
     */
    #[Post('/login', 'login')]
    #[Middleware('guest')]
    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);

        $emailLogin = [User::EMAIL => $validated['login'], User::PASSWORD => $validated['password']];
        $usernameLogin = [User::USERNAME => $validated['login'], User::PASSWORD => $validated['password']];

        if (Auth::attempt($emailLogin) || Auth::attempt($usernameLogin)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'login' => __('login.errors.invalid_credentials'),
        ]);
    }

    #[Get('/logout', 'logout')]
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
