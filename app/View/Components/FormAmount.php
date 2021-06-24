<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class FormAmount extends Component {

    public function __construct(
        public string $name,

        public ?Model $resource = null,
        public ?string $field = null,
        public ?string $helper = null,
        public ?string $default = null,

        public ?string $currency = null,

        public bool $secondary = false,
        // public bool $dataKeepId = false,
    ) {
        $this->field ??= $this->name;
    }

    public function render() {
        return fn($data) => view('backend::components.form.backend.amount', $data)->render();
    }
}
