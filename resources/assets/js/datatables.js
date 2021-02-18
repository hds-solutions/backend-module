require('datatables.net-bs4');
require('datatables.net-select-bs4');
// require('datatables.net-buttons/js/buttons.colVis.min.js');
// require('datatables.net-buttons/js/buttons.html5.min.js');
// require('datatables.net-buttons/js/buttons.print.min.js');
// require('pdfmake');
// require('datatables.net-buttons/js/buttons.flash.min.js');
require('datatables.net-buttons-bs4');

class DataTableActions {

    constructor(resource, id) {
        this.resource = resource;
        this.id = id;
    }

    events() {
        //
    }
}

class Container {
    constructor(element, data) {
        this.dom = document.createElement('div');
        this.actions = [];
        this.data = data;

        if (element) {
            element.parentElement.removeChild(element);
            this.dom.appendChild(element);
        }

        this.routes = {
            'route.index':      this.data.route,
            'route.create':     this.data.route+'/create',
            'route.show':       this.data.route+'/:resource:/show',
            'route.edit':       this.data.route+'/:resource:/edit',
            'route.update':     this.data.route+'/:resource:',
            'route.destroy':    this.data.route+'/:resource:',
        };
    }

    render(resource) {
        // save action
        this.actions.push( action = new DataTableActions(resource, id = this.random()) );
        // clone node
        let html = this.dom.cloneNode(true);
        // set referal id
        html.firstChild.dataset.actionId = id;
        // replace routes
        html.querySelectorAll('a[href],form[action]').forEach(element => {
            // get route type
            let route = this.routes[element.getAttribute('href') ?? element.getAttribute('action')] ?? this.routes['route.index'];
            // replace resource
            route = route.replace(':resource:', action.resource.id);
            // update route
            if (element.nodeName = 'A') element.href = route;
            if (element.nodeName = 'FORM') element.action = route;
        });
        // set resource.id references
        html.querySelectorAll('[for],[id]').forEach(element => {
            if ((value = element.getAttribute('for')) !== null)
                element.setAttribute('for', value.replace(':resource:', resource.id));
            if ((value = element.getAttribute('id')) !== null)
                element.setAttribute('id', value.replace('\:resource\:', resource.id));
        });
        // set resource.visible status
        html.querySelectorAll('[data-visibility]').forEach(element => {
            // set visible status
            element.dataset.visibility = resource.visible ? 'true' : 'false';
            // update icon
            let label = element.querySelector('label[for="visible-'+resource.id+'"]>i');
            let newClassList = label.classList;
            label.classList.forEach(className => {
                if (!className.includes(':resource.visible:')) return;
                newClassList.remove(className);
                newClassList.add(className.replace(':resource.visible:', resource.visible ? '' : '-slash'));
            });
            label.classList = newClassList;
        });
        // render
        return html.innerHTML;
    }

    events() {
        this.actions.forEach(action => {
            // TODO: set actions
            // console.debug( document.querySelector('[data-action-id="'+action.id+'"') );
        });
        // empty
        this.actions = [];
    }

    random() {
        // return random string
        return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    }

}

document.querySelectorAll('table[data-route]').forEach(table => {
    //
    let container = new Container(table.nextElementSibling, table.dataset);
    //
    let columns = JSON.parse(table.dataset.columns);
    let datatable = $(table).DataTable({
        processing: true,
        serverSide: true,
        ajax: table.dataset.route,
        searchDelay: 250,
        columns: columns,

        columnDefs: [
            { targets: 0, visible: false, searchable: false },
            {
                targets: columns.length - 1,
                searchable: false,
                render: (data, type, row, meta) => {
                    // console.debug(data, type, row, meta);
                    return container.render(row);
                }
            },
        ],
        drawCallback: e => container.events(),
        // buttons: [
        //     { extend: 'copy', className: 'btn btn-sm btn-info' },
        //     { extend: 'csv', className: 'btn btn-sm btn-info' },
        //     { extend: 'excel', className: 'btn btn-sm btn-info' },
        //     { extend: 'pdf', className: 'btn btn-sm btn-info' }
        // ],

    });
    // append buttons
    // datatable.buttons().container().appendTo($('#report-download'));
});

// $(_ => {
//     $('table#dataTable').each((idx, ele) => {
//         $(ele).DataTable({
//             columnDefs: [ { targets: 0, visible: false, searchable: false } ],
//         });
//     });
//     $('table#dataTableReport').each((idx, ele) => {
//         let table = $(ele).DataTable({
//             // buttons: [ 'copy', 'csv', 'excel', 'pdf' ],
//             buttons: [
//                 { extend: 'copy', className: 'btn btn-sm btn-info' },
//                 { extend: 'csv', className: 'btn btn-sm btn-info' },
//                 { extend: 'excel', className: 'btn btn-sm btn-info' },
//                 { extend: 'pdf', className: 'btn btn-sm btn-info' }
//             ],
//             columnDefs: [ { targets: 0, visible: false, searchable: false } ],
//         });
//         //
//         table.buttons().container().appendTo($('#report-download'));
//     });
// });
