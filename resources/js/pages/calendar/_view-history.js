import { CalendarContextMenuItem } from "../../Components/CalendarContextMenu.js";

export class ViewHistoryMenuItem extends CalendarContextMenuItem
{
    handle(element, contextMenuItemElement)
    {
        const eventId = this.getEventId(element);
        if (!eventId) {
            console.error("Could not find event ID");
            return;
        }

        const modalElement = document.querySelector("#eventHistoryModal");
        if (!modalElement) {
            console.error("Could not find modal element");
            return;
        }

        const modal = new bootstrap.Modal(modalElement);

        const loadingEl = modalElement.querySelector("#history-loading");
        const errorEl = modalElement.querySelector("#history-error");
        const contentEl = modalElement.querySelector("#history-content");

        // reset
        errorEl.classList.add("d-none");
        errorEl.textContent = "";
        contentEl.innerHTML = "";
        loadingEl.classList.remove("d-none");

        modal.show();

        fetch(`/api/event/history/${eventId}`)
            .then(response => {
                if (!response.ok) throw new Error("Failed to load event history");
                return response.json();
            })
            .then(logs => {
                loadingEl.classList.add("d-none");

                if (!logs.length) {
                    contentEl.innerHTML = `<dt>No history.</dt>`;
                    return;
                }
                const groupedInserts = {};
                logs.forEach(item => {
                    if (item.action === "insert") {
                        if (!groupedInserts[item.order]) {
                            groupedInserts[item.order] = [];
                        }
                        groupedInserts[item.order].push(item);
                    }
                });

                let html = "";

                for (const order in groupedInserts) {
                    const items = groupedInserts[order];
                    const date = items[0]?.changed_at ?? '';
                    html += `<dt>${order}. Created (${date})</dt>`;
                    html += "<dd>";
                    items.forEach(it => {
                        html += `${it.column_name}: ${it.new_value} <br>`;
                    });
                    html += "</dd>";
                }

                logs.forEach(item => {
                    const date = item.changed_at ?? '';
                    const order = item.order ?? '';
                    const user = item.id_changed_by ?? 'Unknown';

                    if (item.action === "update") {
                        const col = item.column_name ?? '';
                        const oldVal = item.old_value ?? '';
                        const newVal = item.new_value ?? '';
                        html += `<dt>${order}. Updated: ${col} (${date})</dt>`;
                        html += `<dd>Updated By: ${user}<br>${oldVal} → ${newVal}</dd>`;
                    }

                    if (item.action === "delete") {
                        html += `<dt>${order}. Deleted (${date})</dt>`;
                        html += `<dd class="text-danger">Deleted By: ${user}</dd>`;
                    }
                });

                contentEl.innerHTML = html;
            })
            .catch(err => {
                console.error(err);
                loadingEl.classList.add("d-none");
                errorEl.classList.remove("d-none");
                errorEl.textContent = "Failed to load history.";
            });
    }

    isVisible(element) {
        return this.getEventId(element) !== null;
    }

    getEventId(element) {
        let current = element instanceof Element ? element : element?.parentElement;

        while (current && current !== document.documentElement) {
            if (
                current.dataset.event_id !== undefined &&
                current.dataset.event_id.length > 0
            ) {
                return current.dataset.event_id;
            }
            current = current.parentElement;
        }

        return null;
    }
}
