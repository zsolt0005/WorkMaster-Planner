import {CalendarContextMenuItem} from "../../Components/CalendarContextMenu.js";

export class DeleteEventMenuItem extends CalendarContextMenuItem
{
    handle(element, contextMenuItemElement)
    {
        console.log('Deleting event for element', element);
    }

    isVisible(element)
    {
        return true;
    }
}
