<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Router\Attributes\Get;
use Illuminate\Contracts\View\View;

final class CalendarController extends AController
{
    #[Get('/', 'calendar')]
    public function default(): View
    {
        return view('calendar');
    }
}
