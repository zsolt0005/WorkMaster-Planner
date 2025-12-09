<?php declare(strict_types=1);

return [
    'context_menu' => [
        'actions' => 'Actions',
        'other' => 'Other',

        'create_event' => 'Create event',
        'view_details' => 'View details',
        'delete_event' => 'Delete event',
        'refresh' => 'Refresh',
    ],

    'create_event' => [
        'header' => 'Create event',
        'event_title' => 'Details',
        'title' => 'Title',
        'title_placeholder' => 'Meeting, Workshop, ...',
        'event_type' => 'Event type',
        'event_type_placeholder' => 'Select',
        'assigned_user' => 'Assigned user',
        'assigned_user_placeholder' => 'Select',
        'description' => 'Description (optional)',
        'description_placeholder' => 'Daily meeting, ...',
        'event_period_title' => 'Period',
        'start_date_time' => 'Start',
        'end_date_time' => 'End',
        'success' => 'Event created successfully.',
        'failed' => 'Something went wrong while creating event.',
        'cant_create_event' => 'You have no permission to create events.',
        'cant_create_event_for_other_user' => 'You have no permission to create events for other users.',
    ],

    'delete_event' => [
        'header' => 'Delete event',
        'confirm' => 'Are you sure you want to delete this event?',
        'event_doesnt_exists' => 'The event you are trying to delete doesn\'t exist.',
        'cant_delete_event' => 'You have no permission to delete events.',
        'cant_delete_event_for_other_user' => 'You have no permission to delete events for other users.',
        'success' => 'Event deleted successfully.',
        'failed' => 'Something went wrong while deleting event.',
    ],

    'event_details' => [
        'header' => 'Event details',
        'title' => 'Title',
        'event_type' => 'Event type',
        'assigned_user' => 'Assigned user',
        'created_by' => 'Created by',
        'description' => 'Description (optional)',
        'event_period_title' => 'Period',
        'start_date_time' => 'Start',
        'end_date_time' => 'End',
        'edit_button' => 'Edit',
        'close_button' => 'Close',
    ],

    'edit_event' => [
        'header' => 'Edit event',
        'title' => 'Title',
        'event_type' => 'Event type',
        'assigned_user' => 'Assigned user',
        'description' => 'Description (optional)',
        'event_period_title' => 'Period',
        'start_date_time' => 'Start',
        'end_date_time' => 'End',
        'save_button' => 'Save',
        'cancel_button' => 'Cancel',
        'cant_edit_event' => 'You have no permission to edit events.',
        'event_doesnt_exists' => 'The event you are trying to edit does not exists.',
        'cant_edit_event_for_other_user' => 'You have no permission to edit events for other users.',
        'success' => 'Event updated successfully.',
        'failed' => 'Something went wrong while editing event.',
    ],

    'event_type' => 'Event type',
    'user' => 'User / Name',
    'type_to_search' => 'Type to search...',
];
