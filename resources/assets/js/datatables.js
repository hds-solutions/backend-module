require('datatables.net-bs4');
require('datatables.net-select-bs4');
// require('datatables.net-buttons/js/buttons.colVis.min.js');
// require('datatables.net-buttons/js/buttons.html5.min.js');
// require('datatables.net-buttons/js/buttons.print.min.js');
// require('pdfmake');
// require('datatables.net-buttons/js/buttons.flash.min.js');
require('datatables.net-buttons-bs4');

import Event from './utils/consoleevent';
import SearchModal from './resources/SearchModal';

import { Container, byString } from './utils/datatables';

import { reduce, parse } from './utils/utilities';

let assetBasePath = document.querySelector('meta[name="assets-path"]').content ?? '';
function asset(url) { return assetBasePath + url; }

document.querySelectorAll('table[id$=-datatable],table[id$=-modal]').forEach(table => {
    // check if datatables config exists
    if (window.datatables === undefined) return;
    // get datatable configuration
    let config = window.datatables[table.id] ?? null;
    // check if null
    if (!config) return;
    // get container for current table
    let container = new Container(table.nextElementSibling, config.ajax.url ?? config.ajax);
    // configure columns
    config.columns.map(column => {
        switch (true) {
            case column.name == 'actions':
                // set class name
                column.className = 'align-middle w-150px text-center';
                column.sortable = false;
                column.searchable = false;
                // render actions using container
                column.render = (data, type, row, meta) => {
                    return container.render(row);
                }
                break;
            case column.render !== undefined:
                // ignore if already a function
                if (typeof column.render === 'function') return;
                // get render type
                let type = column.render.split(':');
                //
                type = [ type.shift(), type.join(':') ];
                //
                switch (type.shift()) {
                    case 'bold':
                        column.render = data => '<b>'+data+'</b>';
                        break;
                    case 'image':
                        // get datetime configuration
                        let image_config = type.shift().split(';'),
                            col = image_config.shift(),
                            className = image_config.shift() || 'mh-75px';
                        // set size
                        column.className = 'text-center align-middle w-200px';
                        // // get column
                        // let col = type.shift();
                        // render image
                        column.render = (data, type, row, meta) => {
                            return '<td><img src="' + (byString(row, col) ?? asset('backend-module/assets/images/default.jpg')) + '" class="'+className+'"></td>';
                        }
                        break;
                    case 'boolean':
                        column.render = (data, type, row, meta) => data ? 'True' : 'False';
                        break;
                    case 'datetime':
                        // get datetime configuration
                        let datetime_config = type.shift().split(';'),
                            field = datetime_config.shift(),
                            format = datetime_config.shift() || 'F j, Y H:i';
                        column.render = data => (new Date(data)).format( format );
                        break;
                    case 'concat':
                        // split fields from separator
                        let concat_config = type.shift().split(';'),
                            fields = concat_config.shift(),
                            separator = concat_config.shift() || ', ';
                        column.render = (data, type, row, meta) => {
                            // foreach fields to concat
                            let str = '';
                            fields.split(',').forEach(field => str += ((str.length ? separator : '') + row[field]) );
                            return str;
                        };
                        break;
                    case 'view':
                        column.render = (d, t, row, m) => {
                            // parse view with object data
                            return parse(column.data, reduce(row, type[0]));
                        };
                        break;
                }
                break;
            default:
                column.render = (data, type, row, meta) => {
                    return byString(row, column.data) ?? '--';
                }
        }
        return column;
    });
    // capture draw callback to register events
    config.drawCallback = e => container.events();
    // get filters form
    const filters = document.querySelector('[data-filters-for="#'+table.id+'"]') ?? document.querySelector('#filters form') ?? false;
    // add filters from form to ajax request
    if (filters) config.ajax.data = data => ({...data, ...getFormValues( filters, false ) });
    // init datatable
    const datatable = $(table).DataTable(config);
    // find selects to apply styling
    document.querySelectorAll('#'+table.id+'_wrapper select').forEach(select => {
        // set class
        select.classList.add('selectpicker');
        // init select picker
        $(select).selectpicker();
    });
    // capture form submit
    if (filters) filters.addEventListener('submit', e => { e.preventDefault();
        // execute ajax to refresh data
        datatable.ajax.reload();
    });
    if (filters) filters.addEventListener('reset', e => {
        // set all form values to empty
        Array.from(filters.elements).forEach(filter => {
            // ignore if isn't a filter field
            if (!filter.name.match(/^filter/)) return;
            // reset filter value
            filter.value = null;
            // reset selected value if is a select
            if (filter.type.match(/^select/)) {
                // reset selected options
                Array.from(filter.options).forEach(option => option.removeAttribute('selected'));
                // fire change if selectpicker
                if (filter.classList.contains('selectpicker')) $(filter).selectpicker('refresh');
                // check if has filtered plugin
                if (filter.dataset.filteredBy)
                    // fire change event on parent
                    (new Event('change')).fire( document.querySelector(filter.dataset.filteredBy) )
            }
        });
        // execute ajax to refresh data
        datatable.ajax.reload();
    });
    // extra modal events
    if (filters && filters.dataset.modal) new SearchModal(filters.dataset.modal, table, filters, datatable);
});

/**
 * Get the values from a form
 * @param formId ( ID without the # )
 * @returns {object}
 */
function getFormValues( form, withempty = true ) {
    let postData = {};
    let formData = new FormData( form );

    for (const value of formData.entries()) {
        let container = postData;
        let key = value[0];
        // Check for any arrays
        let arrayKeys = key.match( /\[[\w\-]*\]/g );

        if (arrayKeys !== null) {
            // prepend the first key to the list
            arrayKeys.unshift( key.substr( 0, key.search( /\[/ ) ) );
            for ( let i = 0, count = arrayKeys.length, lastRun = count - 1; i < count; i++ ) {
                let _key = arrayKeys[i];
                _key = _key.replace( "[", '' ).replace( "]", '' ); // Remove the brackets []
                if ( _key === '' ) {
                    if ( ! Array.isArray( container ) )
                        container = [];

                    _key = container.length;
                }

                // Create an object for the key if it doesn't exist
                if ( ! (_key in container) ) {
                    if ( i !== lastRun && arrayKeys[i + 1] === '[]' )
                        container[_key] = [];
                    else
                        container[_key] = {};
                }

                // Until we're the last item, swap container with it's child
                if ( i !== lastRun )
                    container = container[_key];

                key = _key;
            }
        }
        // finally assign the value
        if (value[1].length || withempty) container[key] = value[1];
    }

    return postData;
}
