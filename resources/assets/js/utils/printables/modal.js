const modal = window.printablesModal || '.modal#printables-modal';

export default class Modal {

    #element;
    #iframe;
    #fn = {
        show: e => {},
        loaded: e => {},
        hide: e => {},
        hidden: e => {},
    };

    constructor() {
        // load modal
        this.#element = document.querySelector(modal);
        // check if modal exists
        if (!this.#element) return;
        // get modal igrame
        this.#iframe = this.#element.querySelector('iframe');
        // init events
        this._init();
    }

    set url(url) {
        // set url on iframe
        this.#iframe.src = url;
    }

    _init() {
        // capture modal events and redirect to registered functions
        $(this.#element).on('show.bs.modal', e => this.show(e));
        $(this.#element).on('hide.bs.modal', e => this.hide(e));
        $(this.#element).on('hidden.bs.modal', e => this.hidden(e));
        // capture iframe loaded and redirect to registered function
        this.#iframe.addEventListener('load', e => this.loaded(e));
    }

    show(event = true) {
        if (typeof event == 'function') {
            // register event function
            this.#fn.show = event;
            // return object to allow chaining
            return this;
        }

        // redirect to jQuery modal
        if (event === true) return $(this.#element).modal('show');

        // execute registered function for event
        this.#fn.show( event );
    }

    loaded(event = true) {
        if (typeof event == 'function') {
            // register event function
            this.#fn.loaded = event;
            // return object to allow chaining
            return this;
        }

        // check if iframe has src
        if (!this.#iframe.src.length) return;

        // execute registered function for event
        this.#fn.loaded( event );
    }

    print(event = true) {
        // fire print event on iframe window
        this.#iframe.contentWindow.print();
    }

    hide(event = true) {
        if (typeof event == 'function') {
            // register event function
            this.#fn.hide = event;
            // return object to allow chaining
            return this;
        }

        // redirect to jQuery modal
        if (event === true) return $(this.#element).modal('hide');

        // execute registered function for event
        this.#fn.hide( event );
    }

    hidden(event = true) {
        if (typeof event == 'function') {
            // register event function
            this.#fn.hidden = event;
            // return object to allow chaining
            return this;
        }

        // execute registered function for event
        this.#fn.hidden( event );

        // reset modal src
        this.#iframe.removeAttribute('src');
    }

}
