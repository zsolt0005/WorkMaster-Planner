<?php declare(strict_types=1);

return [
    'context_menu' => [
        'actions' => 'Actions',
        'other' => 'Other',

        'create_event' => 'Create event',
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
        'cant_create_event_for_other_user' => ' You have no permission to create events for other users.',
    ],
];
