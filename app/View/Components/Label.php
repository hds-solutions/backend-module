<?php

namespace HDSSolutions\Laravel\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Label extends Component {

    public function __construct(
        public string $text,
    ) {}

    public function render() {
        return fn($data) => view('backend::components.form.label', $data)->render();
    }

}
