<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class FormSelect extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public ?string $field = null,
        public array|Collection $values,
        public $resource = null,
        public ?string $default = null,
        public ?string $label = null,
        public ?string $placeholder = null,
        public ?string $helper = null,
        public bool $required = false,
    ) {
        $this->field ??= $this->name;
        $this->values = $this->values instanceof Collection ? $this->values : collect($this->values);
        $this->default = $this->default === 'null' ? null : $this->default;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render() {
        return view('backend::components.form.select');
    }
}
