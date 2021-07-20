<?php

namespace HDSSolutions\Laravel\View\Components;

use Illuminate\View\Component;

class FormCoords extends Component {

    public function __construct(
        public $resource,
        // public string $name,
        // public ?string $field = null,
        // public ?string $label = null,
        // public ?string $prepend = null,
        public ?string $placeholder = null,
        public ?string $helper = null,
        public bool $required = false,
        // public bool $fullWidth = false,
    ) {
        // $this->field ??= $this->name;
    }

    public function render() {
        return fn($data) => view('backend::components.form.coords', $data)->render();
    }
}
