<?php

namespace HDSSolutions\Laravel\View\Components;

use Illuminate\View\Component;

class Boolean extends Component {

    public function __construct(
        public string $name,
    ) {}

    public function render() {
        return fn($data) => view('backend::components.form.boolean', $data)->render();
    }
}
