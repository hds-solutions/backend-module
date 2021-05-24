import Event from './consoleevent';

export default class Currency {

    constructor(element) {
        // save element
        this.element = element;
        // find parent
        this.parent = document.querySelector(this.element.dataset.currencyBy);
        // capture change on parent
        this.parent.addEventListener('change', e => { this._change(e); });
        // fire change event on parent
        (new Event('change')).fire(this.parent);
    }

    _change(e) {
        // get selected option
        let selected = this.parent.selectedOptions.item(0);
        // set decimals on field
        this.element.dataset.decimals = selected.dataset.decimals;
        // set step on field
        this.element.step = (1 / Math.pow(10, selected.dataset.decimals ?? 0)).toFixed(selected.dataset.decimals ?? 0);
        // fire change event on element
        (new Event('blur')).fire(this.element);
    }

}
