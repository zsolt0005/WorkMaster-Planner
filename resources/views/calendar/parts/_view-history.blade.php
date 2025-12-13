<div class="modal fade" id="eventHistoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">{{ __('calendar.event_history.header') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div id="history-loading" class="mb-3 d-none">
                    <em>{{ __('calendar.event_history.loading') }}</em>
                </div>

                <div id="history-error" class="text-danger d-none mb-2"></div>

                <dl id="history-content" class="mb-0">
                    <!-- dynamic data -->
                </dl>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('calendar.event_history.close_button') }}
                </button>
            </div>

        </div>
    </div>
</div>
