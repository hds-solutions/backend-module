import uuid from 'uuid/v4';

export default class DocumentLine {

    #document;
    #container;
    #fields = [];
    #listeners = {
        updated: [],
        removed: [],
    };

    constructor(document, container) {
        if (this.constructor == DocumentLine) throw new Error("Abstract classes can't be instantiated.");
        this.#document = document;
        this.#container = container;
        this.#container.id = uuid();
        this.#fields.push(...this.container.querySelectorAll('input,select,textarea'));
        this.#init();
    }

    get id() { return this.container.id; }
    get document() { return this.#document; }
    get container() { return this.#container; }

    _destructor() {
        // execute custom desctructor
        this.destructor();
        // fire removed event on registred listeners
        this.#listeners.removed.forEach(listener => listener({ target: this.container }));
    }
    destructor() {}

    #init() {
        // capture changes on fields
        this.#fields.forEach(field => field.addEventListener('change', e => {
            // ignore if field doesn't have form (deleted line)
            if (field.form === null) return;

            // redirect event to listeners
            this.updated(e);
        }));
    }

    updated(event) {
        // register updated function to listeners
        if (typeof event == 'function') this.#listeners.updated.push( event );
        // redirect event to registred listeners
        if (typeof event === 'object') this.#listeners.updated.forEach(listener => listener( event ));
        // return object to allow chaining
        return this;
    }

    removed(event) {
        // register removed function to listeners
        if (typeof event == 'function') this.#listeners.removed.push( event );
        // redirect event to registred listeners
        if (typeof event === 'object') this.#listeners.removed.forEach(listener => listener( event ));
        // return object to allow chaining
        return this;
    }

    fire(event, element) {
        // redirect event to POS.fire
        this.document.fire(event, element);
    }

    undecimalize(amount, decimals = 0) {
        // parse amount and return it without decimals
        return this.document.undecimalize(amount, decimals);
    }

    decimalize(amount, decimals = 0) {
        // return amount with decimals
        return this.document.decimalize(amount, decimals);
    }

}
