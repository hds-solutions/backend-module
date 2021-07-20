<?php

namespace HDSSolutions\Laravel\Models\Base;

use HDSSolutions\Laravel\Traits\HasValidationRules;
use HDSSolutions\Laravel\Traits\Sortable;
// use HDSSolutions\Laravel\DynamoDB\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

// abstract class Model extends \HDSSolutions\Laravel\DynamoDB\Eloquent\Model {
abstract class Pivot extends \Illuminate\Database\Eloquent\Model {
    use HasValidationRules;
    use Sortable;
    use AsPivot;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
