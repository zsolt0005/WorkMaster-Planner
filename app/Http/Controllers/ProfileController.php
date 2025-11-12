<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Router\Attributes\Get;
use Illuminate\Contracts\View\View;

final class ProfileController extends AController
{
    #[Get('/profile', 'profile')]
    public function default(): View
    {
        $user = auth()->user();

        return view('profile', ['user' => $user]);
    }
}
