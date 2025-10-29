<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Router\Attributes\Get;
use Illuminate\Contracts\View\View;

final class DashboardController extends AController
{
    #[Get('/dashboard', 'dashboard')]
    public function default(): View
    {
        return view('dashboard');
    }
}
