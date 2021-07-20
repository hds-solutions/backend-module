<?php

namespace HDSSolutions\Laravel\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Input extends Component {

    public function __construct(
        public string $name,
    ) {}

    public function render() {
        return fn($data) => view('backend::components.form.input', $data)->render();
    }

}
