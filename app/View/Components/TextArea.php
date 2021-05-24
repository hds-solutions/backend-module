<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class TextArea extends Component {

    public function __construct(
        public string $name,
    ) {}

    public function render() {
        return view('backend::components.form.textarea');
    }
}
