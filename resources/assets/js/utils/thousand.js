$(_ => {
    class Thousand {
        constructor(ele) {
            this.element = ele;
            this.change();
        }

        change() {
            // capture change event
            this.element.addEventListener('keyup', e => {
                // format number
                this.format();
            });
            // capture form submit
            $(this.element).closest('form').submit(e => {
                // set raw value
                this.element.value = this.element.value.replace(/\,*/g, '');
            });
            // format number
            if (this.element.value.length > 0) this.format();
        }

        format() {
            // get current value
            let val = this.element.value.replace(/[^0-9\.]/g,'');
            // validate empty value
            if (val != '') {
                // convert value
                valArr = val.split('.');
                valArr[0] = (parseInt(valArr[0],10)).toLocaleString('EN');
                val = valArr.join('.');
            }
            // override value
            this.element.value = val;
        }
    }

    // get all elements with thousand
    $('[thousand]').each((idx, ele) => {
        new Thousand(ele);
    });
});