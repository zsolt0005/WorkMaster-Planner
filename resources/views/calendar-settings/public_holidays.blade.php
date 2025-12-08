@php
    use App\Models\EventType;

    /** @var EventType[] $eventTypes */
@endphp

@extends('layouts.app')

@section('Calendar settings', 'Dashboard')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Calendar settings</h1>

        @include('parts._tabs', ['tabs' => [
            'calendar_settings' => __('calendar_settings.tabs.event_types'),
            'public_holidays' => __('calendar_settings.tabs.public_holidays')
        ]])

        <div class="mt-4">
            <h2 class="h4 mb-3">Public holidays</h2>

            <form method="POST" action="{{ route('public_holidays__sync') }}" class="mb-4">
                @csrf

                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="country" class="form-label">{{ __('calendar_settings.public_holidays.country') }}</label>
                        <select name="country" id="country" class="form-select">
                            <option value="SK">Slovakia</option>
                            <option value="CZ">Czech Republic</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="year" class="form-label">{{ __('calendar_settings.public_holidays.year') }}</label>
                        <input
                            type="number"
                            name="year"
                            id="year"
                            class="form-control"
                            value="{{ old('year', now()->year) }}"
                            min="2000"
                            max="2100"
                        >
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            {{ __('calendar_settings.public_holidays.load_holidays') }}
                        </button>
                    </div>
                </div>
            </form>

            <form method="POST" action="{{ route('public_holidays__clear') }}">
                @csrf
                <button
                    type="submit"
                    class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete all public holidays from the calendar?');"
                >
                    {{ __('calendar_settings.public_holidays.delete_holidays') }}
                </button>
            </form>
        </div>
    </div>
@endsection
