@php
    use App\Dto\CalendarEvent;
    use App\Dto\DateEntry;
    use App\Permissions;

    /** @var string $viewType */
    /** @var DateEntry[] $dayEntries */
    /** @var CalendarEvent[] $events */
@endphp

@extends('layouts.app')

@section('title', 'Calendar')

@section('content')
    @vite(['resources/css/pages/calendar.css'])

    <div class="container-fluid">
        <div class="container mt-1 mb-1">
            <form action="{{ route('calendar') }}" method="GET" class="row">
                @csrf

                <div class="col-auto">
                    <h4>View</h4>

                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="input-group mb-3">
                                <a href="{{ route('calendar', ['view' => 'day']) }}" class="btn {{ $viewType === 'day' ? 'btn-primary' : 'btn-outline-secondary' }}" type="button">Day</a>
                                <a href="{{ route('calendar', ['view' => 'week']) }}" class="btn {{ $viewType === 'week' ? 'btn-primary' : 'btn-outline-secondary' }}" type="button">Week</a>
                                <a href="{{ route('calendar', ['view' => 'month']) }}" class="btn {{ $viewType === 'month' ? 'btn-primary' : 'btn-outline-secondary' }}" type="button">Month</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-auto d-none d-md-block">
                    <div class="vr h-100 mx-3"></div>
                </div>

                <div class="col">
                    <h4>Filters</h4>

                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="input-group mb-3">
                                <span class="input-group-text fw-bold">Name / User</span>
                                <input type="text" class="form-control" id="name_or_user" name="name_or_user" placeholder="Josh">
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="input-group mb-3">
                                <span class="input-group-text fw-bold">Type</span>
                                <select class="form-select" name="event_type">
                                    <option selected>All</option>
                                    <option value="vacation">Vacation</option>
                                    <option value="work_time">Work time</option>
                                    <option value="holiday">Holiday</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-auto ms-auto d-flex align-items-center gap-5">
                    <button type="submit" class="btn btn-primary mb-0">Search</button>

                    @can(Permissions::EDIT_CALENDAR_SETTINGS)
                        <a class="btn btn-outline-secondary" href="{{ route('calendar_settings') }}"><i class="bi bi-gear"></i></a>
                    @endcan
                </div>
            </form>
        </div>

        <div class="container-fluid h-100 px-0" id="calendar">
            @php
                $columnsCount = min(7, count($dayEntries));
            @endphp

            <div class="d-grid h-100 calendar-days"
                 style="grid-template-columns: 4rem repeat({{ $columnsCount }}, minmax(0, 1fr)); grid-auto-rows: 1fr; min-width: 0;">
                @foreach($dayEntries as $i => $dayEntry)
                    @php
                        $isFirstInRow = $i % $columnsCount === 0;
                        $isLastInRow = ($i + 1) % $columnsCount === 0;

                        $headerBg = match (true) {
                            $dayEntry->isToday() === true => 'bg-primary text-white',
                            $dayEntry->isWeekend() === true => 'bg-dark bg-opacity-75 text-white',
                            default => 'bg-light'
                        };

                        $subHeaderText = match (true) {
                            $dayEntry->isToday() === true => 'text-white-50',
                            $dayEntry->isWeekend() === true => 'text-white-50',
                            default => 'text-muted'
                        };
                    @endphp

                    @if($isFirstInRow)
                        <section class="d-flex flex-column border-end">
                            <header class="text-center py-2 border-bottom bg-light">
                                <div class="text-center fw-bold">Time</div>
                                <div class="text-muted small">#</div>
                            </header>
                            <div class="position-relative flex-grow-1 overflow-auto pb-2 pt-0 px-0" aria-label="events-list">
                                <div class="d-grid p-0 m-0" style="align-content: start">
                                    @for($hour = 0; $hour <= 23; $hour++)
                                        <div class="text-center fw-light border-bottom pb-2">
                                            {{ sprintf('%02d:00', $hour) }}
                                        </div>
                                        <div class="text-center fw-light border-bottom border-dark pb-2">
                                            {{ sprintf('%02d:30', $hour) }}
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </section>
                    @endif

                    <section class="d-flex flex-column calendar-day {{ $isLastInRow ? '' : 'border-end' }}">
                        <header class="text-center py-2 border-bottom {{ $headerBg }}">
                            <div class="fw-semibold">{{ $dayEntry->getLabel() }}</div>
                            <div class="{{ $subHeaderText }} small">{{ $dayEntry->getMonth() }} {{ $dayEntry->getDay() }}</div>
                        </header>

                        <div class="position-relative flex-grow-1 overflow-auto pb-2 pt-0 px-0" data-day="{{ $dayEntry->getDate() }}"
                             aria-label="events-list">

                            <div class="calendar-day-body">
                                <div class="time-slots">
                                    @for($hour = 0; $hour <= 23; $hour++)
                                        <div class="time-slot text-center fw-light border-bottom pb-2" style="grid-row: {{ ($hour * 60) + 1 }} / span 30"></div>
                                        <div class="time-slot text-center fw-light border-bottom border-dark pb-2" style="grid-row: {{ ($hour * 60) + 30 + 1 }} / span 30"></div>
                                    @endfor
                                </div>

                                <div class="events-layer">
                                    <style>
                                        @foreach ($events as $event)
                                            .event-{{ $event->event->id }} {
                                                background-color: {{ $event->getBackgroundColor(0.9) }};
                                            }

                                            .event-{{ $event->event->id }}:hover {
                                                background-color: {{ $event->getBackgroundColor(1) }};
                                            }
                                        @endforeach
                                    </style>
                                    @foreach ($events as $event)
                                        @php
                                            $startPosition = $event->getStartPosition($dayEntry->dateTime);
                                            $offset = $event->getLengthOffset($dayEntry->dateTime);
                                            $occupiedSpace = $offset / 30;
                                            $availableSpace = max(0, $occupiedSpace - 2);
                                            $bgColor = $event->getBackgroundColor(0.75);

                                            if ($startPosition === -1 || $offset === -1) {
                                                continue; // Not in the currently rendered day
                                            }
                                        @endphp
                                        <div class="event"
                                             style="grid-row: {{ $startPosition + 1 }} / span {{ $offset }}; max-height: {{ $occupiedSpace * 33 }}px !important;"
                                             data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $event->event->title }}">
                                            <div class="card card-body mx-2 p-2 small align-items-stretch event-{{ $event->event->id }} h-100 d-flex flex-column">
                                                <div class="event-title" style="color: {{ $event->getTextColor() }}; @if($occupiedSpace < 2) font-size: 0.75rem; @endif">
                                                    {{ $event->event->title }}
                                                </div>

                                                @if($availableSpace > 0)
                                                    <div style="overflow: clip;">
                                                        <span class="event-description" style="
                                                            font-size: 0.75rem;
                                                            line-height: 0.75rem;
                                                            display: -webkit-box;
                                                            -webkit-box-orient: vertical;
                                                            -webkit-line-clamp: {{ $availableSpace * 2 }};
                                                            color: {{ $event->getTextColor()->autoAdjust(0.5, $bgColor) }};
                                                        ">
                                                            {{ $event->event->description }}
                                                        </span>
                                                    </div>
                                                @endif

                                                @if($occupiedSpace > 1)
                                                    <div class="flex-fill"></div>

                                                    <div class="event-user small fw-bold" style="color: {{ $event->getTextColor(1)->autoAdjust(0.25, $bgColor) }};">
                                                        {{ $event->event->assignedUser->full_name ?? 'Unassigned' }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                            </div>
                        </div>
                    </section>
                @endforeach
            </div>
        </div>
    </div>

    @include('parts._context_menu')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuItems = new Map();
            menuItems
                .set('--spacer--main', '{{ __('calendar.context_menu.actions') }}')
                .set('{{ __('calendar.context_menu.create_event') }}', 'createEventHandler')

                .set('--spacer--other', '{{ __('calendar.context_menu.other') }}')
                .set('{{ __('calendar.context_menu.refresh') }}', 'refreshEventHandler')

            window.menuItems = menuItems;
        })
    </script>

    @vite(['resources/js/pages/calendar.js'])
@endsection
