@extends('layouts.app')

@section('title', __('dashboard.title'))

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">{{ __('dashboard.title') }}</h1>

        <h2 class="mb-3 text-primary">{{ __('dashboard.heading.view.app_statistics') }}</h2>

        <h3 class="mb-3 text-primary">{{ __('dashboard.heading.view.events') }}</h3>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('dashboard.heading.view.upcoming_holidays') }}</h6>
                        @forelse($holidayEvents as $e)
                            <small class="d-block">{{ $e->title }} ({{ \Carbon\Carbon::parse($e->start_date_time)->format('d.m.') }})</small>
                        @empty
                            <small>{{ __('dashboard.heading.view.no_holidays') ?? 'No events' }}</small>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('dashboard.heading.view.total_events') }}</h6>
                        <h2>{{ $totalEvents }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('dashboard.heading.view.events_last_month_count') }}</h6>
                        <h2>{{ $eventsMonthly->sum('count') }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-lg-6 col-md-12 d-flex">
                <div class="card h-100 shadow-sm w-100">
                    <div class="card-body d-flex flex-column">
                        <h6 class="text-muted">{{ __('dashboard.heading.view.charts.events_by_type') }}</h6>
                        <canvas id="eventsByTypeChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 d-flex flex-column">
                <div class="row g-3 flex-grow-1">
                    <div class="col-12 d-flex">
                        <div class="card shadow-sm w-100">
                            <div class="card-body d-flex flex-column h-100">
                                <h6 class="text-muted">{{ __('dashboard.heading.view.charts.events_last_month') }}</h6>
                                <canvas id="eventsMonthlyChart" class="flex-grow-1"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="card shadow-sm w-100">
                            <div class="card-body d-flex flex-column h-100">
                                <h6 class="text-muted">{{ __('dashboard.heading.view.charts.events_last_week') }}</h6>
                                <canvas id="eventsLastWeekChart" class="flex-grow-1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mt-5 mb-3 text-success">{{ __('dashboard.heading.view.users') }}</h3>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('dashboard.heading.view.last_added_user') }}</h6>
                        <h5>{{ $lastAddedUser->full_name ?? '—' }}</h5>
                        <small>{{ optional($lastAddedUser->created_at)->format('d.m.Y H:i') }}</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('dashboard.heading.view.all_users') }}</h6>
                        <h2>{{ $totalUsers }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('dashboard.heading.view.new_users_last_month') }}</h6>
                        <h2>{{ $usersThisMonth }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-lg-6 col-md-12 d-flex flex-column">
                <div class="row g-3 flex-grow-1">
                    <div class="col-12 d-flex">
                        <div class="card shadow-sm w-100">
                            <div class="card-body d-flex flex-column h-100">
                                <h6 class="text-muted">{{ __('dashboard.heading.view.charts.users_last_year') }}</h6>
                                <canvas id="usersLastYearChart" class="flex-grow-1"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="card shadow-sm w-100">
                            <div class="card-body d-flex flex-column h-100">
                                <h6 class="text-muted">{{ __('dashboard.heading.view.charts.users_last_week') }}</h6>
                                <canvas id="usersLastWeekChart" class="flex-grow-1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 d-flex">
                <div class="card h-100 shadow-sm w-100">
                    <div class="card-body d-flex flex-column">
                        <h6 class="text-muted">{{ __('dashboard.heading.view.charts.users_by_type') }}</h6>
                        <canvas id="usersByRolesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5 mb-3 text-info">{{ __('dashboard.heading.view.personal_statistics') }}</h2>

        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <h3 class="text-info mb-0">
                {{ $selectedUser->id === auth()->id()
                    ? __('dashboard.heading.view.your_stats')
                    : $selectedUser->full_name . ' ' . __('dashboard.heading.view.stats') }}
            </h3>
            @can('view_users_dashboard')
                <form method="GET" class="d-flex">
                    <select name="user_id" class="form-select me-2">
                        <option value="">{{ __('Select Employee') }}</option>
                        @foreach($allUsers as $u)
                            <option value="{{ $u->id }}" {{ $selectedUserId == $u->id ? 'selected' : '' }}>
                                {{ $u->full_name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">{{ __('dashboard.filter') }}</button>
                </form>
            @endcan
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('dashboard.heading.view.upcoming_events') }}</h6>
                        @forelse($userUpcomingEvents as $e)
                            <h6>{{ $e->title }} ({{ \Carbon\Carbon::parse($e->start_date_time)->format('d.m.') }})</h6>
                        @empty
                            <small>{{ __('dashboard.heading.view.no_events') ?? 'No events' }}</small>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('dashboard.heading.view.days_in_system') }}</h6>
                        <h2>{{ $daysSinceRegistration }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('dashboard.heading.view.your_total_events') }}</h6>
                        <h2>{{ $userTotalEvents }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-lg-6 col-md-12 d-flex">
                <div class="card h-100 shadow-sm w-100">
                    <div class="card-body d-flex flex-column">
                        <h6 class="text-muted">{{ __('dashboard.heading.view.charts.user_events_by_type') }}</h6>
                        <canvas id="userEventsByTypeChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 d-flex flex-column">
                <div class="row g-3 flex-grow-1">
                    <div class="col-12 d-flex">
                        <div class="card shadow-sm w-100">
                            <div class="card-body d-flex flex-column h-100">
                                <h6 class="text-muted">{{ __('dashboard.heading.view.charts.user_events_last_month') }}</h6>
                                <canvas id="userEventsLastMonthChart" class="flex-grow-1"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="card shadow-sm w-100">
                            <div class="card-body d-flex flex-column h-100">
                                <h6 class="text-muted">{{ __('dashboard.heading.view.charts.user_events_this_week') }}</h6>
                                <canvas id="userEventsLastWeekChart" class="flex-grow-1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        window.dashboardData = {
            usersLastYear: @json($usersLastYear),
            usersByRoles: @json($usersByRoles),
            eventsMonthly: @json($eventsMonthly),
            eventsByType: @json($eventsByType),
            userEventsByType: @json($userEventsByType),
            userEventsLastMonth: @json($userEventsLastMonth),
            usersLastWeek: @json($usersLastWeek),
            eventsLastWeek: @json($eventsLastWeek),
            userEventsLastWeek: @json($userEventsLastWeek)
        };
    </script>
@endsection
