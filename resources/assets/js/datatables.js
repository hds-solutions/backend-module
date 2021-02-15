$(_ => {
    $('table#dataTable').each((idx, ele) => {
        $(ele).DataTable({
            columnDefs: [ { targets: 0, visible: false, searchable: false } ],
        });
    });
    $('table#dataTableReport').each((idx, ele) => {
        let table = $(ele).DataTable({
            // buttons: [ 'copy', 'csv', 'excel', 'pdf' ],
            buttons: [
                { extend: 'copy', className: 'btn btn-sm btn-info' },
                { extend: 'csv', className: 'btn btn-sm btn-info' },
                { extend: 'excel', className: 'btn btn-sm btn-info' },
                { extend: 'pdf', className: 'btn btn-sm btn-info' }
            ],
            columnDefs: [ { targets: 0, visible: false, searchable: false } ],
        });
        //
        table.buttons().container().appendTo($('#report-download'));
    });
});
