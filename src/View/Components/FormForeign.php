<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class FormForeign extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $resource,
        public string $name,
        public ?string $field = null,
        public array|Collection $values,
        public ?string $label = null,
        public ?string $placeholder = null,
        public ?string $helper = null,
        public bool $required = false,
    ) {
        $this->field ??= $this->name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render() {
        return view('backend::components.form.foreign');
    }
}
