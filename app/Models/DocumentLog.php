<?php

namespace HDSSolutions\Laravel\Models;

class DocumentLog extends X_DocumentLog {

    public function documentable() {
        return $this->morphTo(type: 'document_loggable_type', id: 'document_loggable_id');
    }

}
