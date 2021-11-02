require('../utils/ready');

class Application {

    constructor() {
        this._classes = {};
        this._instances = {};
        this._callbacks = [];
        this.inited = false;
    }

    init(fn) {
        // check if already inited
        if (this.inited) fn();
        // register callback
        this._callbacks.push( fn );
    }

    _doInit() {
        // execute registered callbacks
        this._callbacks.forEach(callback => callback());
        // empty list
        this._callbacks.empty();
    }

    register(name, _class) {
        this._classes[name] = _class;
    }

    get instances() { return this._instances; }

    instance(name) {
        if (!this.instances[name] && this._classes[name])
            this._instances[name] = new this._classes[name];
        return this.instances[name] ?? null;
    }

    alias(name, instance) {
        this._instances[name] = instance;
    }

    get $() { return this.jQuery; }
    get jQuery() { return this._instances['jQuery'] ?? null; }

}

window.Application = window.Application || new Application;

ready(ready => window.Application._doInit());

export default window.Application;
