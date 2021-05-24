<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\View\Component;

class Boolean extends Component {

    public function __construct(
        public string $name,
    ) {}

    public function render() {
        return view('backend::components.form.boolean');
    }
}
