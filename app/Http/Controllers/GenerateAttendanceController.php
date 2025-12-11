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
use Illuminate\Support\Facades\Log;

final class GenerateAttendanceController extends AController
{
    #[Get('/calendar-settings/generate-attendance', 'generate_attendance')]
    public function show(): View
    {
        Gate::authorize(Permissions::EDIT_CALENDAR_SETTINGS);

        $users = User::all();

        return view('calendar-settings.generate_attendance', ['users' => $users]);
    }

    #[Post('/calendar-settings/generate-attendance/run', 'generate_attendance__run')]
    public function run(Request $request): RedirectResponse
    {
        Gate::authorize(Permissions::EDIT_CALENDAR_SETTINGS);

        $calculationMode = $request->input('calculation_mode');
        $currentPeriod   = (int) $request->input('current_period');
        $shift           = (int) $request->input('shift');
        $workSaturday    = $request->boolean('work_saturday');
        $workSunday      = $request->boolean('work_sunday');
        $firstUser       = $request->input('first_user');
        $selectedUsers   = json_decode($request->input('selected_users', '[]'), true);

        if (count($selectedUsers) < 3) {
            $this->flashError(__('You must select at least 3 users.'));
            return redirect()->route('generate_attendance');
        }

        $schedule = [];

        if ($firstUser === 'random') {
            $currentIndex = array_rand($selectedUsers);
        } else {
            $currentIndex = array_search($firstUser, $selectedUsers);
            if ($currentIndex === false) {
                $currentIndex = 0;
            }
        }

        $startHour = 6;
        $daysCount = ($calculationMode === 'week') ? 7 : 30;

        for ($day = 1; $day <= $daysCount; $day++) {
            $dayOfWeek = $day % 7;
            if (!$workSaturday && $dayOfWeek === 6) {
                continue;
            }
            if (!$workSunday && $dayOfWeek === 0) {
                continue;
            }

            if ($shift === 8) {
                $time = $startHour;
                while ($time < 24) {
                    $user = $selectedUsers[$currentIndex];
                    $schedule[] = [
                        'day' => $day,
                        'start' => sprintf('%02d:00', $time),
                        'end' => sprintf('%02d:00', ($time + 8) % 24),
                        'user' => $user,
                    ];
                    $currentIndex = ($currentIndex + 1) % count($selectedUsers);
                    $time += 8;
                }
            } elseif ($shift === 12) {
                $user1 = $selectedUsers[$currentIndex];
                $schedule[] = [
                    'day' => $day,
                    'start' => '06:00',
                    'end' => '18:00',
                    'user' => $user1,
                ];
                $currentIndex = ($currentIndex + 1) % count($selectedUsers);

                $user2 = $selectedUsers[$currentIndex];
                $schedule[] = [
                    'day' => $day,
                    'start' => '18:00',
                    'end' => '06:00',
                    'user' => $user2,
                ];
                $currentIndex = ($currentIndex + 1) % count($selectedUsers);
            }
        }

        print_r($schedule);
        exit;

        $this->flashSuccess(__('Attendance successfully generated.'));
        return redirect()->route('generate_attendance');
    }
}
