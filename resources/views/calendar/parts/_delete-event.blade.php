<div class="modal fade" id="deleteEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('calendar__event__delete') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('calendar.delete_event.header') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <div class="small text-muted">{{ __('calendar.delete_event.confirm') }}</div>
                        <input type="hidden" name="delete_event__id" id="delete_event__id" value="">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('buttons.delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
