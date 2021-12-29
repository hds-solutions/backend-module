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

    'has_system_wide_access'    => [
        'Acceso completo al sistema?',
        '_' => 'Si, tiene acceso completo',
        '?' => 'Has SystemWide access helper text',
    ],

    'companies'     => [
        'Compañías',
        '_' => 'Seleccione Compañía',
        '?' => 'Compañías',
    ] + __('backend::company'),

    'roles'          => [
        'Perfiles',
        '_' => 'Seleccionar Perfil',
        '?' => 'Perfiles',
    ] + __('backend::role'),

];
