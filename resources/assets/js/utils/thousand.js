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
        // capture form submit
        $(this.element).closest('form').submit(e => {
            // set raw value
            this.element.value = this.element.value.replace(/\,*/g, '');
        });
        // format number
        if (this.element.value.length > 0) this._format();
    }

    _format() {
        // get current value
        let val = this.element.value.replace(/[^0-9\.]/g,'');
        // validate empty value
        if (val != '') {
            // convert value
            let valArr = val.split('.');
            valArr[0] = (parseInt(valArr[0],10)).toLocaleString('EN');
            if (valArr[1] && this.element.dataset.decimals) {
                // console.debug(this.element.dataset.decimals);
                valArr[1] = valArr[1].substr(0, this.element.dataset.decimals);
                //
                if (valArr[1].length == 0) delete valArr[1];
            }
            //
            val = valArr.join('.');
        }
        // remove last dot on non decimal
        if (this.element.dataset.decimals == 0) val = val.replace(/[\.]*$/g, '');
        // override value
        this.element.value = val;
    }

}