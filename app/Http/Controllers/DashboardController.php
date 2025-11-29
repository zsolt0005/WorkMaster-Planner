<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Models\Role;
use App\Models\User;
use App\Permissions;
use App\Services\Router\Attributes\Get;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

final class DashboardController extends AController
{
    #[Get('/dashboard', 'dashboard')]
    public function default(): View
    {
        $user = $this->getAuthUser();
        $userId = request()->query('user_id');
        $selectedUser = $userId ? User::find($userId) : $user;
        if ($userId && ! $selectedUser) {
            abort(404, 'User not found');
        }
        $selectedUserId = $selectedUser->id;

        if ($userId && ! ($selectedUser = User::find($userId))) {
            abort(404, 'User not found');
        }
        if ($selectedUser->id !== $user->id) {
            Gate::authorize(Permissions::VIEW_USERS_DASHBOARD);
        }

        $allUsers = User::orderBy('full_name')->get();

        $totalUsers = User::count();

        $usersThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();

        $usersLastWeek = User::selectRaw('DATE(created_at) AS day, COUNT(*) AS count')
            ->where('created_at', '>=', now()->subWeek())
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $usersLastYear = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS month, COUNT(*) AS count')
            ->where('created_at', '>=', now()->subYear())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $holidayEvents = Event::whereHas('type', fn ($q) => $q->where('identifier', 'holiday'))
            ->where('start_date_time', '>=', now())
            ->orderBy('start_date_time')
            ->limit(3)
            ->get(['title', 'start_date_time', 'end_date_time', 'event_type_id']);

        $roles = Role::withCount('users')->orderBy('role_name')->get();
        $usersByRoles = $roles->map(fn (Role $role) => [
            'role' => $role->role_name,
            'count' => (int) $role->users_count,
        ])->all();

        $totalEvents = Event::count();

        $eventsMonthly = Event::selectRaw('DATE(start_date_time) AS day, COUNT(*) AS count')
            ->where('start_date_time', '>=', now()->subMonth())
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $eventsLastWeek = Event::selectRaw('DATE(start_date_time) AS day, COUNT(*) AS count')
            ->where('start_date_time', '>=', now()->subWeek())
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $eventsByTypeRaw = DB::table('events')
            ->select('event_type_id', DB::raw('COUNT(*) as total_count'))
            ->groupBy('event_type_id')
            ->get();

        $eventsByType = $eventsByTypeRaw->map(fn ($row) => [
            'type' => ($type = EventType::find($row->event_type_id)) ? $type->description : (string) $row->event_type_id,
            'count' => (int) $row->total_count,
        ])->all();

        $lastAddedUser = User::orderBy('created_at', 'desc')
            ->first(['id', 'username', 'full_name', 'created_at']);

        $userCreatedAt = $user->created_at;
        $daysSinceRegistration = (int) $userCreatedAt->diffInDays(Carbon::now());
        $userTotalEvents = Event::where('assigned_user_id', $selectedUser->id)->count();

        $userUpcomingEvents = Event::where('assigned_user_id', $selectedUser->id)
            ->where('start_date_time', '>=', now())
            ->orderBy('start_date_time')
            ->limit(3)
            ->get();

        $userEventsByTypeRaw = DB::table('events')
            ->select('event_type_id', DB::raw('COUNT(*) as total_count'))
            ->where('assigned_user_id', $selectedUser->id)
            ->groupBy('event_type_id')
            ->get();

        $userEventsByType = $userEventsByTypeRaw->map(fn ($row) => [
            'type' => ($type = EventType::find($row->event_type_id)) ? $type->description : (string) $row->event_type_id,
            'count' => (int) $row->total_count,
        ])->all();

        $userEventsLastMonth = Event::selectRaw('DATE(start_date_time) AS day, COUNT(*) AS count')
            ->where('assigned_user_id', $selectedUser->id)
            ->where('start_date_time', '>=', now()->subMonth())
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $userEventsLastWeek = Event::selectRaw('DATE(start_date_time) AS day, COUNT(*) AS count')
            ->where('assigned_user_id', $selectedUser->id)
            ->where('start_date_time', '>=', now()->subWeek())
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('dashboard', [
            'allUsers' => $allUsers,
            'selectedUser' => $selectedUser,
            'selectedUserId' => $selectedUserId,
            'totalUsers' => $totalUsers,
            'usersThisMonth' => $usersThisMonth,
            'usersLastWeek' => $usersLastWeek,
            'usersLastYear' => $usersLastYear,
            'usersByRoles' => $usersByRoles,
            'lastAddedUser' => $lastAddedUser,
            'totalEvents' => $totalEvents,
            'eventsMonthly' => $eventsMonthly,
            'eventsLastWeek' => $eventsLastWeek,
            'eventsByType' => $eventsByType,
            'holidayEvents' => $holidayEvents,
            'daysSinceRegistration' => $daysSinceRegistration,
            'userTotalEvents' => $userTotalEvents,
            'userUpcomingEvents' => $userUpcomingEvents,
            'userEventsByType' => $userEventsByType,
            'userEventsLastMonth' => $userEventsLastMonth,
            'userEventsLastWeek' => $userEventsLastWeek,
        ]);
    }
}
