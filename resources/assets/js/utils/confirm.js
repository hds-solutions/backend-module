const modal = window.confirmationModal || '.modal#confirm-modal';

class Confirmation {

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
        // capture modal hide event
        this.#modal.hide(e => {
            // redirect to cancel action on active button
            this.#active.cancel();
            // reset active button
            this.#active = new Button(this);
        });

        // capture modal accept event
        this.#modal.accept(e => {
            // redirect to accept action on active button
            this.#active.accept(e);
            // hide modal
            this.#modal.hide();
        });
    }

    register(ele) {
        // register button as posible trigger
        this.#buttons.push(new Button(this, ele));
    }

    _showFor(button) {
        // save active button
        this.#active = button;
        // configure modal for button
        this.#modal.configure( this.#active.settings );
        // show modal
        this.#modal.show();
    }

}

class Modal {

    #element;
    #modal = {
        title: null,
        body: null,
        type: null,
    };
    #buttons = {
        accept: {
            element: null,
            classes: [],
            text: null,
        },
        cancel: {
            element: null,
            classes: [],
            text: null,
        },
    };
    #fn = {
        show: e => {},
        hide: e => {},
        accept: e => {},
    };

    constructor() {
        // load modal
        this.#element = document.querySelector(modal);
        // save default text content
        this.#modal.title = this.#element.querySelector('.modal-title').textContent;
        this.#modal.body = this.#element.querySelector('.modal-body>p').textContent;
        this.#modal.type = Array.from(this.#element.querySelector('.modal-header').classList.values()).filter(class_name => class_name.match(/^bg-/)).shift().replace('bg-', '');
        // get accept and cancel button
        [ 'accept', 'cancel' ].forEach(button => {
            // register button element
            this.#buttons[button].element = this.#element.querySelector('#'+button);
            // save original classlist
            this.#buttons[button].classes = Array.from(this.#buttons[button].element.classList.values());
            // save original text
            this.#buttons[button].text = this.#buttons[button].element.textContent;
        });
        // init events
        this._init();
    }

    _init() {
        // capture modal events and redirect to registered functions
        $(this.#element).on('show.bs.modal', e => this.show(e));
        $(this.#element).on('hide.bs.modal', e => this.hide(e));
        // capture modal hiden event
        $(this.#element).on('hidden.bs.modal', e => {
            // reset modal to original state
            this.configure({
                title: this.#modal.title,
                body: this.#modal.body,
                type: this.#modal.type,
                accept: {
                    text: this.#buttons.accept.text,
                    classes: this.#buttons.accept.classes,
                },
                cancel: {
                    text: this.#buttons.cancel.text,
                    classes: this.#buttons.cancel.classes,
                },
            }, true);
        });
        // capture accept button click and redirect to registered function
        this.#buttons.accept.element.addEventListener('click', e => this.accept(e));
    }

    configure(settings, reset = false) {
        // configure modal with button settings
        this.#element.querySelector('.modal-title').textContent = settings.title ?? this.#modal.title;
        this.#element.querySelector('.modal-body>p').textContent = settings.body ?? this.#modal.body;
        // reset modal type
        Array.from(this.#element.querySelector('.modal-header').classList.values()).forEach(class_name => {
            // ignore class if isn't background
            if (!class_name.match(/^bg-/)) return;
            // remove bg class
            this.#element.querySelector('.modal-header').classList.remove(class_name);
        });
        // add default bg class
        this.#element.querySelector('.modal-header').classList.add('bg-' + (settings.type ?? this.#modal.type));

        // configure buttons
        [ 'accept', 'cancel' ].forEach(button => {
            // replace button text
            this.#buttons[button].element.textContent = settings[button].text ?? this.#buttons[button].text;
            // replace button css classes
            if (settings[button].classes.length) {
                // reset current classes
                Array.from(this.#buttons[button].element.classList.values()).forEach(class_name => {
                    // always keep .btn class
                    if (class_name === 'btn') return;
                    // remove css class from button
                    this.#buttons[button].element.classList.remove( class_name );
                });
                // add classes on settings
                settings[button].classes.forEach(class_name => {
                    // ignore .btn class since is already on the button
                    if (class_name === 'btn') return;
                    // add class to button element
                    this.#buttons[button].element.classList.add( class_name );
                });
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
        if (event === true) return $(this.#element).modal('show');

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
        if (event === true) return $(this.#element).modal('hide');

        // execute registered function for event
        this.#fn.hide( event );
    }

    accept(event = true) {
        if (typeof event == 'function') {
            // register event function
            this.#fn.accept = event;
            // return object to allow chaining
            return this;
        }

        // execute registered function for event
        this.#fn.accept( event );
    }

}

class Button {

    #confirmation;
    #element;
    settings = {
        title: null,
        body: null,
        type: null,
        accept: {
            text: null,
            classes: [],
        },
        cancel: {
            text: null,
            classes: [],
        },
    };

    constructor(confirmation, ele = null) {
        // save confirmation parent
        this.#confirmation = confirmation;
        // register button element
        this.#element = ele;
        // check if button element exists
        if (this.#element == null) return;

        // init config
        this._init();
    }

    _init() {
        // parse button settings
        this._parseButton();

        // check if is submit
        if (this.#element.type == 'submit')
            // capture submit on form
            this.#element.form.addEventListener('submit', e => {
                // prevent default submittion
                e.preventDefault();
                // show modal confirmation for this button
                this.#confirmation._showFor(this);
            });
        else
            // capture click on button
            this.#element.addEventListener('click', e => {
                // prevent default
                e.preventDefault();
                // show modal confirmation for this button
                this.#confirmation._showFor(this);
            });
    }

    _parseButton() {
        // modal title and body
        this.settings.title = this.#element.dataset.confirm;
        this.settings.body = this.#element.dataset.text ?? this.settings.body;
        this.settings.type = this.#element.dataset.modalType ?? this.settings.type;
        // accept button
        this.settings.accept.text = this.#element.dataset.accept ?? this.settings.accept.text;
        if (this.#element.dataset.acceptClass) this.settings.accept.classes = this.#element.dataset.acceptClass.split(' ').filter(class_name => class_name.length > 0);
        // cancel button
        this.settings.cancel.text = this.#element.dataset.cancel ?? this.settings.cancel.text;
        if (this.#element.dataset.cancelClass) this.settings.cancel.classes = this.#element.dataset.cancelClass.split(' ').filter(class_name => class_name.length > 0);
    }

    accept(e) {
        // get modal action
        if (this.#element.type == 'submit')
            // submit parent form
            this.#element.form.submit();
        else if (this.#element.href !== undefined)
            // redirect
            document.location = this.#element.href;
        else if (this.#element.dataset.action !== undefined) {
            // set data-confirmed=true
            this.#element.dataset.confirmed = true;
            this.#element.click();
        }
    }

    cancel(e) {}

}

const instance = new Confirmation;
export default instance;
