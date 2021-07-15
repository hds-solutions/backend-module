<?php

namespace HDSSolutions\Finpar\Models\Base;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

use HDSSolutions\Finpar\Traits\HasAfterSave;
use HDSSolutions\Finpar\Traits\HasValidationRules;
use HDSSolutions\Finpar\Traits\Sortable;
// use HDSSolutions\Laravel\DynamoDB\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships as HasExtendedRelationships;

// abstract class Model extends \HDSSolutions\Laravel\DynamoDB\Eloquent\Model {
abstract class Model extends \Illuminate\Database\Eloquent\Model {
    use EagerLoadPivotTrait;
    use HasExtendedRelationships;

    use HasValidationRules;
    use HasAfterSave;
    use SoftDeletes;
    use Sortable;

    public final function scopeCreatedAgo(Builder $query, int $days) {
        // return orders from XX days old
        return $query->where('created_at', '<=', today()->subDays( $days )->toDateString());
    }

}
