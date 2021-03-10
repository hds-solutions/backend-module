//
require('bootstrap');
//
require('bootstrap-select/js/bootstrap-select.js');
//
require('startbootstrap-sb-admin-2/js/sb-admin-2.js');

//
require('./datatables');
require('./utils/only');
// require('./utils/thousand');
// init TinyMCE
require('./tinymce');

$(_ => { $('body>.loader').fadeOut(150); });

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

import Currency from './utils/currency';
document.querySelectorAll('[data-currency-by]').forEach(currency => new Currency(currency));

import Thousand from './utils/thousand';
document.querySelectorAll('[thousand]').forEach(element => new Thousand(element));

// confirmation modal
import Confirmation from './utils/confirm';
// link buttons to confirmation modal
document.querySelectorAll('[data-confirm]').forEach(button => Confirmation.button(button));

// previews
import Preview from './utils/preview';
$('[data-preview]').each((idx, ele) => {
    new Preview(ele);
});

//
import Filtered from './utils/filtered';
$('[data-filtered-by]').each((idx, ele) => {
    new Filtered(ele);
});

//
import Multiple from './utils/multiple';
$('[data-multiple]').each((idx, ele) => {
    let multiple = new Multiple( ele );

    // extra funtionality for intentory line
    if ( multiple.multiple[0].classList.contains('inventory-line-container') )
        // capture element creation
        multiple.new(element => element.querySelectorAll('select').forEach(
            // capture change
            select => select.addEventListener('change', e => {
                // build data for the request
                let data = { _token: document.querySelector('[name="csrf-token"]').getAttribute('content') }, option;
                data.warehouse = document.querySelector('[name="warehouse_id"]').selectedOptions[0].value;
                // check if no warehouse was selected
                if (!data.warehouse) return;
                if ((option = element.querySelector('[name="lines[product_id][]"]').selectedOptions[0]).value) data.product = option.value;
                if ((option = element.querySelector('[name="lines[variant_id][]"]').selectedOptions[0]).value) data.variant = option.value;
                if ((option = element.querySelector('[name="lines[locator_id][]"]').selectedOptions[0]).value) data.locator = option.value;
                // request current stock quantity
                $.ajax({
                    method: 'POST',
                    url: '/backend/inventory/stock',
                    data: data,
                    // update current stock for product+variant on locator
                    success: data => element.querySelector('[name="lines[current][]"]').value = data.stock
                });
            })
        ));

    // extra funtionality for pricechange line
    if ( multiple.multiple[0].classList.contains('pricechange-line-container') )
        // capture element creation
        multiple.new(element => element.querySelectorAll('select').forEach(
            // capture change
            select => select.addEventListener('change', e => {
                // build data for the request
                let data = { _token: document.querySelector('[name="csrf-token"]').getAttribute('content') }, option;
                // check if no warehouse was selected
                if ((option = element.querySelector('[name="lines[product_id][]"]').selectedOptions[0]).value) data.product = option.value;
                if ((option = element.querySelector('[name="lines[variant_id][]"]').selectedOptions[0]).value) data.variant = option.value;
                // request current price quantity
                $.ajax({
                    method: 'POST',
                    url: '/backend/pricechanges/price',
                    data: data,
                    // update current price for product+variant on locator
                    success: data => element.querySelector('[name="lines[current][]"]').value = data.price
                });
            })
        ));
});

//
import Visibility from './utils/visibility';
document.querySelectorAll('[data-visibility]').forEach(visible => new Visibility(visible));

//
import Random from './utils/random';
$('[data-random]').each((idx, ele) => { new Random( ele ); });

