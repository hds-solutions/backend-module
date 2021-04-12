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
|   Valid options are:
|     TODO:
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

if (typeof Date.format === 'undefined') {
    Date.prototype.format = function(format) {
        // TODO: format date
        console.debug('TODO: format date using '+format);
        return this.toDateString();
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
