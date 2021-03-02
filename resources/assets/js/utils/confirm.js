const modal = window.confirmationModal || '.modal#confirm-modal';

class Confirmation {
    constructor() {
        this.modal = $(modal);
        this.buttons = [];
        this.active = new Button(this);
        this.accept = this.modal.find('.modal-footer>#accept');
        this.init();
    }

    init() {
        // capture accept
        this.accept.click(e => {
            // redirect to event
            this.active.accept(e);
            // hide modal
            this.modal.modal('hide');
        });
        // capture modal close
        this.modal.on('hide.bs.modal', e => {
            // execute cancel action
            this.active.cancel();
            // reset active button
            this.active = new Button(this);
        });
    }

    show(button) {
        // save active button
        this.active = button;
        // set modal data
        this.modal.find('.modal-title').text(this.active.textTitle);
        this.modal.find('.modal-body>p').text(this.active.textBody);
        this.accept.text(this.active.textAccept);
        // show modal
        this.modal.modal('show');
    }

    button(ele) {
        // add new button
        this.buttons.push(new Button(this, ele));
    }
}

class Button {
    constructor(modal, ele = null) {
        this.modal = modal;
        this.button = ele;
        //
        if (this.button == null) return;
        // save texts
        this.textTitle = this.button.dataset.confirm;
        this.textBody = this.button.dataset.text;
        this.textAccept = this.button.dataset.accept;
        // init config
        this.init();
    }

    init() {
        // check if is submit
        if (this.button.type == 'submit')
            // capture submit on form
            this.button.form.addEventListener('submit', e => {
                // prevent default submittion
                e.preventDefault();
                // show modal
                this.modal.show(this);
            });
        else
            // capture click on button
            this.button.addEventListener('click', e => {
                // prevent default
                e.preventDefault();
                // show modal
                this.modal.show(this);
            });
    }

    accept(e) {
        // get modal action
        if (this.button.type == 'submit')
            // submit parent form
            this.button.form.submit();
        else if (this.button.href !== undefined)
            // redirect
            document.location = this.button.href;
        else if (this.button.dataset.action !== undefined) {
            // set
            this.button.dataset.confirmed = true;
            this.button.click();
        }
    }

    cancel() { console.log('event cancelled'); }
}

const instance = new Confirmation;
export default instance;