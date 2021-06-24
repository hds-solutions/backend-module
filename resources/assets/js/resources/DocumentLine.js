import uuid from 'uuid/v4';

export default class DocumentLine {

    #document;
    #container;
    #listeners = {
        updated: event => {},
    };

    constructor(document, container) {
        if (this.constructor == DocumentLine) throw new Error("Abstract classes can't be instantiated.");
        this.#document = document;
        this.#container = container;
        this.#container.id = uuid();
    }

    destructor() {}

    get document() { return this.#document; }
    get id() { return this.container.id; }
    get container() { return this.#container; }

    _init() {
    }

    updated(event) {
        // register updated function
        this.#listeners.updated = typeof event == 'function' ? event : this.#listeners.updated;
        // redirect event to registered function
        if (typeof event === 'object') this.#listeners.updated( event );
        // return object to allow chaining
        return this;
    }

    fire(event, element) {
        // redirect event to POS.fire
        this.document.fire(event, element);
    }

}
