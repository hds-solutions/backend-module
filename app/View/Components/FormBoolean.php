<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class FormBoolean extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,

        public ?Model $resource = null,
        public ?string $field = null,
        public ?string $helper = null,
    ) {
        $this->field ??= $this->name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render() {
        return function($data) {
            // dump($data);
            return view('backend::components.form.backend.boolean', $data)->render();
        };
    }
}
