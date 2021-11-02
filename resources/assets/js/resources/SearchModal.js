import Application from './Application';
import Event from '../utils/consoleevent';

export default class SearchModal {

    #modal;
    #filters;
    #table;
    #datatable;
    #original_order;

    #active = false;
    #filtered = false;

    #rows;
    #current = -1;
    active_classes = [ 'bg-primary', 'text-white' ];

    #fn = {
        show: e => {},
        hide: e => {},
        selected: e => {},
    };

    constructor(modal, table, filters, datatable) {
        this.#modal = document.querySelector(modal);
        this.#table = table;
        this.#filters = filters;
        this.#datatable = datatable;
        this.#original_order = this.datatable.order()
        this.#init();
        // register modal on application
        Application.alias(this.modal.id, this);
    }

    get modal() { return this.#modal; }
    get table() { return this.#table; }
    get filters() { return this.#filters; }
    get datatable() { return this.#datatable; }
    get rows() { return this.#rows; }
    get current() { return this.#current; }

    show(event = true) {
        if (typeof event == 'function') {
            // register event function
            this.#fn.show = event;
            // return object to allow chaining
            return this;
        }

        // redirect to jQuery modal
        if (event === true) return $(this.modal).modal('show');

        // execute registered function for event
        this.#fn.show( event );
    }

    hide(event = true) {
        if (typeof event == 'function') {
            // register event function
            this.#fn.hide = event;
            // return object to allow chaining
            return this;
        }

        // redirect to jQuery modal
        if (event === true) return $(this.modal).modal('hide');

        // execute registered function for event
        this.#fn.hide( event );
    }

    selected(fn) {
        // check for function registration
        if (typeof fn == 'function') {
            // register function
            this.#fn.selected = fn;
            // return object to allow chaining
            return this;
        } else {
            // redirect event to registered function
            this.#fn.selected( fn );
            // hide modal
            this.hide();
        }
    }

    #init() {
        this.filters.querySelectorAll('select').forEach(select =>
            select.addEventListener('change', e => {
                if (this.#active) this.datatable.ajax.reload();
            }));
        // capture modal events and redirect to registered functions
        $(this.modal).on('show.bs.modal', e => this.show(e));
        // capture modal open
        $(this.modal).on('shown.bs.modal', e => {
            // set active flag
            this.#active = true;
            // set focus on first filter field
            let focused = false;
            this.filters.querySelectorAll('input,select').forEach(field => {
                // ignore if already on focus or element is not visible
                if (focused || field.offsetParent === null) return;
                // change flag
                focused = true;
                // focus and select element
                field.focus();
                if (field.select) field.select();
            });
            // fire once to set size on start
            this.#resize();
        });
        // capture modal close
        $(this.modal).on('hidden.bs.modal', e => {
            // reset selection
            this.#current = -1;
            // change active flag
            this.#active = false;
            // reset filter fields
            this.filters.querySelectorAll('input,select').forEach(field => {
                // set value to null
                field.value = null;
                // check if has options <select>
                if (field.options) {
                    // select empty option
                    field.options.forEach(option => option.selected = option.value == '');
                    // check if has selectpicker plugin and refresh
                    if (field.classList.contains('selectpicker')) $(field).selectpicker('refresh');
                    // check if has filtered plugin
                    if (field.dataset.filteredBy)
                        // fire change event on parent
                        (new Event('change')).fire( document.querySelector(field.dataset.filteredBy) )
                }
            });
            // check if was filtered when open
            if (this.#filtered)
                // reset order and reload without filters
                this.datatable.order( this.#original_order ).draw();
            // hightlight current
            this.#select();
            // redirect event to registered listener
            this.hide(e);
            // reset filtered flag
            this.#filtered = false;
        });
        // capture keydown inside modal
        this.modal.addEventListener('keydown', e => {
            switch (e.key) {
                case 'ArrowLeft':
                case 'ArrowRight':
                    // ignore arrows and prevent selection reset
                    break;
                case 'ArrowUp':
                    // ignore if
                    if (this.current > 0) this.#current--;
                    break;
                case 'ArrowDown':
                    if (this.current + 1 < this.datatable.rows().data().length) this.#current++;
                    break;
                case 'Enter':
                    // check if row is selected
                    if (this.rows[ this.current ]) {
                        // prevent form submit
                        e.preventDefault();
                        // redirect to event
                        this.selected( this.datatable.row( this.current ).data() );
                    }
                    break;
                default:
                    // reset selection
                    this.#current = -1;
            }
            // hightlight current
            this.#select();
        });
        // capture datatable draw event
        this.datatable.on('draw', (e, settings, data) => {
            // enable filtered flag
            if (this.#active) this.#filtered = true;
            // reset to no selection
            this.#current = -1;
            // save total lines
            this.#rows = this.table.querySelectorAll('tbody>tr');
            // check if only one result
            if (this.datatable.rows().data().length === 1) this.#current = 0;
            // hightlight current
            this.#select();
        });
        // capture click on table
        this.table.querySelector('tbody').addEventListener('click', e => {
            // get selected datatable row
            let row = this.datatable.row( e.target );
            // hightlight selected row
            this.#select( row.index() );
        });
        // capture dblclick on table
        this.table.querySelector('tbody').addEventListener('dblclick', e => {
            // get selected datatable row
            let row = this.datatable.row( e.target );
            // hightlight selected row
            this.#select( row.index() );
            // redirect to selected
            this.selected( row.data() );
        });

        // capture window resize
        this.#captureResize();
    }

    #select(index = null) {
        //
        if (index !== null) this.#current = index;
        // remove class
        this.rows.forEach(row =>
            this.active_classes.forEach(classname =>
                row.classList.remove( classname )));
        // set active class on current row
        let row = this.rows[ this.current ];
        if (row) this.active_classes.forEach(classname =>
            row.classList.add( classname ));
        if (row) row.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    #captureResize() {
        // capture window resize event
        window.addEventListener('resize', e => this.#resize(), true);
        // fire once to set size on start
        this.#resize();
    }

    #resize() {
        // get lines
        let tbody = this.table.querySelector('tbody'),
            lines = tbody.querySelectorAll('tr');
        // hide lines
        let display = lines.length ? lines[0].style.display : 'table';
        lines.forEach(line => line.style.display = 'none');
        // remove calculated height
        tbody.style.removeProperty('height');
        // set new height
        tbody.style.setProperty('height',
            // modal body height
            this.modal.querySelector('.modal-body').clientHeight
            // substract thead heigth
            - this.table.querySelector('thead').clientHeight +'px');
        // show lines
        lines.forEach(line => line.style.display = display);
    }

}
