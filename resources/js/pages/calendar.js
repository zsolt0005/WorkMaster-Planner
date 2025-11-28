import { CalendarContextMenu } from './../Components/CalendarContextMenu.js';
import { CreateEventMenuItem } from './calendar/_create-event.js'
import { DeleteEventMenuItem } from './calendar/_delete-event.js'
import { RefreshEventMenuItem } from './calendar/_refresh-event.js'

window.menuItems ??= new Map();
const handlers = {
    createEvent: new CreateEventMenuItem(),
    deleteEvent: new DeleteEventMenuItem(),
    refreshEvent: new RefreshEventMenuItem(),
};

document.addEventListener('DOMContentLoaded', () => {
    const calendarElement = document.getElementById('calendar');
    const menuElement = document.getElementById('calendar-context-menu');

    if (!calendarElement || !menuElement) {
        return;
    }

    const contextMenu = new CalendarContextMenu({
        calendarElement,
        menuElement,
        menu: getContextMenuItems()
    });

    contextMenu.init();
});

function getContextMenuItems() {
    const __ = window.translator;

    const menu = new Map();

    window.menuItems.forEach((value, key) => {
        if (key.startsWith('--spacer--')) {
            menu.set(key, value);
        } else {
            const fn = handlers[value] ?? null;
            menu.set(key, fn);
        }
    })

    return menu;
}
