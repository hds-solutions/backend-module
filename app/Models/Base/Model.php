<?php

namespace HDSSolutions\Finpar\Models\Base;

use HDSSolutions\Finpar\Traits\HasAfterSave;
use HDSSolutions\Finpar\Traits\HasValidationRules;
use HDSSolutions\Finpar\Traits\Sortable;
// use HDSSolutions\Laravel\DynamoDB\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;

// abstract class Model extends \HDSSolutions\Laravel\DynamoDB\Eloquent\Model {
abstract class Model extends \Illuminate\Database\Eloquent\Model {
    use HasValidationRules;
    use HasAfterSave;
    use SoftDeletes;
    use Sortable;
}
