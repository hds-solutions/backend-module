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

}

window.Application = window.Application || new Application;

export default window.Application;
