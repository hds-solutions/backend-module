import Application from '../resources/Application';

const modal = window.alertModal || '.modal#alert-modal';

class Alert {

    #modal;
    #active = false;

    constructor() {
        Application.init(e => {
            // get modal instance
            this.#modal = new Modal;

            // capture modal hide
            this.#modal.hide(e => {
                // resolve promise
                if (this.#active) this.#active(e);
                // reset active
                this.#active = false;
            });
        });
    }

    error(title, message = null) { return this.danger(title, message); }

    primary(title, message = null) { return this.#type('primary', title, message); }
    secondary(title, message = null) { return this.#type('secondary', title, message); }
    success(title, message = null) { return this.#type('success', title, message); }
    danger(title, message = null) { return this.#type('danger', title, message); }
    warning(title, message = null) { return this.#type('warning', title, message); }
    info(title, message = null) { return this.#type('info', title, message); }
    dark(title, message = null) { return this.#type('dark', title, message); }
    #type(type, title, message = null) {
        return this.show({
            type: type,
            title: message !== null ? title : null,
            body: message !== null ? message : title
        });
    }

    show(title = {}, message = null) {
        // execute modal inside a promisse
        return new Promise((resolve, reject) => {
            this.#active = resolve;
            title = typeof title === 'object' && title !== null ? title : (
                message === null ? { body: title } : { title: title, body: message });

            // configure modal for button
            this.#modal.configure( title );
            // show modal
            this.#modal.show();
        });
    }

}

class Modal {

    #element;
    #modal = {
        title: null,
        body: null,
        type: null,
        text: null,
    };
    #buttons = {
        accept: {
            element: null,
            classes: [],
            text: null,
        },
    };
    #fn = {
        show: e => {},
        hide: e => {},
    };

    constructor() {
        // load modal
        this.#element = document.querySelector(modal);
        // check if modal exists
        if (!this.#element) return;
        // save default text content
        this.#modal.title = this.#element.querySelector('.modal-title').textContent;
        this.#modal.body = this.#element.querySelector('.modal-body>p').textContent;
        this.#modal.type = Array.from(this.#element.querySelector('.modal-content').classList.values())
            .filter(class_name => class_name.match(/^border-left-/)).shift().replace('border-left-', '');
        this.#modal.text = Array.from(this.#element.querySelector('.modal-body>p').classList.values())
            .filter(class_name => class_name.match(/^text-/)).shift().replace('text-', '');
        // get accept button
        [ 'accept' ].forEach(button => {
            // register button element
            this.#buttons[button].element = this.#element.querySelector('#'+button);
            // save original classlist
            this.#buttons[button].classes = Array.from(this.#buttons[button].element.classList.values());
            // save original text
            this.#buttons[button].text = this.#buttons[button].element.textContent;
        });
        // init events
        this.#init();
    }

    #init() {
        // capture modal events and redirect to registered functions
        Application.$(this.#element).on('show.bs.modal', e => this.show(e));
        Application.$(this.#element).on('hide.bs.modal', e => this.hide(e));
        // capture modal hiden event
        Application.$(this.#element).on('hidden.bs.modal', e => {
            // reset modal to original state
            this.configure({
                title: this.#modal.title,
                body: this.#modal.body,
                type: this.#modal.type,
                text: this.#modal.text,
                accept: {
                    text: this.#buttons.accept.text,
                    classes: this.#buttons.accept.classes,
                },
            }, true);
        });
    }

    configure(settings, reset = false) {
        // reset modal type
        this.#element.querySelector('.modal-content').classList.forEach(class_name => class_name.match(/^border-left-/) && this.#element.querySelector('.modal-content').classList.remove(class_name));
        this.#element.querySelector('.modal-header').classList.forEach(class_name => class_name.match(/^bg-/) && this.#element.querySelector('.modal-header').classList.remove(class_name));
        // add default bg class
        this.#element.querySelector('.modal-content').classList.add('border-left-' + (settings.type ?? this.#modal.type));
        this.#element.querySelector('.modal-header').classList.add('bg-' + (settings.type ?? this.#modal.type));
        // configure modal with button settings
        this.#element.querySelector('.modal-title').textContent = settings.title ?? this.#modal.title;
        this.#element.querySelector('.modal-body>p').innerHTML = settings.body ?? this.#modal.body;
        // reset text type
        Array.from(this.#element.querySelector('.modal-body>p').classList.values()).forEach(class_name => {
            // ignore class if isn't background
            if (!class_name.match(/^text-/)) return;
            // remove bg class
            this.#element.querySelector('.modal-body>p').classList.remove(class_name);
        });
        this.#element.querySelector('.modal-body>p').classList.add('text-' + (settings.text ?? this.#modal.text));

        // configure buttons
        [ 'accept' ].forEach(button => {
            // replace button text
            this.#buttons[button].element.textContent = (settings[button] ? settings[button].text : undefined) ?? this.#buttons[button].text;
            // replace button css classes
            if (settings[button] && settings[button].classes.length || settings.type) {
                // reset current classes
                Array.from(this.#buttons[button].element.classList.values()).forEach(class_name => {
                    // always keep .btn class
                    if (class_name === 'btn') return;
                    // remove css class from button
                    this.#buttons[button].element.classList.remove( class_name );
                });
                // add classes on settings
                if (settings[button]) settings[button].classes.forEach(class_name => {
                    // ignore .btn class since is already on the button
                    if (class_name === 'btn') return;
                    // add class to button element
                    this.#buttons[button].element.classList.add( class_name );
                });
                // set button color from setting type
                else if (settings.type) this.#buttons[button].element.classList.add('btn-outline-'+settings.type);
            }
        });
    }

    show(event = true) {
        if (typeof event == 'function') {
            // register event function
            this.#fn.show = event;
            // return object to allow chaining
            return this;
        }

        // redirect to jQuery modal
        if (event === true) return Application.$(this.#element).modal('show');

        // execute registered function for event
        this.#fn.show( event );
    }

    hide(event = true) {
        if (typeof event == 'function') {
            // register event function
            this.#fn.hide = event;
            // return object to allow chaining
            return this;
        }

        // redirect to jQuery modal
        if (event === true) return Application.$(this.#element).modal('hide');

        // execute registered function for event
        this.#fn.hide( event );
    }

}

const instance = new Alert;
export default instance;
