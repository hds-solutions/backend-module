<?php

namespace HDSSolutions\Laravel\Traits;

use Illuminate\Database\Eloquent\Concerns\HasEvents;

trait HasAfterSave {
    // use HasEvents;

    public static function bootHasAfterSave() {
        // capture saved
        self::saved(function($model) {
            // execute afterSave
            $model->afterSave();
        });
    }

    /**
     * Custom validations afterSave
     */
    protected function afterSave() {}
}
