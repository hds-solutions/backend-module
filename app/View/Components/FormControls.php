<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\View\Component;

class FormControls extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
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

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render() {
        return view('backend::components.form.controls');
    }
}
