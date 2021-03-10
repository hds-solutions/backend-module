<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class FormForeign extends Component {

    public array $append = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $resource,
        public string $name,
        public array|Collection $values,
        public string $foreign,
        public ?string $foreignAddLabel = null,
        public ?string $field = null,
        public ?string $label = null,
        public ?string $placeholder = null,
        public ?string $help = null,
        public bool $required = false,

        public ?string $filteredBy = null,
        public ?string $filteredUsing = null,

        ?string $append = null,
        public ?string $request = null,

        public bool $secondary = false,
    ) {
        $this->field ??= $this->name;
        $this->append = explode(',', $append);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render() {
        return view('backend::components.form.foreign');
    }
}
