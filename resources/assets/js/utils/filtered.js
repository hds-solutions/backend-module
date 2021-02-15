import Event from './consoleevent';
import Preview from './preview';

export default class Filtered {
    constructor(ele, prevent = true) {
        //
        this.element = ele;
        if (this.element.dataset.filteredInit === 'false' && prevent) return false;
        //
        this.parent = document.querySelector(ele.dataset.filteredBy);
        this.using = ele.dataset.filteredUsing;
        //
        this.oldValue = this.parent.value;
        //
        this.init();
    }

    init() {
        // capture change on parent
        this.parent.addEventListener('change', e => {
            // enabled options count
            let enabled = 0;
            // filter element based on parent balue
            for (var i = this.element.options.length - 1; i >= 0; i--) {
                // get option
                let option = this.element.options[i];
                // hide by default
                if (option.dataset[this.using] !== undefined) option.setAttribute('hidden', true);
                // check relation
                if (option.dataset[this.using] == this.parent.value) {
                    // enable option
                    option.removeAttribute('hidden');
                    // count enabled
                    enabled++;
                }
            }
            // reset selection
            if (enabled == 0 || this.oldValue != this.parent.value) this.element.value = '';
            // disable element if no option was enabled
            if (enabled == 0) this.element.setAttribute('disabled', true);
            // enable element
            else this.element.removeAttribute('disabled');
            // update value
            this.oldValue = this.parent.value;
            // link with select picket plugin
            if (this.element.classList.contains('selectpicker'))
                // fire refresh event
                $(this.element).selectpicker('refresh');
            // link with preview
            if (this.element.dataset.preview !== undefined)
                // fire change event
                (new Event('change')).fire(this.element);
        });
        // fire change event on parent
        (new Event('change')).fire(this.parent);
    }
}
