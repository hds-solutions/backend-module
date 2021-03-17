import Confirmation from './confirm';
import Visibility from './visibility';

export function byString(o, s) {
    s = s.replace(/\[(\w+)\]/g, '.$1'); // convert indexes to properties
    s = s.replace(/^\./, '');           // strip a leading dot
    var a = s.split('.');
    for (var i = 0, n = a.length; i < n; ++i) {
        var k = a[i];
        if (o !== null && k in o) {
            o = o[k];
        } else {
            return;
        }
    }
    return o;
}

class DataTableActions {

    constructor(resource, id) {
        this.resource = resource;
        this.id = id;
    }

    events() {
        //
    }
}

export class Container {
    constructor(element, route) {
        this.dom = document.createElement('div');
        this.actions = [];

        if (element) {
            element.parentElement.removeChild(element);
            this.dom.appendChild(element);
        }

        this.routes = {
            'route.index':      route,
            'route.create':     route+'/create',
            'route.show':       route+'/:resource:',
            'route.edit':       route+'/:resource:/edit',
            'route.update':     route+'/:resource:',
            'route.destroy':    route+'/:resource:',
        };
    }

    render(resource) {
        //
        let id, action;
        // save action
        this.actions.push( action = new DataTableActions(resource, id = this.random() ) );
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
            if (element.nodeName == 'A') element.href = route;
            if (element.nodeName == 'FORM') element.action = route;
        });
        // set resource.id references
        html.querySelectorAll('[for],[id]').forEach(element => {
            let value;
            if ((value = element.getAttribute('for')) !== null)
                element.setAttribute('for', value.replace(':resource:', resource.id));
            if ((value = element.getAttribute('id')) !== null)
                element.setAttribute('id', value.replace('\:resource\:', resource.id));
        });
        // set resource.visible status
        html.querySelectorAll('[data-visibility]').forEach(element => {
            // set visible status
            element.dataset.visibility = resource.visible ? 'true' : 'false';
            // update label color
            let label = element.querySelector('label[for="visible-'+resource.id+'"]');
            let labelClassList = label.classList;
            label.classList.forEach(className => {
                if (!className.includes(':resource.visible:')) return;
                labelClassList.remove(className);
                labelClassList.add(className.replace(':resource.visible:', resource.visible ? 'info' : 'muted'));
            });
            label.classList = labelClassList;
            // update icon
            let icon = label.querySelector('i');
            let iconClassList = icon.classList;
            icon.classList.forEach(className => {
                if (!className.includes(':resource.visible:')) return;
                iconClassList.remove(className);
                iconClassList.add(className.replace(':resource.visible:', resource.visible ? '' : '-slash'));
            });
            icon.classList = iconClassList;
        });
        // parse resource values and render
        return this.parse(html.innerHTML, resource);
    }

    parse(html, resource, root = 'resource') {
        //
        let matches = html.match(/\{[\w.]*\}((\?\?)\{[\w.]*\})*(\?\?)\{[\w.]*\}/g);
        // replace optionals
        for (let i in matches) {
            //
            let match = matches[i],
                found = false;
            // split match
            match.split('??').map(m => m.replace('{', '').replace('}', '')).forEach(field => {
                // check flag
                if (found) return;
                // split field from resource
                let [ r, f ] = field.split('.');
                // check if field exists and has value
                if (resource[f] !== undefined && resource[f] !== null) {
                    // replace match with value
                    html = html.replaceAll(match, resource[f]);
                    // change flag
                    found = true;
                }
            });
        }

        // replace resource attributes
        for (let value in resource) {
            // check nested objects
            if (typeof resource[value] == 'object')
                // parse nested object
                html = this.parse(html, resource[value], root+'.value');
            // parse resource value
            html = html.replaceAll('{'+root+'.'+value+'}', resource[value]);
        }
        // return parsed html
        return html;
    }

    events() {
        this.actions.forEach(action => {
            // get actions container
            let container = document.querySelector('[data-action-id="'+action.id+'"');
            // check if container exists
            if (container === null) return;
            // enable tooltips
            $(container).find('[data-toggle="tooltip"]').tooltip();
            // capture confirm events
            container.querySelectorAll('[data-confirm]').forEach(button => Confirmation.button(button));
            // capture visibility events
            container.querySelectorAll('[data-visibility]').forEach(visible => new Visibility(visible));
        });
        // empty registered actions
        this.actions = [];
    }

    random() {
        // return random string
        return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    }

}