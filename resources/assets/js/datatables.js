require('datatables.net-bs4');
require('datatables.net-select-bs4');
// require('datatables.net-buttons/js/buttons.colVis.min.js');
// require('datatables.net-buttons/js/buttons.html5.min.js');
// require('datatables.net-buttons/js/buttons.print.min.js');
// require('pdfmake');
// require('datatables.net-buttons/js/buttons.flash.min.js');
require('datatables.net-buttons-bs4');

import { Container, byString } from './utils/datatables';

import { reduce, parse } from './utils/utilities';

let assetBasePath = document.querySelector('meta[name="assets-path"]').content ?? '';
function asset(url) { return assetBasePath + url; }

document.querySelectorAll('table[id$=-datatable]').forEach(table => {
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
                column.className = 'align-middle w-150px';
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
                        // set size
                        column.className = 'text-center align-middle w-200px';
                        // get column
                        let col = type.shift();
                        // render image
                        column.render = (data, type, row, meta) => {
                            return '<td><img src="' + (byString(row, col) ?? asset('backend-module/assets/images/default.jpg')) + '" class="mh-75px"></td>';
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
    // init datatable
    $(table).DataTable(config);
    // find selects to apply styling
    document.querySelectorAll('#'+table.id+'_wrapper select').forEach(select => {
        // set class
        select.classList.add('selectpicker');
        // init select picker
        $(select).selectpicker();
    });
});
