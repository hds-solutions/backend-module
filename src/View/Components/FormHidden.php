<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\View\Component;

class FormHidden extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public ?string $value = 'true',
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render() {
        return view('backend::components.form.hidden');
    }
}
