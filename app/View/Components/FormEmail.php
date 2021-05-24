<?php

namespace HDSSolutions\Finpar\View\Components;

class FormEmail extends FormText {

    public function render() {
        return view('backend::components.form.backend.text', [ 'type' => 'email' ]);
    }

}
