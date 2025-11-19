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
            @php $columnsCount = min(7, count($dayEntries)) @endphp

            <div class="d-grid h-100" style="grid-template-columns: repeat({{ $columnsCount }}, minmax(0, 1fr)); grid-auto-rows: 1fr; min-width: 0;">
                @foreach($dayEntries as $i => $dayEntry)
                    @php
                        $isLastInRow = $i % $columnsCount === 0;

                        $headerBg = match (true) {
                            $dayEntry->isToday() === true => 'bg-primary text-white',
                            $dayEntry->isWeekend() === true => 'bg-dark bg-opacity-75 text-white',
                            default => 'bg-light'
                        };;

                        $subHeaderText = match (true) {
                            $dayEntry->isToday() === true => 'text-white-50',
                            $dayEntry->isWeekend() === true => 'text-white-50',
                            default => 'text-muted'
                        };
                    @endphp

                    <section class="d-flex flex-column calendar-day {{ $isLastInRow ? '' : 'border-end' }}">
                        <header class="text-center py-2 border-bottom {{ $headerBg }}">
                            <div class="fw-semibold">{{ $dayEntry->getLabel() }}</div>
                            <div class="{{ $subHeaderText }} small">{{ $dayEntry->getMonth() }} {{ $dayEntry->getDay() }}</div>
                        </header>

                        <div class="position-relative flex-grow-1 overflow-auto p-2" data-day="2025-11-10" aria-label="events-list">
                            <div class="d-grid gap-2">
                                @foreach($events as $event)
                                    <div class="card card-body p-2 small">
                                        <div class="fw-semibold">{{ $event->name }}</div>
                                        <div class="text-muted">{{ $event->time }}</div>
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
