<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Router\Attributes\Get;
use Illuminate\Contracts\View\View;

final class PeopleManagementController extends AController
{
    #[Get('/people-management', 'people_management')]
    public function default(): View
    {
        return view('people_management');
    }
}
