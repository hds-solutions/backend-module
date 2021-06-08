<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class FormMultiple extends Component {

    public Collection $values;
    public Collection $selecteds;

    public function __construct(
        public string $name,
        public string $contentsView,

        array|Collection $values,
        array|Collection $selecteds,

        public ?string $valuesAs = null,
        public ?string $helper = null,
    ) {
        $this->values = $values instanceof Collection ? $values : collect($values);
        $this->selecteds = $selecteds instanceof Collection ? $selecteds : collect($selecteds);
    }

    public function render() {
        return fn($data) => view('backend::components.form.backend.multiple', $data)->render();
    }

}
