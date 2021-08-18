import Event from './consoleevent';

class MessageListener {

    constructor() {
        // instances
        this._instances = {};
        // capture messages
        window.addEventListener('message', message => {
            // capture modal content ready message
            if (message.data.ready) return Modal.adjust();

            // check if message comes from a registered namespace
            if (!message.data.namespace || this._instances[message.data.namespace] === undefined) return;
            // redirect message to registered namespace
            this._instances[message.data.namespace](message.data);
        });
    }

    register(namespace, callback) {
        // register callback
        this._instances[namespace] = callback;
    }

}

class ForeignModal {

    #modal;
    #iframe;
    #fn = {
        show: e => {},
        hide: e => {},
    };
    #startX = 0;
    #startY = 0;
    #x = 0;
    #y = 0;

    constructor(modal = null) {
        this.#modal = modal ?? document.querySelector('.modal#foreign-modal');
        this.#iframe = this.modal.querySelector('iframe');
        // init events
        this._init();
    }

    _init() {
        // capture modal events and redirect to registered functions
        $(this.#modal).on('show.bs.modal', e => this.show(e));
        $(this.#modal).on('hide.bs.modal', e => this.hide(e));
        // capture modal hiden event
        $(this.#modal).on('hidden.bs.modal', e => {
            // reset modal to original state
            this.#iframe.src = '';
            this.#modal.querySelector('.modal-body').style.height = '250px';
            this.#modal.classList.remove('maximized');
        });
        // init modal buttons
        this.#modal.querySelector('[data-maximize]').addEventListener('click', e => {
            this.#modal.classList.add('maximized');
            // get modal content container
            let content = this.#modal.querySelector('.modal-content');
            content.style.top = '0px';
            content.style.left = '0px';
        });
        this.#modal.querySelector('[data-restore]').addEventListener('click', e => {
            this.#modal.classList.remove('maximized');
            // get modal content container
            let content = this.#modal.querySelector('.modal-content');
            content.style.top = this.#y + 'px';
            content.style.left = this.#x + 'px';
        });
        // init modal drag
        let header = this.#modal.querySelector('.modal-header');
        header.addEventListener('mousedown', e => this.drag(e, header));
        // header.addEventListener('mouseleave', e => this.stop(e, header));
    }

    get modal() { return this.#modal; }
    get iframe() { return this.#iframe; }

    title(title = null) {
        this.#modal.querySelector('#foreign-modal-title').textContent = title;
        return this;
    }

    open(url) {
        this.iframe.src = url;
        return this;
    }

    adjust() {
        this.#modal.querySelector('.modal-body').style.height = (this.iframe.contentWindow.document.body.scrollHeight+20)+'px';
    }

    show(event = true) {
        if (typeof event == 'function') {
            // register event function
            this.#fn.show = event;
            // return object to allow chaining
            return this;
        }

        // redirect to jQuery modal
        if (event === true) return $(this.#modal).modal('show');

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
        if (event === true) return $(this.#modal).modal('hide');

        // execute registered function for event
        this.#fn.hide( event );
    }

    drag(e, header) {
        // prevent default dragging of selected content
        e.preventDefault();

        // check if state is maximized
        if (this.#modal.classList.contains('maximized')) return;

        // get modal content container
        let content = this.#modal.querySelector('.modal-content');

        // save start positions
        this.#startX = e.pageX - this.#x;
        this.#startY = e.pageY - this.#y;

        // set dragging class
        content.classList.add('dragging');

        // capture mouse move
        $(document).on('mousemove', event => {
            this.#y = event.pageY - this.#startY;
            this.#x = event.pageX - this.#startX;
            content.style.top = this.#y + 'px';
            content.style.left = this.#x + 'px';
        });
        // cancel events
        $(document).on('mouseup', e => this.stop(e, header));
    }

    stop(e, header) {
        // get modal content container
        let content = this.#modal.querySelector('.modal-content');
        // remove dragging class
        content.classList.remove('dragging');

        // disable events
        $(document).off('mousemove');
        $(document).off('mouseup');
    }

}

// register a singleton
const Listener = new MessageListener;
const Modal = new ForeignModal;

export default class Foreign {

    constructor(element, value = 'add::new') {
        // save <select> element
        this._element = element.tagName == 'SELECT' ? element : element.parentElement;
        // save value to match
        this._value = value;
        // capture element change
        this._element.addEventListener('change', e => this._onChange(e));
        // register message listener
        Listener.register(this._element.dataset.foreign, message => this._onMessage(message));
    }

    _onChange(e) {
        for (let option of this._element.selectedOptions) {
            // match against trigger value
            if (option.value !== this._value) continue;

            // select empty value
            this.selectEmpty();

            // build URL
            let url = this._element.dataset.filteredUsing ?
                appendQueryParameter(
                    this._element.dataset.form,
                    this._element.dataset.filteredUsing,
                    document.querySelector(this._element.dataset.filteredBy).value
                ) : this._element.dataset.form;

            // open modal with url
            return Modal.open(url)
                // set title and show modal
                .title(this._element.dataset.foreign+'.create').show();
        }
    }

    selectEmpty() {
        // set select value to empty
        this._element.value = '';
        // select empty option
        for (let empty of this._element.options) empty.selected = empty.value == '';
        // fire change event
        (new Event('change')).fire( this._element );
    }

    _onMessage(data) {
        // get created resource
        let resource = data.resource,
            toKeep = [];

        // close modal
        Modal.hide();
        // validate if resource was created
        if (!data.saved) return;

        // remove options from <select>
        while (this._element.options.length > 0) {
            // keep empty and add::new options
            if (this._element.options[0].value.length == 0 || this._element.options[0].value == this._value) toKeep.push(this._element.options[0]);
            // remove option
            this._element.remove(0);
        }
        // append keeped options
        toKeep.forEach(option => this._element.add(option));
        // select empty value
        this.selectEmpty();

        // get updated resources list
        $.get(this._element.dataset.fetch, result => {
            // foreach resources
            for (let new_resource of result.data)
                // add option to select
                this._element.add(
                    // create new <option> element
                    new Option(new_resource.name, new_resource.id,
                        new_resource.id == resource.id,
                        new_resource.id == resource.id,
                    ),
                    // keep add::new option at the end
                    this._element.options[this._element.options.length - 1],
                );
            // set value
            this._element.value = resource.id;
            // refresh selectpicker
            $(this._element).selectpicker('refresh');
            // fire change event
            (new Event('change')).fire( this._element );
        });
    }

}

export function appendQueryParameter(url, name, value) {
    if (url.length === 0) return;

    let rawURL = url;

    // URL with `?` at the end and without query parameters
    // leads to incorrect result.
    if (rawURL.charAt(rawURL.length - 1) === "?")
        rawURL = rawURL.slice(0, rawURL.length - 1);

    const parsedURL = new URL(rawURL);
    let parameters = parsedURL.search;

    parameters += (parameters.length === 0) ? "?" : "&";
    parameters = `${parameters}${name}=${value}`;

    return `${parsedURL.origin}${parsedURL.pathname}${parameters}`;
}

export function popupCenter({url, title, w = 900, h = 500}) {
    // Fixes dual-screen position                             Most browsers      Firefox
    const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
    const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

    const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    const systemZoom = width / window.screen.availWidth;
    const left = (width - w) / 2 / systemZoom + dualScreenLeft
    const top = (height - h) / 2 / systemZoom + dualScreenTop
    const newWindow = window.open(url, title,
        `
        width=${w / systemZoom},
        height=${h / systemZoom},
        top=${top},
        left=${left},
        scrollbars=yes,
        menubar=no,
        toolbar=no,
        status=no,
        resizable=no
        `
    )

    if (window.focus) newWindow.focus();

    return newWindow;
}
