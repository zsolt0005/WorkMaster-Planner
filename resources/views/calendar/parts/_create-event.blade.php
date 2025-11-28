<div class="modal fade" id="createEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('calendar__event__create') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('calendar.create_event.header') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <div class="small text-muted">{{ __('calendar.create_event.event_title') }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="create_event__title">{{ __('calendar.create_event.title') }}</label>
                        <input type="text" id="create_event__title" name="create_event__title"
                               value="{{ old('create_event__title') }}"
                               class="form-control @error('create_event__title') is-invalid @enderror"
                               placeholder="{{ __('calendar.create_event.title_placeholder') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="create_event__event_type_id">{{ __('calendar.create_event.event_type') }}</label>
                        <input type="text" id="create_event__event_type_id" name="create_event__event_type_id"
                               data-tagify-enabled="true"
                               data-tagify-config='{"url": "{{ route('event_types_search') }}", "mode": "select", "enforceWhitelist": true, "maxItems": 15}'
                               value="{{ old('create_event__event_type_id') }}"
                               class="form-control @error('create_event__event_type_id') is-invalid @enderror"
                               placeholder="{{ __('calendar.create_event.event_type_placeholder') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="create_event__assigned_user_id">{{ __('calendar.create_event.assigned_user') }}</label>
                        <input type="text" id="create_event__assigned_user_id" name="create_event__assigned_user_id"
                               data-tagify-enabled="true"
                               data-tagify-config='{"url": "{{ route('users_search') }}", "mode": "select", "enforceWhitelist": true, "maxItems": 15}'
                               value="{{ old('create_event__assigned_user_id') }}"
                               class="form-control @error('create_event__assigned_user_id') is-invalid @enderror"
                               placeholder="{{ __('calendar.create_event.assigned_user_placeholder') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="create_event__description">{{ __('calendar.create_event.description') }}</label>
                        <textarea id="create_event__description" name="create_event__description"
                               class="form-control @error('create_event__description') is-invalid @enderror"
                               placeholder="{{ __('calendar.create_event.description_placeholder') }}">{{ old('create_event__description') ?? '' }}</textarea>
                    </div>

                    <div class="mb-3 mt-5">
                        <div class="small text-muted">{{ __('calendar.create_event.event_period_title') }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="create_event__start_date_time">{{ __('calendar.create_event.start_date_time') }}</label>
                        <input type="datetime-local" id="create_event__start_date_time" name="create_event__start_date_time"
                               value="{{ old('create_event__start_date_time') }}"
                               class="form-control @error('create_event__start_date_time') is-invalid @enderror">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="create_event__end_date_time">{{ __('calendar.create_event.end_date_time') }}</label>
                        <input type="datetime-local" id="create_event__end_date_time" name="create_event__end_date_time"
                               value="{{ old('create_event__end_date_time') }}"
                               class="form-control @error('create_event__end_date_time') is-invalid @enderror">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('buttons.create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
