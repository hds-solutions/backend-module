<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component {

    public Collection $values;

    public function __construct(
        public string $name,
        array|Collection $values,
        protected ?string $default = null,
    ) {
        $this->values = $values instanceof Collection ? $values : collect($values);
        $this->default = $default === 'null' ? null : $default;
    }

    public function render() {
        return view('backend::components.form.select');
    }

    public function isSelected($idx):bool {
        return $idx == $this->default;
    }

}
