<?php

namespace HDSSolutions\Finpar\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Sortable {

    // protected $orderBy;
    // protected $orderDirection = 'ASC';

    public function scopeOrdered(Builder $query, $orderBy = null, string $orderDirection = null) {
        // return ordered
        if (!$this->orderBy && !$orderBy) return $query;
        // check for multiple columns
        if (gettype($orderBy ?? $this->orderBy) == 'array')
            // foreach
            foreach (($orderBy ?? $this->orderBy) as $column => $direction) {
                // check if key is column name
                $column = gettype($column) == 'string' ? $column : $direction;
                // set default order if not specified
                $direction = in_array( strtoupper($direction), [ 'ASC', 'DESC' ]) ? strtoupper($direction) : 'ASC';
                // add order by column
                $query->orderBy($column, $direction);
            }
        else
            // order by single column
            $query->orderBy( $orderBy ?? $this->orderBy, $orderDirection ?? $this->orderDirection ?? 'ASC' );
        // return sorted query
        return $query;
    }

}
