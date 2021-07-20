<?php

namespace HDSSolutions\Laravel\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class FormText extends Component {

    public function __construct(
        public string $name,

        public ?Model $resource = null,
        public ?string $default = null,
        public ?string $field = null,
        public ?string $helper = null,
        public bool $fullWidth = false,
    ) {
        $this->field ??= $this->name;
    }

    public function render() {
        return fn($data) => view('backend::components.form.backend.text', $data)->render();
    }
}
