class Application {

    constructor() {
        this._classes = {};
        this._instances = {};
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

export default window.Application;
