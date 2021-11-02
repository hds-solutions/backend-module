<?php return [

    'firstname'          => [
        'Nombre',
        '_' => 'Nombre',
        '?' => 'Nombre',
    ],

    'lastname'          => [
        'Apellido',
        '_' => 'Apellido',
        '?' => 'Apellido',
    ],

    'email'             => [
        'Email',
        '_' => 'Email',
        '?' => 'Email',

        'confirm'   => 'Confirmación de Email',
        'confirm_'  => 'Confirmación de Email',
    ],

    'password'          => [
        'Contraseña',
        '_' => 'Contraseña',
        '?' => 'Contraseña',

        'confirm'   => 'Confirmacion de Contraseña',
        'confirm_'  => 'Confirmacion de Contraseña',
    ],

    'roles'          => [
        'Perfiles',
        '_' => 'Perfiles',
        '?' => 'Perfiles',
    ] + include('role.php'),

];
