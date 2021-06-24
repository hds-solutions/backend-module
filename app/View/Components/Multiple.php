<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Multiple extends Component {

    public Collection $values;
    public Collection $selecteds;

    public function __construct(
        public string $name,
        public string $contentsView,

        array|Collection $values,
        array|Collection $selecteds,
        array|Collection $extra = [],

        public ?string $valuesAs = null,
        public ?string $extraAs = null,
        public ?string $helper = null,

        public ?string $card = null,
    ) {
        $this->values = $values instanceof Collection ? $values : collect($values);
        $this->selecteds = $selecteds instanceof Collection ? $selecteds : collect($selecteds);
    }

    public function render() {
        return fn($data) => view('backend::components.form.multiple', $data + [
            'cardFooter'    => $data['card-footer'] ?? null
        ])->render();
    }

}
