export default class Random {
    constructor(element) {
        this.element = element;
        this.target = document.querySelector( this.element.dataset.target );
        this.uppercase = this.element.dataset.uppercase == 'true';
        this.length = this.element.dataset.length ?? 16;
        this.init();
    }

    init() {
        // capture element click
        this.element.addEventListener('click', e => {
            // generate random string
            let random = window.btoa(
                // get random bytes from crypto
                Array.from(window.crypto.getRandomValues(new Uint8Array(this.length * 2)))
                    // get char from code
                    .map(b => String.fromCharCode(b)).join('')
                // crop to length
                ).replace(/[+/]/g, '').substring(0, this.length);
            // convert to uppercase
            if (this.uppercase) random = random.toUpperCase();
            // set value to target
            this.target.value = random;
            // focus target
            this.target.select();
        });
    }
}
