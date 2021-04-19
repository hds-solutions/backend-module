<?php

namespace HDSSolutions\Finpar\View\Components;

class FormEmail extends FormText {

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render() {
        return view('backend::components.form.email');
    }
}
