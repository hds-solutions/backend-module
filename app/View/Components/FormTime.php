<?php

namespace HDSSolutions\Finpar\View\Components;

class FormDate extends FormText {

    public function render() {
        return fn($data) => view('backend::components.form.backend.time', $data)->render();
    }

}
