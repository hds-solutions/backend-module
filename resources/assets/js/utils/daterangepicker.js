import Event from './consoleevent';

export default class DateRangePicker {

    constructor(element) {
        this.element = element;
        this.type = this.element.getAttribute('type');
        this.element.type = 'text';
        this._init();
    }

    _init() {
        // build plugin options
        let options = {
            showDropdowns: true,
            autoUpdateInput: false,
            autoApply: true,
            alwaysShowCalendars: true,
            singleDatePicker: (this.element.getAttribute('range') ?? 'false') == 'false',
            cancelButtonClasses: this.element.hasAttribute('required') ? 'd-none' : null,
            applyButtonClasses: !this.type.match(/time/) ? 'd-none' : null,
            startDate: this.element.value.length ? new Date(this.element.value) : new Date,
            locale: {
                cancelLabel: 'Clear',
                format: 'DD MMMM, YYYY',
            }
        };
        // check if has time selection and enable it
        if (this.type.match(/time/)) {
            options.timePicker = true;
            options.timePicker24Hour = (this.element.getAttribute('time') ?? 24) == 24;
            options.timePickerSeconds = this.element.hasAttribute('seconds');
            options.locale.format += ' HH:mm';
        }
        // init jQuery plugin with options
        $(this.element).daterangepicker(options)
            .on('showCalendar.daterangepicker', e => this._onShow())
            .on('apply.daterangepicker', e => e.target.value = this.picker.startDate.format( this.picker.locale.format ) + (!this.picker.singleDatePicker ? ' - '+this.picker.endDate.format( this.picker.locale.format ) : ''))
            .on('cancel.daterangepicker', e => e.target.value = null);
        // save picker
        this.picker = $(this.element).data('daterangepicker');
        // render input value
        if (this.element.value.length) this.element.value = this.picker.startDate.format( this.picker.locale.format );
        // format as ISO on form submit
        this.element.form.addEventListener('submit', e => this.element.value = this.picker.startDate.format( moment.HTML5_FMT.DATE+' '+moment.HTML5_FMT.TIME ));
    }

    _onShow() {
        // get container
        let container = this.picker.container.get(0);
        // always show buttons
        container.classList.remove('auto-apply');
        // fix hours
        this._fixHours(container);
    }

    _fixHours(container) {
        // update hours text
        container.querySelectorAll('.drp-calendar select.hourselect>option').forEach(option => option.textContent = option.value.padStart(2, '0'));
        // capture hour,minute,seconds change
        container.querySelectorAll('.drp-calendar .hourselect,.drp-calendar .minuteselect').forEach(select => {
            // capture change
            select.addEventListener('change', e => setTimeout(_ => this._fixHours(container), 100));
        });
    }

}
