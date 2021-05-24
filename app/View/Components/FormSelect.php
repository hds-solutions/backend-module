<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class FormSelect extends Select {

    public function __construct(
        string $name,
        array|Collection $values,
        ?string $default = null,

        public ?Model $resource = null,
        public ?string $field = null,
        public ?string $helper = null,
    ) {
        parent::__construct($name, $values, $default);

        $this->field ??= $this->name;
    }

    public function render() {
        return view('backend::components.form.backend.select');
    }

    public function default() {
        // old value > resource.field > default
        return old($this->name, $this->resource?->{$this->field} ?? $this->default);
    }

}
