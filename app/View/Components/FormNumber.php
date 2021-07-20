<?php

namespace HDSSolutions\Laravel\View\Components;

class FormNumber extends FormText {

    public function render() {
        return fn($data) => view('backend::components.form.backend.text', $data + [ 'type' => 'number' ])->render();
    }

}
