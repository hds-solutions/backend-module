require('datatables.net-bs4');
require('datatables.net-select-bs4');
// require('datatables.net-buttons/js/buttons.colVis.min.js');
// require('datatables.net-buttons/js/buttons.html5.min.js');
// require('datatables.net-buttons/js/buttons.print.min.js');
// require('pdfmake');
// require('datatables.net-buttons/js/buttons.flash.min.js');
require('datatables.net-buttons-bs4');

import { Container, byString } from './utils/datatables';

$(_ => {
    document.querySelectorAll('table[id$=-datatable]').forEach(table => {
        // check if datatables config exists
        if (window.datatables === undefined) return;
        // get datatable configuration
        let config = window.datatables[table.id] ?? null;
        // check if null
        if (!config) return;
        // get container for current table
        let container = new Container(table.nextElementSibling, config.ajax.url);
        // configure columns
        config.columns.map(column => {
            switch (true) {
                case column.name == 'actions':
                    // set class name
                    column.className = 'align-middle w-150px';
                    column.sortable = false;
                    // render actions using container
                    column.render = (data, type, row, meta) => {
                        return container.render(row);
                    }
                    break;
                case column.render !== undefined:
                    switch (column.render.split(':').shift()) {
                        case 'image':
                            // set size
                            column.className = 'text-center align-middle w-200px';
                            // get column
                            let col = column.render.replace('image:', '');
                            // render image
                            column.render = (data, type, row, meta) => {
                                return '<td><img src="'+(byString(row, col) ?? 'backend-module/assets/images/default.jpg')+'" class="mh-75px"></td>';
                            }
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
        // capture draw callback
        config.drawCallback = e => container.events();
        // init datatable
        $(table).DataTable(config);
    });
});

