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
            'public_holidays' => __('calendar_settings.tabs.public_holidays'),
            'generate_attendance' => __('calendar_settings.tabs.generate_attendance')
        ]])

        <form method="POST" action="{{ route('generate_attendance__run') }}">
            @csrf

            <table class="table table-borderless">
                <tbody>
                <tr>
                    <td>{{ __('calendar_settings.generate_attendance.calculation') }}</td>
                    <td>
                        <select class="form-select" name="calculation_mode" id="calculationMode">
                            <option value="week">{{ __('calendar_settings.generate_attendance.week') }}</option>
                            <option value="month">{{ __('calendar_settings.generate_attendance.month') }}</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td id="generateLabel">{{ __('calendar_settings.generate_attendance.generate_week') }}</td>
                    <td>
                        <input type="number" class="form-control" name="current_period" id="currentPeriodInput">
                        <div class="invalid-feedback">
                            Hodnota je mimo povoleného rozsahu.
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>{{ __('calendar_settings.generate_attendance.shift') }}</td>
                    <td>
                        <select class="form-select" name="shift">
                            <option value="8">{{ __('calendar_settings.generate_attendance.shift_8') }}</option>
                            <option value="12">{{ __('calendar_settings.generate_attendance.shift_12') }}</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>{{ __('calendar_settings.generate_attendance.work_saturday') }}</td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="work_saturday" id="work_saturday">
                            <label class="form-check-label" for="work_saturday">
                                {{ __('calendar_settings.generate_attendance.yes') }}
                            </label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>{{ __('calendar_settings.generate_attendance.work_sunday') }}</td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="work_sunday" id="work_sunday">
                            <label class="form-check-label" for="work_sunday">
                                {{ __('calendar_settings.generate_attendance.yes') }}
                            </label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="width:40%">
                        <label class="form-label">{{ __('calendar_settings.generate_attendance.users') }}</label>
                        <select id="leftList" class="form-select" multiple size="8">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td style="width:20%" class="text-center align-middle">
                        <div class="d-flex flex-column align-items-center">
                            <button type="button" class="btn btn-primary mb-2" id="toRight">&gt;&gt;</button>
                            <button type="button" class="btn btn-secondary" id="toLeft">&lt;&lt;</button>
                        </div>
                    </td>

                    <td style="width:40%">
                        <label class="form-label">{{ __('calendar_settings.generate_attendance.selected_users') }}</label>
                        <select id="rightList" class="form-select" multiple size="8"></select>
                    </td>
                </tr>

                <tr>
                    <td>{{ __('calendar_settings.generate_attendance.first_user') }}</td>
                    <td>
                        <select class="form-select" name="first_user" id="firstUserSelect">
                            <option value="random">{{ __('calendar_settings.generate_attendance.random') }}</option>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>

            <input type="hidden" name="selected_users" id="selectedUsersInput">

            <div class="mt-4">
                <button type="submit" class="btn btn-success w-100">
                    {{ __('calendar_settings.generate_attendance.run_button') }}
                </button>
            </div>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toRight = document.getElementById('toRight');
        const toLeft = document.getElementById('toLeft');
        const leftList = document.getElementById('leftList');
        const rightList = document.getElementById('rightList');
        const firstUserSelect = document.getElementById('firstUserSelect');
        const calculationMode = document.getElementById('calculationMode');
        const generateLabel = document.getElementById('generateLabel');
        const selectedUsersInput = document.getElementById('selectedUsersInput');
        const form = document.querySelector('form[action="{{ route('generate_attendance__run') }}"]');
        const currentPeriodInput = document.getElementById('currentPeriodInput');

        const generateWeekText = @json(__('calendar_settings.generate_attendance.generate_week'));
        const generateMonthText = @json(__('calendar_settings.generate_attendance.generate_month'));

        function updateFirstUserSelect() {
            firstUserSelect.innerHTML = '';
            const randomOption = new Option(@json(__('calendar_settings.generate_attendance.random')), 'random');
            firstUserSelect.appendChild(randomOption);

            Array.from(rightList.options).forEach(option => {
                firstUserSelect.appendChild(new Option(option.textContent, option.value));
            });
        }

        function updateGenerateLabel() {
            generateLabel.textContent =
                calculationMode.value === 'week'
                    ? generateWeekText
                    : generateMonthText;

            updateCurrentPeriodConstraints();
            updateCurrentPeriod(); // vložené späť
        }

        function getWeekNumber(date) {
            const d = new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate()));
            const dayNum = d.getUTCDay() || 7;
            d.setUTCDate(d.getUTCDate() + 4 - dayNum);
            const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
            return Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
        }

        function updateCurrentPeriod() {
            const today = new Date();
            currentPeriodInput.value =
                calculationMode.value === 'week'
                    ? getWeekNumber(today)
                    : today.getMonth() + 1;
        }

        function updateCurrentPeriodConstraints() {
            if (calculationMode.value === 'week') {
                currentPeriodInput.setAttribute('min', '1');
                currentPeriodInput.setAttribute('max', '52');
            } else {
                currentPeriodInput.setAttribute('min', '1');
                currentPeriodInput.setAttribute('max', '12');
            }
            currentPeriodInput.classList.remove('is-invalid');
        }

        currentPeriodInput.addEventListener('input', () => {
            const value = parseInt(currentPeriodInput.value, 10);
            const min = parseInt(currentPeriodInput.getAttribute('min'), 10);
            const max = parseInt(currentPeriodInput.getAttribute('max'), 10);

            if (isNaN(value) || value < min || value > max) {
                currentPeriodInput.classList.add('is-invalid');
            } else {
                currentPeriodInput.classList.remove('is-invalid');
            }
        });

        toRight.addEventListener('click', () => {
            Array.from(leftList.selectedOptions).forEach(option => rightList.appendChild(option));
            updateFirstUserSelect();
        });

        toLeft.addEventListener('click', () => {
            Array.from(rightList.selectedOptions).forEach(option => leftList.appendChild(option));
            updateFirstUserSelect();
        });

        calculationMode.addEventListener('change', updateGenerateLabel);

        form.addEventListener('submit', (event) => {
            const values = Array.from(rightList.options).map(option => option.value);

            if (values.length < 3) {
                alert(@json(__('calendar_settings.generate_attendance.warning')));
                event.preventDefault();
                return;
            }

            if (currentPeriodInput.classList.contains('is-invalid')) {
                event.preventDefault();
                return;
            }

            selectedUsersInput.value = JSON.stringify(values);
        });

        updateFirstUserSelect();
        updateGenerateLabel();
    });
</script>
