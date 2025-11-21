import { CalendarContextMenu } from './../Components/CalendarContextMenu.js';

(() => {
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
})()

function getContextMenuItems() {
    const menu = new Map();

    menu.set('--spacer--main', 'Main actions');
    menu.set('Add event', createEventHandler);
    menu.set('Delete event', (target) => { /* ... */ });

    menu.set('--spacer--other', 'Other');
    menu.set('Refresh', (target) => { /* ... */ });

    return menu;
}

function createEventHandler(element) {
    console.log(element);
}
