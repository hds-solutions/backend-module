<?php

namespace HDSSolutions\Finpar\Models;

abstract class X_DocumentLog extends Base\Model {

    protected $sortBy = [
        'created_at'    => 'DESC',
    ];

    protected $fillable = [
        'action',
        'from_status',
        'to_status',
        'message',
        'createdby',
        'updatedby',
    ];

}
