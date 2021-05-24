<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Label extends Component {

    public function __construct(
        public string $text,
    ) {}

    public function render() {
        return view('backend::components.form.label');
    }
}
