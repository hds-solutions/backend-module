import Modal from './modal';
import Button from './button';

export default class Printables {

    #modal;
    #buttons = [];
    #active;

    constructor() {
        // get modal instance
        this.#modal = new Modal;
        // register an empty button as active
        this.#active = new Button(this);
        // register modal events
        this._init();
    }

    _init() {
        // capture modal events
        this.#modal.show(e => {
            // set route on modal
            this.#modal.url = this.#active.url;
        });
        this.#modal.loaded(e => {
            // check if button is configured to auto-print
            if (this.#active.print)
                // fire print event on modal
                this.#modal.print();
        });
        this.#modal.hide(e => {
            //
        });
    }

    register(ele) {
        // register button as posible trigger
        this.#buttons.push(new Button(this, ele));
    }

    _show(button) {
        // save active button
        this.#active = button;
        // show modal
        this.#modal.show();
    }

}
