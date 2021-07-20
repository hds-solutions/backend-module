<?php

namespace HDSSolutions\Laravel\Models;

class City extends X_City {

    public function region() {
        return $this->belongsTo(Region::class);
    }

}
