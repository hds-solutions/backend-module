<?php

namespace HDSSolutions\Laravel\View\Components;

use Illuminate\View\Component;

class Datetime extends Component {

    public function __construct(
        public string $name,
    ) {}

    public function render() {
        return fn($data) => view('backend::components.form.date', $data + [ 'type' => 'datetime' ])->render();
    }
}
