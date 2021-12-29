<?php return [

    'firstname'     => [
        'Firstname',
        '_' => 'Firstname',
        '?' => 'Firstname',
    ],

    'lastname'      => [
        'Lastname',
        '_' => 'Lastname',
        '?' => 'Lastname',
    ],

    'email'         => [
        'Email',
        '_' => 'Email',
        '?' => 'Email',

        'confirm'   => 'Email confirmation',
        'confirm_'  => 'Email confirmation',
    ],

    'password'      => [
        'Password',
        '_' => 'Password',
        '?' => 'Password',

        'confirm'   => 'Password confirmation',
        'confirm_'  => 'Password confirmation',
    ],

    'has_system_wide_access'    => [
        'Has SystemWide access?',
        '_' => 'Yes, has SystemWide access?',
        '?' => 'Has SystemWide access helper text',
    ],

    'companies'     => [
        'Companies',
        '_' => 'Select Company',
        '?' => 'Companies',
    ] + __('backend::company'),

    'roles'         => [
        'Roles',
        '_' => 'Select Role',
        '?' => 'Roles',
    ] + __('backend::role'),

];
