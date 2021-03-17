<?php

namespace HDSSolutions\Finpar\Models;

class City extends X_City {

    public function region() {
        return $this->belongsTo(Region::class);
    }

}
