<?php

namespace HDSSolutions\Finpar\Models;

abstract class X_DocumentLog extends Base\Model {

    protected $sortBy = [
        'created_at'    => 'DESC',
    ];

    protected $fillable = [
        'from_status',
        'to_status',
        'createdby',
        'updatedby',
    ];

}
