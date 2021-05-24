<?php

namespace HDSSolutions\Finpar\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Foreign extends Select {

    public array $append = [];

    public function __construct(
        string $name,
        array|Collection $values,
        ?string $default = null,

        private ?Model $resource = null,
        protected ?string $field = null,
        // public ?string $helper = null,

        public string $foreign = '',
        public ?string $foreignAddLabel = null,

        public string $show = 'name',
        public ?string $title = null,

        public ?string $filteredBy = null,
        public ?string $filteredUsing = null,
        // public bool $dataFilteredKeepId = false,

        ?string $append = null,
        private ?string $request = null,
    ) {
        parent::__construct($name, $values, $default);

        // FIXME: data from FormForeign is invalid
        $this->show = $this->show !== '' ? $this->show : 'name';
        $this->filteredBy = $this->filteredBy !== '' ? $this->filteredBy : null;
        $this->filteredUsing = $this->filteredUsing !== '' ? $this->filteredUsing : null;

        if ($append) foreach ($this->append = explode(',', $append) as $idx => $append)
            $this->append[$idx] = explode(':', $append);

        if ($this->filteredBy)
            $this->append[] = [ $this->filteredUsing, $this->filteredUsing.'.id' ];
    }

    public function render() {
        return view('backend::components.form.foreign');
    }

    public function isSelected($resource):bool {
        // old > request > resource > default
        return $resource->getKey() == old($this->name, ($this->request ? request($this->request) : null) ?? $this->resource?->{$this->field} ?? $this->default);
    }

    public function parseShow($resource):string {
        // get matches
        preg_match_all('/(\w|\.)+/', $show = $this->show, $matches);
        // replace matches with resource data
        foreach ($matches[0] as $match) $show = str_replace($match, data_get($resource, $match) ?? $match, $show);
        // return build
        return $show;
    }

}
