import SimpleDateFormat from "@riversun/simple-date-format";

/*
|--------------------------------------------------------------------------
| Element prototypes
|--------------------------------------------------------------------------
|
| Element.empty()
|   Removes all childs from element
|
*/
if (typeof Element.prototype.empty === 'undefined') {
    Object.defineProperty(Element.prototype, 'empty', {
        configurable: true,
        enumerable: false,
        value: function() { while(this.lastElementChild) this.removeChild(this.lastElementChild) },
    });
}

/*
|--------------------------------------------------------------------------
| Date prototypes
|--------------------------------------------------------------------------
|
| Date.reset()
|   Resets Date object
|
| Date.addDays()
|   Adds/Removes days from date
|
| Date.format()
|   Returns a string of date in the specified format.
|   Valid options are: (see PHP datetime format)
|
*/
if (typeof Date.reset === 'undefined') {
    Date.prototype.reset = function() {
        let newDate = new Date(this.timeStamp);
        this.setFullYear    (newDate.getFullYear());
        this.setMonth       (newDate.getMonth());
        this.setDate        (newDate.getDate());
        this.setHours       (newDate.getHours());
        this.setMinutes     (newDate.getMinutes());
        this.setSeconds     (newDate.getSeconds());
        this.setMilliseconds(newDate.getMilliseconds());
    }
}

if (typeof Date.addDays === 'undefined') {
    Date.prototype.addDays = function(days) {
        this.timeStamp = this[Symbol.toPrimitive]('number');
        let daysInMiliseconds = (days * (1000 * 60 * 60 * 24));
        this.timeStamp = this.timeStamp + daysInMiliseconds;
        this.reset();
    }
}

if (typeof Date.months === 'undefined') {
    Object.defineProperty(Date, 'months', {
        enumerable: true,
        writable: false,
        value: {
            'Ene': 'Enero',
            'Feb': 'Febrero',
            'Mar': 'Marzo',
            'Abr': 'Abril',
            'May': 'Mayo',
            'Jun': 'Junio',
            'Jul': 'Julio',
            'Ago': 'Agosto',
            'Sep': 'Septiembre',
            'Oct': 'Octubre',
            'Nov': 'Noviembre',
            'Dic': 'Diciembre',
        }
    });
}

if (typeof Date.format === 'undefined') {
    const sdf = new SimpleDateFormat;
    Date.prototype.format = function(format) {
        // PHP DateTime to JS DateTime
        let replacements = {
            'Y': 'þþ', // temp value >> yyyy
            'y': 'µµ', // temp value >> yy

            'n': '¤¤', // temp value >> M
            'm': 'ßß', // temp value >> MM
            'F': 'œœ', // temp value >> MMM
            'M': 'œœ', // temp value >> MMM

            'j': 'øø', // temp value >> d
            'd': '€€', // temp value >> dd

            'A': 'a',
            'G': 'ëë', // temp value >> H
            'H': 'ää', // temp value >> HH
            'D': 'E',
            'g': 'ææ', // temp value >> h
            'h': 'öö', // temp value >> hh
            'i': 'mm',
            's': 'ss',
            'v': 'SSS',
            'O': 'Z',
            'o': '¶¶', // temp value >> X
            'P': 'çç', // temp value >> XXX

            // replace temp values to final value
            'þþ': 'yyyy',
            'µµ': 'yy',
            '¤¤': 'M',
            'ßß': 'MM',
            'œœ': 'MMM',
            'øø': 'd',
            '€€': 'dd',
            'ëë': 'H',
            'ää': 'HH',
            'ææ': 'h',
            'öö': 'hh',
            '¶¶': 'X',
            'çç': 'XXX',
        }
        // do replacements
        for (let search in replacements) format = format.replaceAll(search, replacements[search]);
        // format date using SimpleDateFormat
        return sdf.formatWith(format, this);
    }
}

/*
|--------------------------------------------------------------------------
| Array prototypes
|--------------------------------------------------------------------------
|
| Array.empty()
|   Removes all elements from current array
|
*/
if (typeof Array.empty === 'undefined') {
    Array.prototype.empty = function() {
        while(this.length) this.pop();
    }
}
if (typeof Array.first === 'undefined') {
    Array.prototype.first = function() {
        return this.length > 0 ? this[0] : null;
    }
}
if (typeof Array.last === 'undefined') {
    Array.prototype.last = function() {
        return this.length > 0 ? this[ this.length - 1 ] : null;
    }
}

/*
|--------------------------------------------------------------------------
| HTMLOptionsCollection prototypes
|--------------------------------------------------------------------------
|
| HTMLOptionsCollection.empty()
|   Removes all elements from current array
|
*/
if (typeof HTMLOptionsCollection.forEach === 'undefined') {
    HTMLOptionsCollection.prototype.forEach = function(callable) {
        Array.prototype.forEach.call(this, callable);
    }
}
