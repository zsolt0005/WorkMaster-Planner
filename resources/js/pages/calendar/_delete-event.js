import {CalendarContextMenuItem} from "../../Components/CalendarContextMenu.js";

export class DeleteEventMenuItem extends CalendarContextMenuItem
{
    handle(element, contextMenuItemElement)
    {
        const eventId = this.getEventId(element);
        if (!eventId) {
            console.error('Could not find event ID');
            return;
        }

        const modalElement = document.querySelector('#deleteEventModal');
        if (!modalElement) {
            console.error('Could not find modal element');
            return;
        }

        const deleteInput = modalElement.querySelector('#delete_event__id');
        if (!deleteInput) {
            console.error('Could not find delete input element');
            return;
        }

        deleteInput.value = eventId;

        const modal = new bootstrap.Modal(modalElement);
        modal.show();

        modalElement.addEventListener('hidden.bs.modal', () => {
            deleteInput.value = '';
        })
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
