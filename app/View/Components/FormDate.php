<?php

namespace HDSSolutions\Laravel\View\Components;

class FormDate extends FormText {

    public function render() {
        return fn($data) => view('backend::components.form.backend.date', $data)->render();
    }

}
