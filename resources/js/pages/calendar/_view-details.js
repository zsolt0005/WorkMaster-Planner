import {CalendarContextMenuItem} from "../../Components/CalendarContextMenu.js";

export class ViewDetailsMenuItem extends CalendarContextMenuItem
{
    handle(element, contextMenuItemElement)
    {
        const eventId = this.getEventId(element);
        if (!eventId) {
            console.error('Could not find event ID');
            return;
        }

        const modalElement = document.querySelector('#viewDetailsModal');
        if (!modalElement) {
            console.error('Could not find modal element');
            return;
        }

        const modal = new bootstrap.Modal(modalElement);

        const loadingEl = modalElement.querySelector('#view-details-loading');
        const errorEl = modalElement.querySelector('#view-details-error');
        const titleEl = modalElement.querySelector('#view-details-title');
        const fieldTitleEl = modalElement.querySelector('#view-details-field-title');
        const fieldDescEl = modalElement.querySelector('#view-details-field-description');
        const fieldTypeEl = modalElement.querySelector('#view-details-field-type');
        const fieldAssigned = modalElement.querySelector('#view-details-field-assigned-user');
        const fieldCreated = modalElement.querySelector('#view-details-field-created-by');
        const fieldStartEl = modalElement.querySelector('#view-details-field-start');
        const fieldEndEl = modalElement.querySelector('#view-details-field-end');

        if (errorEl) {
            errorEl.classList.add('d-none');
            errorEl.textContent = '';
        }
        if (loadingEl) {
            loadingEl.classList.remove('d-none');
        }
        if (fieldTitleEl) fieldTitleEl.textContent = '';
        if (fieldDescEl) fieldDescEl.textContent = '';
        if (fieldTypeEl) fieldTypeEl.textContent = '';
        if (fieldAssigned) fieldAssigned.textContent = '';
        if (fieldCreated) fieldCreated.textContent = '';
        if (fieldStartEl) fieldStartEl.textContent = '';
        if (fieldEndEl) fieldEndEl.textContent = '';

        modal.show();

        fetch(`/api/event/details/${eventId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Failed to load event details (status ${response.status})`);
            }
            return response.json();
        })
        .then(data => {
            if (loadingEl) loadingEl.classList.add('d-none');

            if (titleEl) {
                titleEl.textContent = data.title || `Event #${data.id}`;
            }
            if (fieldTitleEl) fieldTitleEl.textContent = data.title ?? '';
            if (fieldDescEl) fieldDescEl.textContent = data.description ?? '';
            if (fieldTypeEl) fieldTypeEl.textContent = data.event_type?.identifier ?? '';
            if (fieldAssigned) fieldAssigned.textContent = data.assigned_user?.full_name ?? '';
            if (fieldCreated) fieldCreated.textContent = data.created_by_user?.full_name ?? '';
            if (fieldStartEl) fieldStartEl.textContent = data.start_date_time ?? '';
            if (fieldEndEl) fieldEndEl.textContent = data.end_date_time ?? '';

            const editBtn = modalElement.querySelector('#view-details-edit-button');
            if (editBtn) {
                editBtn.onclick = async () => {
                    const editModalElement = document.querySelector('#editEventModal');
                    const editModal = new bootstrap.Modal(editModalElement);

                    const inputId       = editModalElement.querySelector('#edit-event-id');
                    const inputTitle    = editModalElement.querySelector('#edit-event-title');
                    const inputDesc     = editModalElement.querySelector('#edit-event-description');
                    const selectUser    = editModalElement.querySelector('#edit-event-assigned-user');
                    const selectType    = editModalElement.querySelector('#edit-event-event-type');
                    const inputStart    = editModalElement.querySelector('#edit-event-start');
                    const inputEnd      = editModalElement.querySelector('#edit-event-end');

                    selectUser.innerHTML = '<option>Loading...</option>';
                    selectType.innerHTML = '<option>Loading...</option>';

                    inputId.value = data.id;
                    inputTitle.value = data.title ?? '';
                    inputDesc.value = data.description ?? '';

                    inputStart.value = data.start_date_time?.replace(' ', 'T') ?? '';
                    inputEnd.value   = data.end_date_time?.replace(' ', 'T') ?? '';

                    try {
                        const [users, eventTypes] = await Promise.all([
                            loadUsers(),
                            loadEventTypes(),
                        ]);

                        selectType.innerHTML = '';
                        eventTypes.forEach(t => {
                            const option = document.createElement('option');
                            option.value = t.value;
                            option.textContent = t.value;
                            if (data.event_type?.identifier === t.value) {
                                option.selected = true;
                            }
                            selectType.appendChild(option);
                        });

                        selectUser.innerHTML = '';
                        users.forEach(u => {
                            const option = document.createElement('option');
                            option.value = u.id;
                            option.textContent = u.value;
                            if (data.assigned_user?.id === u.id) {
                                option.selected = true;
                            }
                            selectUser.appendChild(option);
                        });
                    } catch (e) {
                        console.error(e);
                        selectUser.innerHTML = '<option>Error loading users</option>';
                        selectType.innerHTML = '<option>Error loading types</option>';
                    }

                    editModal.show();
                };

            }
        })
        .catch(error => {
            console.error(error);
            if (loadingEl) loadingEl.classList.add('d-none');
            if (errorEl) {
                errorEl.textContent = 'Failed to load event details.';
                errorEl.classList.remove('d-none');
            }
        });
    }

    isVisible(element)
    {
        return this.getEventId(element) !== null;
    }

    getEventId(element) {
        let current = element instanceof Element ? element : element?.parentElement;

        while (current && current !== document.documentElement) {
            if (current.dataset.event_id !== undefined && current.dataset.event_id.length > 0) {
                return current.dataset.event_id;
            }

            current = current.parentElement;
        }

        return null;
    }
}

async function loadUsers() {
    const response = await fetch('/api/users/search?q=');
    if (!response.ok) throw new Error('Failed to load users');
    return await response.json();
}

async function loadEventTypes() {
    const response = await fetch('/api/event-types/search?q=');
    if (!response.ok) throw new Error('Failed to load event types');
    return await response.json();
}
