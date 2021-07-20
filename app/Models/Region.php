<?php

namespace HDSSolutions\Laravel\Models;

class Region extends X_Region {

    public function cities() {
        return $this->hasMany(City::class);
    }

}
