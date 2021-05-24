import Event from './consoleevent';

export default class Only {

    constructor(element, parent = null) {
        // save element
        this.element = element;
        // save parent
        this.parent = parent ?? document.body;
        // save original display classes
        this.display = [];
        this.element.classList.forEach(className => className.match(/^d-/) ? this.display.push(className) : null);
        // only when params matches
        this.only = [];
        // parse data-only
        this._parse();
        // init
        this._init();
    }

    _parse() {
        // foreach fields
        this.element.dataset.only.split('&').forEach((fieldValuePair, idx) => {
            // create container
            let only = {
                field: null,
                modifier: null,
                values: null,
            };
            // find paid modified
            if (fieldValuePair.match(/\=/)) only.modifier = '=';
            if (fieldValuePair.match(/\</)) only.modifier = '<';
            if (fieldValuePair.match(/\<\=/)) only.modifier = '<=';
            if (fieldValuePair.match(/\>/)) only.modifier = '>';
            if (fieldValuePair.match(/\>\=/)) only.modifier = '>=';
            // separate field and value
            let pair = fieldValuePair.split( only.modifier );
            // save field and value
            only.field = pair[0];
            only.values = pair[1].split('|');
            // add to global config
            this.only.push( only );
        });
    }

    _init() {
        // capture change on each only.field
        this.only.forEach(only => {
            // get only.field
            let source = this.parent.querySelector('[name="'+only.field+'"]');
            // capture change on only.field and redirect it
            source.addEventListener('change', e => this._change(only, source));
            // fire change for first time update
            this._change(only, source);
        });
    }

    _change(only, source) {
        // remove display classes
        this.display.forEach(className => this.element.classList.remove(className))
        // hide by default
        this.element.classList.add('d-none');
        // get current value
        let value = source.value !== null ? source.value.trim() : null;
        // check modifier
        if (
            // equals
            (only.modifier == '=' && only.values.indexOf(value) != -1) ||
            // lt
            (only.modifier == '<' && value < only.values[0]) ||
            (only.modifier == '<=' && value <= only.values[0]) ||
            // gt
            (only.modifier == '>' && value > only.values[0]) ||
            (only.modifier == '>=' && value >= only.values[0])) {
            // show element
            this.element.classList.remove('d-none');
            // append original class names
            this.display.forEach(className => { this.element.classList.add(className); });
        }
    }

}
