<?php

namespace HDSSolutions\Laravel\View\Components;

class FormEmail extends FormText {

    public function render() {
        return fn($data) => view('backend::components.form.backend.text', $data + [ 'type' => 'email' ])->render();
    }

}
