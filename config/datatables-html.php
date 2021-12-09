<?php

return [
    /*
     * DataTables JavaScript global namespace.
     */

    'namespace' => 'LaravelDataTables',

    /*
     * Default table attributes when generating the table.
     */
    'table' => [
        'class' => 'table table-sm table-bordered table-striped table-hover',
        'id'    => 'dataTableBuilder',
    ],

    /*
     * Default condition to determine if a parameter is a callback or not.
     * Callbacks needs to start by those terms or they will be casted to string.
     */
    'callback' => ['$', '$.', 'function'],

    /*
     * Html builder script template.
     */
    'script' => 'backend::datatables.script',

    /*
     * Html builder script template for DataTables Editor integration.
     */
    'editor' => 'backend::datatables.editor',
];
