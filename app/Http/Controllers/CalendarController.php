<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

final class CalendarController extends AController
{
    public function default(): View
    {
        return view('calendar');
    }
}
