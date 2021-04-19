export default class Thousand {

    constructor(ele) {
        // save element
        this.element = ele;
        //
        this.init();
    }

    init() {
        // force element to be type=text
        this.element.type = 'text';
        // capture change event
        this.element.addEventListener('keyup', e => {
            // format number
            this._format();
        });
        this.element.addEventListener('blur', e => {
            // format with fixed
            this._format(true);
        });
        // capture form submit
        $(this.element).closest('form').submit(e => {
            // set raw value
            this.element.value = this.element.value.replace(/\,*/g, '');
        });
        // format number with fixed
        if (this.element.value.length > 0) this._format(true);
    }

    _format(fixed = false) {
        // get negative symbol
        let negative = this.element.value.startsWith('-'),
            // get current value
            val = this.element.value.replace(/[^0-9\.]/g,'');
        // validate empty value
        if (val != '') {
            // convert value
            let valArr = val.split('.');
            valArr[0] = (parseInt(valArr[0],10)).toLocaleString('EN');
            // check if decimals are allowed
            if (this.element.dataset.decimals > 0) {
                // check for decimals and append empty ones
                if (valArr[1] === undefined && fixed) valArr[1] = '0';
                // check if there is decimals
                if (valArr[1] !== undefined) {
                    // crop decimals to max
                    valArr[1] = valArr[1].substr(0, this.element.dataset.decimals);
                    // check for fixed and create zeroes
                    if (fixed) valArr[1] = (new Number('0.'+valArr[1])).toFixed(this.element.dataset.decimals).substr(2);
                    // remove if no decimals
                    if (valArr[1].length == 0) delete valArr[1];
                }
            }
            // join thousand and decimals
            val = valArr.join('.');
        }
        // remove last dot on non decimal
        if (this.element.dataset.decimals == 0) val = val.replace(/[\.]*$/g, '');
        // override value
        this.element.value = (negative?'-':'')+val;
    }

}
