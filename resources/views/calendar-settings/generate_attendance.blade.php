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
                    <input type="text" class="form-control" name="current_period">
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
                        <label class="form-check-label" for="work_saturday">{{ __('calendar_settings.generate_attendance.yes') }}</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>{{ __('calendar_settings.generate_attendance.work_sunday') }}</td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="work_sunday" id="work_sunday">
                        <label class="form-check-label" for="work_sunday">{{ __('calendar_settings.generate_attendance.yes') }}</label>
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
                    <select id="rightList" class="form-select" multiple size="8">
                    </select>
                </td>
            </tr>
            <tr>
                <td>{{ __('calendar_settings.generate_attendance.first_user') }}</td>
                <td>
                    <select class="form-select" name="first_user">
                        <option value="random">{{ __('calendar_settings.generate_attendance.random') }}</option>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="mt-4">
            <form method="POST" action="{{ route('generate_attendance__run') }}">
                @csrf
                <input type="hidden" name="selected_users" id="selectedUsersInput">
                <button type="submit" class="btn btn-success w-100">
                    {{ __('calendar_settings.generate_attendance.run_button') }}
                </button>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        console.log("Script loaded");

        const toRight = document.getElementById('toRight');
        const toLeft = document.getElementById('toLeft');
        const leftList = document.getElementById('leftList');
        const rightList = document.getElementById('rightList');
        const firstUserSelect = document.querySelector('select[name="first_user"]');
        const calculationMode = document.getElementById('calculationMode');
        const generateLabel = document.getElementById('generateLabel');
        const selectedUsersInput = document.getElementById('selectedUsersInput');
        const form = document.querySelector('form[action="{{ route('generate_attendance__run') }}"]');
        const currentPeriodInput = document.querySelector('input[name="current_period"]');

        const generateWeekText = @json(__('calendar_settings.generate_attendance.generate_week'));
        const generateMonthText = @json(__('calendar_settings.generate_attendance.generate_month'));

        function updateFirstUserSelect() {
            firstUserSelect.innerHTML = '';

            const randomOption = document.createElement('option');
            randomOption.value = 'random';
            randomOption.textContent = @json(__('calendar_settings.generate_attendance.random'));
            firstUserSelect.appendChild(randomOption);

            Array.from(rightList.options).forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option.value;
                newOption.textContent = option.textContent;
                firstUserSelect.appendChild(newOption);
            });
        }

        function updateGenerateLabel() {
            if (calculationMode.value === 'week') {
                generateLabel.textContent = generateWeekText;
            } else if (calculationMode.value === 'month') {
                generateLabel.textContent = generateMonthText;
            }
            updateCurrentPeriod();
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

            if (calculationMode.value === 'week') {
                currentPeriodInput.value = getWeekNumber(today);
            } else if (calculationMode.value === 'month') {
                currentPeriodInput.value = today.getMonth() + 1;
            }
        }

        toRight.addEventListener('click', () => {
            Array.from(leftList.selectedOptions).forEach(option => {
                rightList.appendChild(option);
            });
            updateFirstUserSelect();
        });

        toLeft.addEventListener('click', () => {
            Array.from(rightList.selectedOptions).forEach(option => {
                leftList.appendChild(option);
            });
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

            selectedUsersInput.value = JSON.stringify(values);
        });

        updateFirstUserSelect();
        updateGenerateLabel();
    });
</script>
