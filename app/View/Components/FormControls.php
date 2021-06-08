<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\View\Component;

class FormControls extends Component {

    public function __construct(
        public ?string $submit = null,
        public ?string $cancel = null,
        public ?string $cancelRoute = null,
        public array $cancelRouteParams = [],
    ) {
        $routeParams = explode(':', $this->cancelRoute);
        $this->cancelRoute = array_shift($routeParams);
        $this->cancelRouteParams = $routeParams;
    }

    public function render() {
        return fn($data) => view('backend::components.form.controls', $data)->render();
    }
}
