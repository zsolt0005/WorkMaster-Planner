<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Router\Attributes\Get;
use Illuminate\Http\RedirectResponse;

final class PeopleManagementController extends AController
{
    #[Get('/people-management', 'people_management')]
    public function default(): RedirectResponse
    {
        return redirect()->route('users');
    }
}
