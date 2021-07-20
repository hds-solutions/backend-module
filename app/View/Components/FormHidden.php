<?php

namespace HDSSolutions\Laravel\View\Components;

use Illuminate\View\Component;

class FormHidden extends Component {

    public function __construct(
        public string $name,
        public ?string $value = 'true',
    ) {}

    public function render() {
        return fn($data) => view('backend::components.form.backend.hidden', $data)->render();
    }

}
