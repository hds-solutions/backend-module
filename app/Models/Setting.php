<?php

namespace HDSSolutions\Finpar\Models;

class Setting extends X_Setting {

    public static function forName(string $name) {
        //
        return self::where('name', $name)->first() ?? new self;
    }

}
