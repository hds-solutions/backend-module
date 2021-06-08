<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class FormImage extends Component {

    public function __construct(
        public string $name,

        public ?Model $resource = null,
        public ?string $field = null,
        public array|Collection $images,
        public ?string $default = null,
        public ?string $label = null,
        public ?string $placeholder = null,
        public ?string $helper = null,
        public bool $required = false,
        public bool $multiple = false,

        public ?string $filteredBy = null,
        public ?string $filteredUsing = null,
    ) {
        $this->field ??= $this->name;
    }

    public function render() {
        return fn($data) => view('backend::components.form.backend.image', $data)->render();
    }

}
