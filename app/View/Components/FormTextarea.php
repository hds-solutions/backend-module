<?php

namespace HDSSolutions\Laravel\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class FormTextarea extends Component {

    public function __construct(
        public string $name,

        public ?Model $resource = null,
        public ?string $field = null,
        public ?string $helper = null,
    ) {
        $this->field ??= $this->name;
    }

    public function render() {
        return fn($data) => view('backend::components.form.backend.textarea', $data)->render();
    }
}
