<?php

namespace HDSSolutions\Laravel\DataTables\Base;

use Illuminate\Database\Eloquent\Builder;

interface DataTableContract {

    public function dataTable($query);

    public function query():Builder;

}