// // gmap on coverages
import GMap from './utils/gmap';
// import Polygon from './polygon';
// $('#gmap-layer').each((idx, ele) => {
//     // create gmap obkect
//     let gmap = new GMap(ele);
//     // init map
//     gmap.init(false).then(e => {
//         // get other layers
//         let others = JSON.parse($('input[name="others"]').val());
//         if (others.length > 0) for (let i in others)
//             gmap.addPolygon( new Polygon({ coords: others[i], color: '333' }) );
//         // get layer
//         let layer = $('input[name="layer"]').val();
//         // parse layer data
//         layer = layer.length == 0 ? [
//             [ -25.28, -57.60 ],
//             [ -25.28, -57.65 ],
//             [ -25.32, -57.65 ],
//             [ -25.32, -57.60 ]
//         ] : JSON.parse(layer);
//         // create polygon
//         let polygon = new Polygon({ coords: layer, color: '4a8', editable: true });
//         // capture polygon edit event
//         polygon.edit(e => {
//             // save new data to input
//             $('input[name="layer"]').val( JSON.stringify( polygon.getCoords() ) );
//         });
//         // add layer to map
//         gmap.addPolygon( polygon );
//     });
// });

$('#gmap-pin').each((idx, ele) => {
    // get fields
    let latitude = $($(ele).data('latitude')),
        longitude = $($(ele).data('longitude'));
    // create gmap object
    let gmap = new GMap(ele);
    // capture move event
    gmap.move((lat, lng) => {
        // update fields
        latitude.val(Math.round(lat * 100000000) / 100000000);
        longitude.val(Math.round(lng * 100000000) / 100000000);
        // // check covers
        // covers(0, {
        //     lat: Math.round(lat * 100000000) / 100000000,
        //     lng: Math.round(lng * 100000000) / 100000000,
        // }).then(covers => updateProceed(covers));
    });
    // initialize map
    gmap.init(true).then(e => {
        // set position
        gmap.position(latitude.val().length > 0 ? latitude.val() : -25.3, longitude.val().length > 0 ? longitude.val() : -57.6, 13);
    });
});

$("a[data-clipboard]").click(e => {
    e.preventDefault();
    let target = $(e.target).closest('a');
    let link = target.attr('href');
    // save to clipboard
    navigator.clipboard.writeText(link);
    // show tooltip
    target.attr('title', 'Copiado al portapapeles!');
    target.tooltip('show');
});

import Event from './utils/consoleevent';
document.querySelectorAll('[data-linked-with]').forEach(ele => {
    // get parent element
    let parent = document.querySelector(ele.dataset.linkedWith);
    // get relations
    ele.relations = [];
    for (let relation of ele.dataset.linkedUsing.split('|')) {
        // get relation values
        relation = relation.split(':');
        // save relation values
        ele.relations[ relation[1] ] = {
            match: relation[0],
            values: ele.dataset[ relation[1] ].length > 0 ? ele.dataset[ relation[1] ].split(',') : [],
        };
    }

    // capture change on parent
    parent.addEventListener('change', e => {
        // hide by default
        ele.classList.add('d-none');
        // remove required
        ele.querySelector('input,select,textarea').removeAttribute('required', '');
        // get selected option
        let option = e.target.options[ e.target.selectedIndex ];
        // check matches
        for (let relation in ele.relations) {
            // get relation data
            let data = ele.relations[ relation ];
            // check if matches relation
            if (data.values.includes( option.dataset[ data.match ] )) {
                // show element
                ele.classList.remove('d-none');
                // add required
                ele.querySelector('input,select,textarea').setAttribute('required', '');
                // exit
                return;
            }
        }
    });

    // fire change event on parent
    (new Event('change')).fire(parent);
});

document.querySelectorAll('[type="file"]').forEach(field => {
    // check if has custom label
    if (!field.labels.length || field.labels[0].dataset.showFileName !== 'true') return;
    // save original label
    field.labels[0].oText = field.labels[0].textContent;
    // capture change event
    field.addEventListener('change', e => {
        // build label
        let text = '';
        // foreach selected files
        Array.from(e.target.files).forEach(file => text += file.name+', ');
        // set file name to label
        field.labels[0].textContent = text.slice(0, -2);
    });
});

// tooltips
$('[data-toggle="tooltip"]').tooltip();

import Test from './utils/test';
document.querySelectorAll('select>option[value="add::new"]').forEach(option => new Test(option));