import { CalendarContextMenu } from './../Components/CalendarContextMenu.js';

window.menuItems ??= new Map();

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
            const fn = typeof window[value] === 'function' ? window[value] : null;
            menu.set(key, fn);
        }
    })

    return menu;
}


/** ---*---*---HANDLERS---*---*--- **/

window.createEventHandler = (element) => {
    console.log(element);
};

window.refreshEventHandler = () => {
    window.location.reload();
};
