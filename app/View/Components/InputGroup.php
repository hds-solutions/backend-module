<?php

namespace HDSSolutions\Laravel\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class InputGroup extends Component {

    public function __construct(
    ) {}

    public function render() {
        return view('backend::components.form.input-group');
    }

}
