<?php declare(strict_types=1);

namespace App;

final class Permissions
{
    public const string CREATE_ROLE = 'create_role';

    public const string EDIT_ROLE = 'edit_role';

    public const string DELETE_ROLE = 'delete_role';

    public const string VIEW_ROLE = 'view_role';

    public const string ASSIGN_ROLE = 'assign_role';

    public const string CREATE_PERMISSION = 'create_permission';

    public const string EDIT_PERMISSION = 'edit_permission';

    public const string DELETE_PERMISSION = 'delete_permission';

    public const string VIEW_PERMISSION = 'view_permission';

    public const string ASSIGN_PERMISSION = 'assign_permission';

    public const string EDIT_CALENDAR_SETTINGS = 'edit_calendar_settings';

    public const string CREATE_EVENT = 'create_event';

    public const string CREATE_EVENT_FOR_OTHERS = 'create_event_for_others';

    private function __construct() {}
}
