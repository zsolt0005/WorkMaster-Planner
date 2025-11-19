@php
    use App\Dto\CalendarEvent;
    use App\Dto\DateEntry;

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
                                <button class="btn btn-outline-secondary" type="button">Day</button>
                                <button class="btn btn-primary" type="button">Week</button>
                                <button class="btn btn-outline-secondary" type="button">Month</button>
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

                <div class="col-auto ms-auto d-flex align-items-center">
                    <button type="submit" class="btn btn-primary mb-0">Search</button>
                </div>
            </form>
        </div>

        <div class="container-fluid h-100 px-0" id="calendar">
            @php
                $columnsCount = min(7, count($dayEntries));
                $totalColumnsCount = $columnsCount + 1;
            @endphp

            <div class="d-grid h-100"
                 style="grid-template-columns: 4rem repeat({{ $totalColumnsCount }}, minmax(0, 1fr)); grid-auto-rows: 1fr; min-width: 0;">
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
                            <div class="position-relative flex-grow-1 overflow-auto py-2 px-0" aria-label="events-list">
                                <div class="d-grid gap-3 p-0 m-0">
                                    @for($hour = 0; $hour <= 23; $hour++)
                                        <div class="text-center fw-light border-bottom">
                                            {{ sprintf('%02d:00', $hour) }}
                                        </div>
                                        <div class="text-center fw-light border-bottom border-dark">
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

                        <div class="position-relative flex-grow-1 overflow-auto py-2 px-0" data-day="{{ $dayEntry->getDate() }}" aria-label="events-list">
                            <div class="d-grid gap-3 p-0 m-0">
                                @for($hour = 0; $hour <= 23; $hour++)
                                    <div class="text-center fw-light border-bottom">&#8203;</div>
                                    <div class="text-center fw-light border-bottom border-dark">&#8203;</div>
                                @endfor
                            </div>

                            <div class="p-0 m-0 calendar-events-layer">
                                @foreach($events as $i => $event)
                                    <div class="card card-body mx-2 p-2 small bg-opacity-75 bg-secondary"
                                         style="
                                            top: calc((100% / 48) * {{ $i === 0 ? 10 : 9}});
                                            height: calc((100% / 48) * 3);
                                            left: 0;
                                            right: 0;
                                         ">
                                        <div class="fw-semibold">{{ $event->name }}</div>
                                        <div class="text-muted">
                                            {{ $event->dateTimeFrom->format('H:i') }} - {{ $event->dateTimeTo->format('H:i') }}
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

    @vite(['resources/js/pages/calendar.js'])
@endsection
