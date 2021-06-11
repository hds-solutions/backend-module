<?php

namespace HDSSolutions\Finpar\View\Components;

class FormTime extends FormText {

    public function render() {
        return fn($data) => view('backend::components.form.backend.time', $data)->render();
    }

}
