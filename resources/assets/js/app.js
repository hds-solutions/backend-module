// template
require('bootstrap');
require('bootstrap-daterangepicker');
require('bootstrap-select/js/bootstrap-select.js');
require('startbootstrap-sb-admin-2/js/sb-admin-2.js');
// local plugins
require('./utils/prototypes');
require('./datatables');
require('./tinymce');

$(_ => { $('body>.loader').fadeOut(150); });

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

import Application from './resources/Application';
Application.alias('jQuery', $);

import DateRangePicker from './utils/daterangepicker';
document.querySelectorAll('[daterangepicker]').forEach(element => new DateRangePicker(element));

import Only from './utils/only';
document.querySelectorAll('[data-only]').forEach(element => new Only(element));

import Event from './utils/consoleevent';

import Currency from './utils/currency';
document.querySelectorAll('[data-currency-by]').forEach(currency => new Currency(currency));

import Thousand from './utils/thousand';
document.querySelectorAll('[thousand]').forEach(element => new Thousand(element));

// confirmation modal
import Confirmation from './utils/confirm';
// link buttons to confirmation modal
document.querySelectorAll('[data-confirm]').forEach(button => Confirmation.register(button));

// printables modal
import Printables from './utils/printables';
document.querySelectorAll('[data-printable]').forEach(button => Printables.register(button));

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
document.querySelectorAll('[data-multiple]').forEach(ele => {
    let multiple = new Multiple( ele );
    let instance;
    if (instance = Application.instance(multiple.type))
        instance.multiple( multiple );

    // capture element deletion
    multiple.removed(lineContainer => Application.instance(multiple.type) &&
        // register line deletion
        Application.instance(multiple.type).unregister( lineContainer ));
    // capture element creation
    multiple.new(lineContainer => Application.instance(multiple.type) &&
        // register line creation
        Application.instance(multiple.type).register( lineContainer ));
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

// disable select if is readonly
$('select.selectpicker[readonly]').on('shown.bs.select', e => $(e.target).selectpicker('toggle'));

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

import Foreign from './utils/foreign';
document.querySelectorAll('select>option[value="add::new"]').forEach(option => new Foreign(option));

// helper function to create nodeArrays (not collections)
const nodeArray = (selector, parent=document) => [].slice.call(parent.querySelectorAll(selector)),
    selector = 'input[name="permissions[]"]';

// checkboxes of interest
const allThings = nodeArray(selector);

// global listener
allThings.forEach(checkbox => checkbox.addEventListener('change', e => {
    // get check group container
    let check = e.target,
        group = check.closest('.card');

    // check/unchek children (includes check itself)
    const children = nodeArray(selector, group);
    if (e.isTrusted) children.forEach(child => {
        child.checked = check.checked;
        if (!check.checked) child.indeterminate = false;
    });

    // traverse up from target check
    while (check) {
        // find parent and sibling checkboxes (quick'n'dirty)
        const parent = group.parentElement.closest('.card').querySelector('.card-header input[name="permissions[]"]');
        const siblings = nodeArray(selector, parent.closest('.card').querySelector('.card-body'));

        // get checked state of siblings
        // are every or some siblings checked (using Boolean as test function)
        const checkStatus = siblings.map(check => check.checked);
        const every  = checkStatus.every(Boolean);
        const some = checkStatus.some(Boolean);

        // check parent if all siblings are checked
        // set indeterminate if not all and not none are checked
        parent.checked = every;
        parent.indeterminate = !every && every !== some;

        // prepare for next loop
        group = parent.closest('.card');
        check = check != parent ? parent : false;
    }
}));

const changeEvent = new Event('change');
allThings.forEach(checkbox => changeEvent.fire(checkbox));

//
document.querySelectorAll('[type=submit][formaction-append]').forEach(button => {
    button.addEventListener('click', e => {
        // get form original action
        let url = new URL(button.form.action);
        // foreach params and add them to form action url
        button.getAttribute('formaction-append').split('&').forEach(param => {
            // get param/value pair
            param = param.split('=');
            // append it to url
            url.searchParams.append(param[0], param[1] ?? true);
        });
        // replace form action
        button.form.action = url.href;
    });
});

$('.modal.show').modal('show');
$('#company-selector').on('show.bs.modal', e => {
    // destination modal
    const modal = e.target;
    // button that triggered the modal
    const button = e.relatedTarget;
    // extract info from data-* attributes
    const company = button.dataset.company
    // destination field
    const field = modal.querySelector('[name="company_id"]');

    // replace field value
    for (let option of field.options) {
        // unselect by default
        option.removeAttribute('selected');
        // check if matches company
        if (option.value === company)
            // select option
            option.setAttribute('selected', true);
    }

    // link with select picket plugin
    if (field.classList.contains('selectpicker'))
        // fire refresh event
        $(field).selectpicker('refresh');
    // fire change event on original target
    (new Event('change')).fire(field);
});

document.querySelectorAll('form').forEach(form => {
    const submit_btn = form.querySelectorAll('[type="submit"]');
    if (submit_btn.length) submit_btn.forEach(button => button.addEventListener('click', e => form.classList.add('validated')));
});
