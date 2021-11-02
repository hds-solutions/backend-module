<?php

namespace HDSSolutions\Laravel\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Multiple extends Component {

    public Collection $values;
    public Collection $extra;
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
        public bool|string $autoAddLines = true,
    ) {
        $this->values = $values instanceof Collection ? $values : collect($values);
        $this->extra = $extra instanceof Collection ? $extra : collect($extra);
        $this->selecteds = $selecteds instanceof Collection ? $selecteds : collect($selecteds);
        $this->autoAddLines = filter_var($this->autoAddLines, FILTER_VALIDATE_BOOLEAN);
    }

    public function render() {
        return fn($data) => view('backend::components.form.multiple', $data + [
            'cardFooter'    => $data['card-footer'] ?? null
        ])->render();
    }

}
