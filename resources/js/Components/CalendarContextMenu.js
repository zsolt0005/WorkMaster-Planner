export class CalendarContextMenu {
    /**
     * @param {Object} options
     * @param {HTMLElement} options.calendarElement - container that receives contextmenu events
     * @param {HTMLElement} options.menuElement - the context menu element
     * @param {Map<string, CallableFunction<HTMLElement>|string>} options.menu
     */
    constructor({ calendarElement, menuElement, menu }) {
        if (!calendarElement) {
            throw new Error('CalendarContextMenu: calendarElement is required');
        }
        if (!menuElement) {
            throw new Error('CalendarContextMenu: menuElement is required');
        }
        if (!menu) {
            throw new Error('CalendarContextMenu: menu is required');
        }
        if (menu.size === 0) {
            throw new Error('CalendarContextMenu: menu requires at least one item');
        }

        this.calendarElement = calendarElement;
        this.menuElement = menuElement;
        this.menu = menu;
        this.contextTarget = null; // the element that was right-clicked

        this._onContextMenu = this._onContextMenu.bind(this);
        this._onDocumentClick = this._onDocumentClick.bind(this);
        this._onKeyDown = this._onKeyDown.bind(this);
        this._onScrollOrResize = this._onScrollOrResize.bind(this);
        this._onMenuClick = this._onMenuClick.bind(this);

        this._initialized = false;
    }

    init() {
        if (this._initialized) return;

        this.calendarElement.addEventListener('contextmenu', this._onContextMenu);
        this.menuElement.addEventListener('click', this._onMenuClick);
        document.addEventListener('click', this._onDocumentClick);
        document.addEventListener('keydown', this._onKeyDown);
        window.addEventListener('scroll', this._onScrollOrResize, true);
        window.addEventListener('resize', this._onScrollOrResize);

        this.initMenuItems();

        this._initialized = true;
    }

    destroy() {
        if (!this._initialized) return;

        this.calendarElement.removeEventListener('contextmenu', this._onContextMenu);
        this.menuElement.removeEventListener('click', this._onMenuClick);
        document.removeEventListener('click', this._onDocumentClick);
        document.removeEventListener('keydown', this._onKeyDown);
        window.removeEventListener('scroll', this._onScrollOrResize, true);
        window.removeEventListener('resize', this._onScrollOrResize);

        this._initialized = false;
    }

    // --- Public helpers ----------------------------------------------------

    /**
     * Returns the last element that was right-clicked.
     * @returns {HTMLElement|null}
     */
    getContextTarget() {
        return this.contextTarget;
    }

    /**
     * Hide the menu programmatically
     */
    hide() {
        this._hideMenu();
    }

    initMenuItems() {
        const menuList = this.menuElement.querySelector('ul');
        if (!menuList) {
            throw new Error('CalendarContextMenu: ul element is required within the menuElement');
        }

        this.menu.forEach((value, key) => {
            const listItem = document.createElement('li');

            if(key.startsWith('--spacer--')) {
                listItem.classList.add('calendar-context-menu-spacer');
                listItem.innerHTML = `${value}`;
            } else {
                listItem.classList.add('calendar-context-action');
                listItem.innerHTML = `${key}`;
                listItem.addEventListener('click', () => {value(this.contextTarget)})
            }

            menuList.appendChild(listItem);
        });
    }

    // --- Internal event handlers -------------------------------------------

    _onContextMenu(event) {
        const dayBody = event.target.closest('.calendar-day-body');
        if (!dayBody) {
            // not inside a calendar-day-body => allow normal browser menu
            this._hideMenu();
            return;
        }

        event.preventDefault(); // disable default browser context menu

        this.contextTarget = event.target;
        this._showMenuAt(event.clientX, event.clientY);
    }

    _onDocumentClick(event) {
        // if click is outside of the menu, hide it
        if (!this.menuElement.contains(event.target)) {
            this._hideMenu();
        }
    }

    _onKeyDown(event) {
        if (event.key === 'Escape') {
            this._hideMenu();
        }
    }

    _onScrollOrResize() {
        this._hideMenu();
    }

    _onMenuClick(event) {
        this._hideMenu();
    }

    // --- Internal helpers ---------------------------------------------------

    _showMenuAt(clientX, clientY) {
        this.menuElement.classList.remove('d-none');

        // temporarily show to measure size if still hidden
        const rect = this.menuElement.getBoundingClientRect();
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;

        let left = clientX;
        let top = clientY;

        if (left + rect.width > viewportWidth) {
            left = Math.max(0, viewportWidth - rect.width - 4);
        }
        if (top + rect.height > viewportHeight) {
            top = Math.max(0, viewportHeight - rect.height - 4);
        }

        this.menuElement.style.left = `${left}px`;
        this.menuElement.style.top = `${top}px`;
    }

    _hideMenu() {
        if (!this.menuElement.classList.contains('d-none')) {
            this.menuElement.classList.add('d-none');
        }
    }
}
