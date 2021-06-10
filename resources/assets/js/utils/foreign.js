class MessageListener {

    constructor() {
        // instances
        this._instances = {};
        // capture messages
        window.addEventListener('message', message => {
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

// register a singleton
const Listener = new MessageListener;

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
        // popup placeholder
        this._popup = null;
    }

    _onChange(e) {
        for (let option of this._element.selectedOptions) {
            // match against trigger value
            if (option.value !== this._value) continue;

            // select empty value
            this.selectEmpty();

            // open popup for resource creation
            this._popup = popupCenter({
                url: this._element.dataset.filteredUsing ?
                    appendQueryParameter(
                        this._element.dataset.form,
                        this._element.dataset.filteredUsing,
                        document.querySelector(this._element.dataset.filteredBy).value
                    ) : this._element.dataset.form,
                title: this._element.dataset.foreign+'.create',
            });

            // // capture popup close
            // popup.onload = e => {
            //     popup.onbeforeunload = e => {
            //         // TODO: update select values
            //         console.debug('popup closed');
            //     }
            // }

            // cancel for loop (prevents multiple popups)
            break;
        }
    }

    selectEmpty() {
        // set select value to empty
        this._element.value = '';
        // select empty option
        for (let empty of this._element.options) empty.selected = empty.value == '';
    }

    _onMessage(data) {
        // get created resource
        let resource = data.resource,
            toKeep = [];

        // close popup
        this._popup.close();
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
