<?php return [

    'firstname'          => [
        'Firstname',
        '_' => 'Firstname',
        '?' => 'Firstname',
    ],

    'lastname'          => [
        'Lastname',
        '_' => 'Lastname',
        '?' => 'Lastname',
    ],

    'email'             => [
        'Email',
        '_' => 'Email',
        '?' => 'Email',

        'confirm'   => 'Email confirmation',
        'confirm_'  => 'Email confirmation',
    ],

    'password'          => [
        'Password',
        '_' => 'Password',
        '?' => 'Password',

        'confirm'   => 'Password confirmation',
        'confirm_'  => 'Password confirmation',
    ],

    'roles'          => [
        'Roles',
        '_' => 'Roles',
        '?' => 'Roles',
    ] + include('role.php'),

];
