import Filtered from './filtered';
import Preview from './preview';
import Thousand from './thousand';
import Currency from './currency';

export default class Multiple {
    constructor(container) {
        //
        this._fn = {
            new: element => { this._events.new.push( element ); },
        };
        this._events = {
            new: []
        };
        //
        this.container = $(container);
        this.multiple = $(this.container.data('multiple')+this.container.data('template'));
        // remove template
        this.multiple.remove();
        // init existing
        this.init();
        // append new
        this.new();
    }

    init() {
        this.container.find( this.container.data('multiple') ).each((idx, ele) => {
            // load element
            let element = $(ele);
            // init element
            new Element( this, element );
        });
    }

    new(fn) {
        // check for function registration
        if (fn !== undefined) {
            // register function
            this._fn.new = typeof fn == 'function' ? fn : this._fn.new;
            // execute events
            this._events.new.forEach( element => {
                // remove element from list
                this._events.new.splice(this._events.new.indexOf( element ), 1);
                // execute event
                this._fn.new( element )
            });
            // return object to allow chaining
            return this;
        }
        // clone elmeent
        let element = new Element( this, this.multiple.clone() );
        // append cloned element to container
        this.container.append(element.element);
        // find selectpicker
        element.element.find('.selectpicker').each((idx, ele) => {
            // reset
            $(ele).selectpicker('destroy');
            $(ele).selectpicker();
        });
        //
        element.filtereds();
        element.previews();
        element.thousands();
        element.currencies();
        // execute event
        this._fn.new( element.element.get(0) );
    }
}

class Element {
    constructor(container, element) {
        this.container = container;
        this.element = element;
        this.delete = this.element.find('[data-action="delete"]');
        // load used flag
        this.used = this.element.data('used') == true;
        // check if new
        if (!this.used) this.delete.hide();
        // bind events
        this.events();
        //
        this.labels();
    }

    labels() {
        this.element.find('label[for]').each((idx, ele) => {
            // get target
            let target = this.element.find('#'+ele.htmlFor);
            // generate a random id
            let id = this.random();
            // put random id on target
            target.attr('id', 't'+id);
            // update label for
            ele.htmlFor = 't'+id;
        });
    }

    filtereds() {
        // check filtered-by
        let filteredElements = this.element.find('[data-filtered-by]');
        // init plugin
        filteredElements.each((idx, ele) => {
            // get filtered by element
            let filteredBy = this.element.find( ele.dataset.filteredBy );
            // check if we need to ignore
            if (ele.dataset.filteredKeepId != 'true') {
                // generate a random id
                let id = this.random();
                // put random id on target element
                filteredBy.attr('id', 'f'+id);
                // update filtered by value
                ele.dataset.filteredBy = '#f'+id;
            }
            // init plugin
            let filtered = new Filtered( ele, false );
        });
    }

    previews() {
        // check filtered-by
        let previewElements = this.element.find('[data-preview]');
        // init plugin
        previewElements.each((idx, ele) => {
            // get preview element
            let preview = this.element.find( ele.dataset.preview );
            // generate a random id
            let id = this.random();
            // put random id on target element
            preview.attr('id', 'p'+id);
            // update filtered by value
            ele.dataset.preview = '#p'+id;
            // init plugin
            new Preview( ele, false );
        });
    }

    thousands() {
        // check filtered-by
        let thousandElements = this.element.find('[thousand]');
        // init plugin
        thousandElements.each((idx, ele) => {
            // init plugin
            new Thousand( ele );
        });
    }

    currencies() {
        // check filtered-by
        let currencyElements = this.element.find('[data-currency-by]');
        //
        let ids = [];
        // init plugin
        currencyElements.each((idx, ele) => {
            // generate a random id
            if (ids[ele.dataset.currencyBy] === undefined) {
                // generate new ID for currenvy
                ids[ele.dataset.currencyBy] = this.random();
                // get currency element
                let currency = this.element.find( ele.dataset.currencyBy );
                // put random id on target element
                currency.attr('id', 'c'+ids[ele.dataset.currencyBy]);
            }
            // update filtered by value
            ele.dataset.currencyBy = '#c'+ids[ele.dataset.currencyBy];
            // init plugin
            new Currency( ele );
        });
    }

    events() {
        // find input and selects
        this.element.find('input,select')
            // capture change
            .change(e => { this.fire(e) })
            // capture keyup
            .keyup(e => { this.fire(e) });
        // capture delete
        this.delete.click(e => {
            // integration with confirm
            if (this.delete.data('confirm') !== undefined &&
                // check if not confirmed
                this.delete.data('confirmed') !== true)
                // dont do anything
                return;
            // remove element
            this.element.remove();
        });
        // init select picker
        this.element.find('.selectpicker').selectpicker();
    }

    fire(e) {
        // prevent adding if used
        if (this.used || e.target.value.length == 0) return;
        // change flag
        this.used = true;
        // fire add new
        this.container.new();
        // show delete current
        this.delete.show();
    }

    random() {
        // return random string
        return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    }
}
