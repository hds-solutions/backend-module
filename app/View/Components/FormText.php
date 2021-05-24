<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class FormText extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
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

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render() {
        return view('backend::components.form.backend.text');
    }
}
