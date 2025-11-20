<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Permissions;
use App\Services\Router\Attributes\Get;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;

final class CalendarSettingsController extends AController
{
    #[Get('/calendar-settings', 'calendar_settings')]
    public function default(): View
    {
        Gate::authorize(Permissions::EDIT_CALENDAR_SETTINGS);

        return view('calendar-settings.event_types');
    }
}
