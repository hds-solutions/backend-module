<?php

namespace HDSSolutions\Laravel\Models;

class Branch extends X_Branch {

    public function region() {
        return $this->belongsTo(Region::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function warehouses() {
        return $this->hasMany(Warehouse::class);
    }

    public function scopeWithPhone(Builder $query) {
        return $query->whereNotNull('phone');
    }

}
