<?php

return [

    'models' => [

        'permission' => Spatie\Permission\Models\Permission::class,

        'role' => HDSSolutions\Laravel\Models\Role::class,

    ],

    /*
     * Enable wildcard permission lookups.
     */
    'enable_wildcard_permission' => true,

    'cache' => [

        /*
         * You may optionally indicate a specific cache driver to use for permission and
         * role caching using any of the `store` drivers listed in the cache.php config
         * file. Using 'default' here means to use the `default` set in cache.php.
         */
        'store' => 'array',

    ],

];
