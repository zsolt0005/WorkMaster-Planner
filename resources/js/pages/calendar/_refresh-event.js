import {CalendarContextMenuItem} from "../../Components/CalendarContextMenu.js";

export class RefreshEventMenuItem extends CalendarContextMenuItem
{
    handle(element, contextMenuItemElement)
    {
        window.location.reload();
    }

    isVisible(element)
    {
        return true;
    }
}
