<?php

namespace HDSSolutions\Finpar\View\Components;

class FormNumber extends FormText {

    public function render() {
        return view('backend::components.form.backend.text', [ 'type' => 'number' ]);
    }

}
