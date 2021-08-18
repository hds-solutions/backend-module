<?php

namespace HDSSolutions\Laravel\Models\Base;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

use HDSSolutions\Laravel\Traits\HasAfterSave;
use HDSSolutions\Laravel\Traits\HasValidationRules;
use HDSSolutions\Laravel\Traits\Sortable;
// use HDSSolutions\Laravel\DynamoDB\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships as HasExtendedRelationships;
// use HDSSolutions\Laravel\Traits\HasBelongsToManyThrough;


// abstract class Model extends \HDSSolutions\Laravel\DynamoDB\Eloquent\Model {
abstract class Model extends \Illuminate\Database\Eloquent\Model {
    use EagerLoadPivotTrait;
    use HasExtendedRelationships;
    // use HasBelongsToManyThrough;

    use HasValidationRules;
    use HasAfterSave;
    use SoftDeletes;
    use Sortable;

    public final function scopeCreatedAgo(Builder $query, int $days) {
        // return orders from XX days old
        return $query->where('created_at', '<=', today()->subDays( $days )->toDateString());
    }

}
