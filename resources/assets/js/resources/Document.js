import Event from '../utils/consoleevent';

export default class Document {

    static events = {};

    #token = document.querySelector('[name="csrf-token"]').getAttribute('content');
    #lines = {};

    constructor() {
        if (this.constructor == Document) throw new Error("Abstract classes can't be instantiated.");
    }

    get token() { return this.#token; }

    get lines() {
        let lines = [];
        // convert Object to Array
        Object.keys(this.#lines).forEach(key => lines.push(this.#lines[key]));
        return lines;
    }

    static fire(event, element) {
        // create event if not exists
        if (this.events[event] === undefined) this.events[event] = new Event(event);
        // fire event on element
        this.events[event].fire( element );
    }

    multiple(multiple) {
        this.multiple = multiple;
    }

    register(container) {
        // get container instance
        let instance = this._getContainerInstance(container);
        // register instance
        this.#lines[instance.id] = instance;
    }

    unregister(container) {
        // get container instance
        let instance = this.#lines[container.id];
        // remove container from list
        delete this.#lines[instance.id];
        // fire destructor
        instance._destructor();
    }

    _getContainerInstance(container) {
        throw new Error('Method _getContainerInstance(container) must be implemented');
    }

    undecimalize(amount, decimals = 0) {
        // parse amount and return it without decimals
        return parseInt(amount.replace(/[^0-9\.]/g,'') * Math.pow(10, decimals));
    }

    decimalize(amount, decimals = 0) {
        // return amount with decimals
        return amount / Math.pow(10, decimals);
    }

}
