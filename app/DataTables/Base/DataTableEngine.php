<?php

namespace HDSSolutions\Laravel\DataTables\Base;

use Yajra\DataTables\EloquentDataTable;

class DataTableEngine extends EloquentDataTable {

    private $callback = null;

    public function results() {
        $results = $this->query->get();
        if ($this->callback !== null) $results = call_user_func_array($this->callback, [ $results ]);
        return $results;
    }

    public function resultsCallback(Callable $callable) {
        $this->callback = $callable;
    }

}
