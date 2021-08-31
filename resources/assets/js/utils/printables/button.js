export default class Button {

    #printables;
    #element;

    constructor(printables, ele = null) {
        // save printables parent
        this.#printables = printables;
        // register button element
        this.#element = ele;
        // check if button element exists
        if (this.#element == null) return;

        // init config
        this._init();
    }

    get url() {
        // return button configured route
        return this.#element.getAttribute('data-printable');
    }

    // return auto print config
    get print() { return [ 'true', '' ].includes(this.#element.getAttribute('data-print')); }

    _init() {
        // capture button click
        this.#element.addEventListener('click', e => {
            // prevent default
            e.preventDefault();
            // show modal for this button
            this.#printables._show( this );
        });
    }

}
