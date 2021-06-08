<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Row extends Component {

    public function __construct(
    ) {}

    public function render() {
        return view('backend::components.form.row');
    }

}
