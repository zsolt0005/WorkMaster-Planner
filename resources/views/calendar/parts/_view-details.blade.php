<div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="view-details-title">{{ __('calendar.event_details.header') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="view-details-loading" class="mb-3 d-none">
                    <em>{{ __('calendar.event_details.loading') }}</em>
                </div>

                <dl class="row mb-0" id="view-details-content">
                    <dt class="col-sm-4">{{ __('calendar.event_details.title') }}</dt>
                    <dd class="col-sm-8" id="view-details-field-title"></dd>

                    <dt class="col-sm-4">{{ __('calendar.event_details.description') }}</dt>
                    <dd class="col-sm-8" id="view-details-field-description"></dd>

                    <dt class="col-sm-4">{{ __('calendar.event_details.event_type') }}</dt>
                    <dd class="col-sm-8" id="view-details-field-type"></dd>

                    <dt class="col-sm-4">{{ __('calendar.event_details.assigned_user') }}</dt>
                    <dd class="col-sm-8" id="view-details-field-assigned-user"></dd>

                    <dt class="col-sm-4">{{ __('calendar.event_details.created_by') }}</dt>
                    <dd class="col-sm-8" id="view-details-field-created-by"></dd>

                    <dt class="col-sm-4">{{ __('calendar.event_details.start_date_time') }}</dt>
                    <dd class="col-sm-8" id="view-details-field-start"></dd>

                    <dt class="col-sm-4">{{ __('calendar.event_details.end_date_time') }}</dt>
                    <dd class="col-sm-8" id="view-details-field-end"></dd>
                </dl>

                <div id="view-details-error" class="text-danger d-none mt-2"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="view-details-edit-button">
                    {{ __('calendar.event_details.edit_button') }}
                </button>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('calendar.event_details.close_button') }}
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('calendar__event__update') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('calendar.edit_event.header') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="edit_event__id" id="edit-event-id">

                    <div class="mb-3">
                        <label for="edit-event-title" class="form-label">{{ __('calendar.edit_event.title') }}</label>
                        <input type="text" name="edit_event__title" id="edit-event-title" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="edit-event-description" class="form-label">{{ __('calendar.edit_event.description') }}</label>
                        <textarea name="edit_event__description" id="edit-event-description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit-event-event-type" class="form-label">{{ __('calendar.edit_event.event_type') }}</label>
                        <select name="edit_event__event_type_id" id="edit-event-event-type" class="form-select">
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit-event-assigned-user" class="form-label">{{ __('calendar.edit_event.assigned_user') }}</label>
                        <select name="edit_event__assigned_user_id" id="edit-event-assigned-user" class="form-select">
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit-event-start" class="form-label">{{ __('calendar.edit_event.start_date_time') }}</label>
                        <input type="datetime-local" name="edit_event__start_date_time" id="edit-event-start" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="edit-event-end" class="form-label">{{ __('calendar.edit_event.end_date_time') }}</label>
                        <input type="datetime-local" name="edit_event__end_date_time" id="edit-event-end" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('calendar.edit_event.save_button') }}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('calendar.edit_event.cancel_button') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
