export default class GMap {
    constructor(element) {
        //
        this.map = null;
        //
        this.marker = null;
        //
        this.layers = [];
        //
        this._element = element;
        //
        this._moveFn = (lat, lon) => {};
    }

    init(withMarker, editable = true) {
        return new Promise((resolve, reject) => {
            //
            this._initMap().then(() => {
                //
                if (withMarker !== false)
                    //
                    this._addMarker(editable === true);
                //
                this._onResize();
                // resolve task
                resolve();
            });
        });
    }

    move(fn) {
        // save custom move function
        this._moveFn = typeof fn == 'function' ? fn : this._moveFn;
    }

    center(onMarker, lat, lon) {
        return new Promise((resolve, reject) => {
            //
            let center = null;
            //
            if ((onMarker || this.marker !== null) && lat === undefined && lon === undefined)
                //
                center = onMarker === true ? this.marker.getPosition() : this.map.getCenter();
            else
                //
                center = new google.maps.LatLng(lat, lon);
            //
            google.maps.event.trigger(this.map, 'resize');
            //
            this.map.panTo(center);
            //
            resolve();
        });
    }

    position(lat, lon, zoom) {
        return new Promise((resolve, reject) => {
            //
            if (this.marker !== null)
                // update marker position
                this.marker.setPosition(new google.maps.LatLng(lat, lon));
            // update zoom
            this.zoom(zoom !== undefined ? zoom : 17);
            // center map on marker
            this.center(this.marker !== null && lat === undefined && lon === undefined, lat, lon).then(resolve);
        });
    }

    zoom(zoom) {
        // update zoom
        this.map.setZoom(zoom);
    }

    addPolygon(polygon) {
        return new Promise((resolve, reject) => {
            //
            polygon.init(this.map).then(() => {
                //
                resolve();
            });
            //
            this.layers.push(polygon);
        });
    }

    getLayers() {
        //
        return this.layers;
    }

    _initMap() {
        return new Promise((resolve, reject) => {
            // inicializamos el mapa
            this.map = new google.maps.Map($(this._element)[0], {
                zoom: 12,
                center: new google.maps.LatLng(-25.3, -57.6),
                mapTypeControl: false,
                streetViewControl: false
            });
            //
            resolve();
        });
    }

    _addMarker(editable) {
        //
        this.marker = new google.maps.Marker({
            position: new google.maps.LatLng(-25.3, -57.6),
            map: this.map,
            draggable: editable,
            title: "Ubicación"
        });
        // FIX: Mobile keyboard hider
        $(this._element).before($('<input type="checkbox" id="dummy_check_map" style="position: absolute; opacity: 0; width: 0; height: 0;" />'));
        this.marker.addListener('mousedown', () => { $('#dummy_check_map').focus(); });
        // capture move event
        this.marker.addListener('mouseup', () => {
            // redirect event
            this._moveFn(this.marker.getPosition().lat(), this.marker.getPosition().lng())
            // center map on marker
            this.map.setCenter(this.marker.getPosition());
        });
        // capture move event
        this.map.addListener('click', e => {
            // move marker
            this.marker.setPosition(e.latLng);
            // redirect event
            this._moveFn(this.marker.getPosition().lat(), this.marker.getPosition().lng())
            // center map on marker
            this.map.setCenter(this.marker.getPosition());
        });
    }

    _onResize() {
        // capture window resize
        google.maps.event.addDomListener(window, 'resize', this.center);
    }
}
