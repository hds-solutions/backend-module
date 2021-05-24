<?php

namespace HDSSolutions\Finpar\View\Components;

class FormDate extends FormText {

    public function render() {
        return view('backend::components.form.backend.text', [ 'type' => 'date' ]);
    }

}
