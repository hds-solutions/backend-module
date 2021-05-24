<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\View\Component;

class Amount extends Component {

    public function __construct(
        public string $name,
    ) {}

    public function render() {
        return view('backend::components.form.amount');
    }
}
