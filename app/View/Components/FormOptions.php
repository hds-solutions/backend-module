<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class FormOptions extends Component {

    public function __construct(
        public string $name,
        public ?string $field = null,
        public array|Collection $values,
        public $resource = null,
        public string|null $default = null,
        public ?string $label = null,
        public ?string $placeholder = null,
        public ?string $helper = null,
        public bool $required = false,
    ) {
        $this->field ??= $this->name;
        $this->values = $this->values instanceof Collection ? $this->values : collect($this->values);
        $this->default = $this->default === 'null' ? null : $this->default;
    }

    public function render() {
        return fn($data) => view('backend::components.form.options', $data)->render();
    }
}
