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
        let value = this.element.value.split(' - '),
            options = {
                showDropdowns: true,
                autoUpdateInput: false,
                autoApply: true,
                alwaysShowCalendars: true,
                singleDatePicker: (this.element.getAttribute('range') ?? 'false') == 'false',
                cancelButtonClasses: this.element.hasAttribute('required') ? 'd-none' : null,
                applyButtonClasses: !this.type.match(/time/) ? 'd-none' : null,
                // startDate: this.element.value.length ? new Date(this.element.value) : new Date,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD MMMM, YYYY',
                },
                // startDate: value[0] && value[0].length ? new Date(value[0]) : null,
                // endDate: value[1] && value[1].length ? new Date(value[1]) : null,
            };
        // preload dates set on field
        if (value[0] !== undefined && value[0].length > 0) options.startDate = new Date(value[0]);
        if (value[1] !== undefined && value[1].length > 0) options.endDate = new Date(value[1]);

        // check if has range
        if (this.element.hasAttribute('range'))
            options.ranges = {
                'Today': [ moment(), moment() ],
                'Yesterday': [ moment().subtract(1, 'days'), moment().subtract(1, 'days') ],
                'Last 7 Days': [ moment().subtract(6, 'days'), moment() ],
                'Last 30 Days': [ moment().subtract(29, 'days'), moment() ],
                'This Month': [ moment().startOf('month'), moment().endOf('month') ],
                'Last Month': [ moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month') ],
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
            .on('show.daterangepicker', e => this._onShow())
            .on('apply.daterangepicker', e => this._format())
            .on('cancel.daterangepicker', e => this.element.value = null);
        // save picker instance
        this.picker = $(this.element).data('daterangepicker');

        // format as ISO on form submit
        this.element.form.addEventListener('submit', e => {
            // check if input has value
            if (!this.element.value) return;
            // get start date on ISO format
            this.element.value = this.picker.startDate.format( moment.HTML5_FMT.DATE+' '+moment.HTML5_FMT.TIME );
            // check if is range
            if (!this.picker.singleDatePicker)
                // add end date on ISO format
                this.element.value += ' - ' + this.picker.endDate.format( moment.HTML5_FMT.DATE+' '+moment.HTML5_FMT.TIME );
            // render custom format after form submit
            setTimeout(_ => this._format(), 10);
        });
        // render input value
        if (options.startDate) setTimeout(_ => this._format(), 10);
    }

    _format() {
        this.element.value = this.picker.startDate.format( this.picker.locale.format );
        if (!this.picker.singleDatePicker && this.picker.endDate._isValid)
            this.element.value += ' - ' + this.picker.endDate.format( this.picker.locale.format );
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
