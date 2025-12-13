<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Permissions;
use App\Services\Router\Attributes\Get;
use App\Services\Router\Attributes\Post;
use DateTimeImmutable;
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

    #[Post('/calendar-settings/generate-attendance/run', 'generate_attendance__run')]
    public function run(Request $request): RedirectResponse
    {
        Gate::authorize(Permissions::EDIT_CALENDAR_SETTINGS);

        $weekOrMonth = $request->input('calculation_mode');
        $currentPeriod = (int)$request->input('current_period');
        $howManyPeopleOnOneShift = (int)$request->input('how_many_people_on_one_shift');
        $shiftTimeHours = (int)$request->input('shift');
        $workSaturday = $request->boolean('work_saturday');
        $workSunday = $request->boolean('work_sunday');
        $firstShiftUser = $request->input('first_user');
        $selectedUsers = json_decode($request->input('selected_users', '[]'), true);

        $users = User::all();

        if (count($selectedUsers) < 3) {
            $this->flashError(__('calendar_settings.generate_attendance.warning'));
            return redirect()->route('generate_attendance');
        }

        $schedule = [];

        if ($firstShiftUser === 'random') {
            $currentIndex = array_rand($selectedUsers);
        } else {
            $currentIndex = array_search($firstShiftUser, $selectedUsers);
            if ($currentIndex === false) {
                $currentIndex = 0;
            }
        }

        $startHour = 6;
        $year = (int)date('Y');
        $month = 1;

        $daysCount = 7;
        if ($weekOrMonth !== 'week') {
            $periodDate = new DateTimeImmutable("$year-$currentPeriod-01");
            $daysCount = (int)$periodDate->format('t');
        } else {
            $month = new DateTimeImmutable()->setISODate($year, $currentPeriod);
        }

        for ($day = 1; $day <= $daysCount; $day++) {
            if ($weekOrMonth !== 'week') {
                $date = new DateTimeImmutable("$year-$currentPeriod-$day");
            } else {
                $date = new DateTimeImmutable("$year-$month-$day");
            }
            $dayOfWeek = (int) $date->format('w'); // 0 = Sunday, 6 = Saturday

            if (! $workSaturday && $dayOfWeek === 6) {
                continue;
            }
            if (! $workSunday && $dayOfWeek === 0) {
                continue;
            }

            $time = $startHour;
            while ($time < 24) {
                $startDateTime = $date->format('Y-m-d').' '.sprintf('%02d:00:00', $time);
                $endHour = ($time + $shiftTimeHours) % 24;

                if ($endHour === 6) {
                    $endDate = $date->modify('+1 day')->format('Y-m-d');
                } else {
                    $endDate = $date->format('Y-m-d');
                }
                $endDateTime = $endDate.' '.sprintf('%02d:00:00', $endHour);

                for ($j = 0; $j < $howManyPeopleOnOneShift; $j++) {
                    $userId = $selectedUsers[$currentIndex];
                    $user   = $users->find($userId);

                    $schedule[] = [
                        'event_type_id'      => 'worktime',
                        'assigned_user_id'   => $userId,
                        'created_by_user_id' => $this->getAuthUser()->id,
                        'title'              => $user->full_name,
                        'start_date_time'    => $startDateTime,
                        'end_date_time'      => $endDateTime,
                    ];

                    $currentIndex = ($currentIndex + 1) % count($selectedUsers);
                }
                $time += $shiftTimeHours;
            }
        }

        Event::insert($schedule);

        $this->flashSuccess(__('Attendance successfully generated.'));
        return redirect()->route('generate_attendance');
    }
}
