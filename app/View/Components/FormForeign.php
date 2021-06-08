<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class FormForeign extends Select {

    public function __construct(
        string $name,
        array|Collection $values,
        ?string $default = null,

        public ?Model $resource = null,
        // protected ?string $field = null,
        public ?string $helper = null,

        // string $foreign,
        // ?string $foreignAddLabel = null,

        // string $show = 'name',

        // ?string $filteredBy = null,
        // ?string $filteredUsing = null,
        // // public bool $dataFilteredKeepId = false,

        // ?string $append = null,
        // ?string $request = null,

        public bool $secondary = false,
    ) {
        parent::__construct(
            $name, $values, $default,
            // $resource, $field, $helper,
            // $foreign, $foreignAddLabel,
            // $show,
            // $filteredBy, $filteredUsing,
            // $append, $request
        );
    }

    public function render() {
        return fn($data) => view('backend::components.form.backend.foreign', $data)->render();
    }

}
