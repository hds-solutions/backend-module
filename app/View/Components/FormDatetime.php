<?php

namespace HDSSolutions\Laravel\View\Components;

class FormDatetime extends FormText {

    public function render() {
        return fn($data) => view('backend::components.form.backend.datetime', $data)->render();
    }

}
