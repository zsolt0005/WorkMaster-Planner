import {CalendarContextMenuItem} from "../../Components/CalendarContextMenu.js";

export class CreateEventMenuItem extends CalendarContextMenuItem
{
    handle(element, contextMenuItemElement)
    {
        const modalElement = document.querySelector('#createEventModal');
        if (!modalElement) {
            console.error('Could not find modal element');
            return;
        }

        const modal = new bootstrap.Modal(modalElement);
        modal.show();

        const closestTimeSlot = element.closest('[data-time]')?.dataset.time ?? null;

        const startDateTimeField = document.querySelector('#create_event__start_date_time');
        const endDateTimeField = document.querySelector('#create_event__end_date_time');

        // Determine base start time: closestTimeSlot or rounded "now"
        let startDate;
        if (closestTimeSlot) {
            // closestTimeSlot format: "YYYY-MM-DD HH:MM"
            // Convert to "YYYY-MM-DDTHH:MM" so the Date constructor can parse consistently
            const isoLike = closestTimeSlot.replace(' ', 'T');
            startDate = new Date(isoLike);
            if (isNaN(startDate.getTime())) {
                console.warn('Invalid closestTimeSlot, falling back to current time:', closestTimeSlot);
                startDate = new Date();
            }
        } else {
            // No closestTimeSlot: use current time rounded up to next 30-minute mark
            startDate = new Date();
        }

        // If we didn't get closestTimeSlot, or if we fell back, round up to the next 30 minutes
        if (!closestTimeSlot) {
            const minutes = startDate.getMinutes();
            const roundedMinutes = minutes <= 30 ? 30 : 60;
            startDate.setMinutes(roundedMinutes, 0, 0); // set minutes, seconds, ms

            // If we rounded to 60, move to next hour
            if (roundedMinutes === 60) {
                startDate.setHours(startDate.getHours() + 1);
                startDate.setMinutes(0, 0, 0);
            }
        }

        // End time: start + 30 minutes
        const endDate = new Date(startDate.getTime() + 30 * 60 * 1000);

        // Helper to format as "YYYY-MM-DDTHH:MM" for datetime-local
        const formatForDateTimeLocal = (date) => {
            const pad = (n) => String(n).padStart(2, '0');
            const year = date.getFullYear();
            const month = pad(date.getMonth() + 1);
            const day = pad(date.getDate());
            const hours = pad(date.getHours());
            const minutes = pad(date.getMinutes());
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        };

        if (startDateTimeField) {
            startDateTimeField.value = formatForDateTimeLocal(startDate);
        }
        if (endDateTimeField) {
            endDateTimeField.value = formatForDateTimeLocal(endDate);
        }
    }

    isVisible(element)
    {
        return true;
    }
}
