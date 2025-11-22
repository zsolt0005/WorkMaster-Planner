<?php declare(strict_types=1);

return [
    'title' => 'Profile',
    'heading' => [
        'view' => 'Profile',
        'edit' => 'Edit profile',
    ],
    'form' => [
        'email' => 'Email',
        'username' => 'Username',
        'full_name' => 'Full name',
        'roles' => 'Assigned roles',
        'current_password' => 'Current password',
        'password' => 'New password',
        'password_confirmation' => 'Confirm password',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'edit' => 'Edit profile',
        'change_password_title' => 'Change your current password',
        'profile_data_title' => 'Profile information',
    ],
    'errors' => [
        'current_password' => 'The current password is incorrect.',
        'password_confirmation' => 'Password confirmation does not match.',
        'not_your_profile' => 'You are trying to edit another user\'s profile.',
        'update_failed' => 'Something went wrong while updating profile.',
    ],
    'success' => [
        'updated' => 'Profile has been updated.',
    ],
];
