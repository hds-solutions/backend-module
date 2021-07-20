<?php

namespace HDSSolutions\Laravel\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class TextArea extends Component {

    public function __construct(
        public string $name,
    ) {}

    public function render() {
        return fn($data) => view('backend::components.form.textarea', $data)->render();
    }

}
