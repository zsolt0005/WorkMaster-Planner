<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Permissions;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

final class GenerateAttendanceController extends AController
{
    #[Get('/calendar-settings/generate-attendance', 'generate_attendance')]
    public function show(): View
    {
        Gate::authorize(Permissions::EDIT_CALENDAR_SETTINGS);
        $users = User::all();

        return view('calendar-settings.generate_attendance', ['users' => $users]);
    }

    /**
     */
    #[Post('/calendar-settings/generate-attendance/run', 'generate_attendance__run')]
    public function run(Request $request): RedirectResponse
    {
        Gate::authorize(Permissions::EDIT_CALENDAR_SETTINGS);

        // tu vlož logiku generovania dochádzky
        // napr. vytvorenie Eventov alebo export CSV

        $this->flashSuccess(__('Attendance successfully generated.'));
        return redirect()->route('generate_attendance');
    }
}
