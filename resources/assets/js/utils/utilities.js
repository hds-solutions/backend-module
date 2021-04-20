export function reduce(obj, parent = null) {
    // output
    let output = {};
    // foreach array elements
    for (let key in obj) {
        //
        let element = obj[key];
        // check if element is object
        if (typeof element === 'object' && element !== null && !Array.isArray(element)) {
            // reduce element
            let temp = reduce(element, parent !== null ? parent+'.'+key : key);
            // append elements to current array
            output = Object.assign(output, temp);
        } else if (Array.isArray(element)) {
            //
            let array = [];
            //
            for (let value of element)
                array.push( reduce(value, singular(key)) );
            //
            output[parent !== null ? parent+'.'+key : key] = array;
        } else
            // copy element to output
            output[parent !== null ? parent+'.'+key : key] = element;
    }
    // return reduced output
    return output;
}

export function amount(amount, decimals = 0, fixed = false) {
    // convert to string
    if (typeof amount == 'number') amount = amount.toFixed(decimals);
    // get current value
    amount = amount.replace(/[^0-9\.]/g,'');
    // validate empty value
    if (amount != '') {
        // convert value
        let valArr = amount.split('.');
        valArr[0] = (parseInt(valArr[0],10)).toLocaleString('EN');
        // check if decimals are allowed
        if (decimals > 0) {
            // check for decimals and append empty ones
            if (valArr[1] === undefined && fixed) valArr[1] = '0';
            // check if there is decimals
            if (valArr[1] !== undefined) {
                // crop decimals to max
                valArr[1] = valArr[1].substr(0, decimals);
                // check for fixed and create zeroes
                if (fixed) valArr[1] = (new Number('0.'+valArr[1])).toFixed(decimals).substr(2);
                // remove if no decimals
                if (valArr[1].length == 0) delete valArr[1];
            }
        }
        // join thousand and decimals
        amount = valArr.join('.');
    }
    // remove last dot on non decimal
    if (decimals == 0) amount = amount.replace(/[\.]*$/g, '');
    // return formated amount
    return amount;
}

export function parse(view, object) {
    // foreach reduced values
    for (let key in object) {
        // get value
        let value = object[key];
        // check if value is array
        if (Array.isArray(value)) {
            // find {object.key} container
            let matches = view.match( new RegExp('({'+key+'})(.+?)({\/'+key+'})', 's') );
            // check if matches were found
            if (matches !== null && matches.length == 4) {
                // parsed sub-views
                let parsed = [];
                // foreach values
                for (let sub of value)
                    // replace values inside container
                    parsed.push( parse(matches[2], sub) );
                // replace original container with replaced one
                view = view.replace(matches[0], parsed.join(''));
            }
        } else {
            // replace special ones
            let currencies = view.match( new RegExp('{(currency\:)(.+?)}') );
            if (currencies !== null) {
                // get currency configuration
                let currency = currencies[2].split(','),
                    f_symbol = currency[0],
                    f_amount = currency[1] ?? null,
                    f_decimals = currency[2] ?? null,
                    divide = currency[3] === 'true' || currency[3] === undefined;
                // validate config
                if (currency.length === 1) {
                    f_amount = f_symbol;
                    f_symbol = null;
                }
                // check if object has amount
                if (object[f_amount] !== undefined) {
                    // build symbol to replace
                    let symbol_val = (![ null, 'null' ].includes(f_symbol) ? object[f_symbol]+' ' : '');
                    // build amount to replace
                    let amount_val = amount(
                        // send amount with decimals
                        divide ? object[f_amount] / Math.pow(10, object[f_decimals] ?? 0) : object[f_amount],
                        // send decimals to keep zeroes
                        object[f_decimals] ?? 0,
                        // keep zeroes at the end
                        true
                    );
                    // replace currency with formated one
                    view = view.replace(currencies[0], symbol_val + amount_val);
                }
            }

            // replace {object.key} with value
            view = view.replace('{'+key+'}', value);
        }
    }
    // TODO
    return view;
}

/**
 * Returns the plural of an English word.
 *
 * @export
 * @param {string} word
 * @param {number} [amount]
 * @returns {string}
 */
export function plural(word, amount = undefined) {
    if (amount !== undefined && amount === 1) {
        return word
    }
    const plural = {
        '(quiz)$'               : "$1zes",
        '^(ox)$'                : "$1en",
        '([m|l])ouse$'          : "$1ice",
        '(matr|vert|ind)ix|ex$' : "$1ices",
        '(x|ch|ss|sh)$'         : "$1es",
        '([^aeiouy]|qu)y$'      : "$1ies",
        '(hive)$'               : "$1s",
        '(?:([^f])fe|([lr])f)$' : "$1$2ves",
        '(shea|lea|loa|thie)f$' : "$1ves",
        'sis$'                  : "ses",
        '([ti])um$'             : "$1a",
        '(tomat|potat|ech|her|vet)o$': "$1oes",
        '(bu)s$'                : "$1ses",
        '(alias)$'              : "$1es",
        '(octop)us$'            : "$1i",
        '(ax|test)is$'          : "$1es",
        '(us)$'                 : "$1es",
        '([^s]+)$'              : "$1s"
    }
    const irregular = {
        'move'   : 'moves',
        'foot'   : 'feet',
        'goose'  : 'geese',
        'sex'    : 'sexes',
        'child'  : 'children',
        'man'    : 'men',
        'tooth'  : 'teeth',
        'person' : 'people'
    }
    const uncountable = [
        'sheep',
        'fish',
        'deer',
        'moose',
        'series',
        'species',
        'money',
        'rice',
        'information',
        'equipment',
        'bison',
        'cod',
        'offspring',
        'pike',
        'salmon',
        'shrimp',
        'swine',
        'trout',
        'aircraft',
        'hovercraft',
        'spacecraft',
        'sugar',
        'tuna',
        'you',
        'wood'
    ]
    // save some time in the case that singular and plural are the same
    if (uncountable.indexOf(word.toLowerCase()) >= 0) {
        return word
    }
    // check for irregular forms
    for (const w in irregular) {
        const pattern = new RegExp(`${w}$`, 'i')
        const replace = irregular[w]
        if (pattern.test(word)) {
            return word.replace(pattern, replace)
        }
    }
    // check for matches using regular expressions
    for (const reg in plural) {
        const pattern = new RegExp(reg, 'i')
        if (pattern.test(word)) {
            return word.replace(pattern, plural[reg])
        }
    }
    return word
}

/**
 * Returns the singular of an English word.
 *
 * @export
 * @param {string} word
 * @param {number} [amount]
 * @returns {string}
 */
export function singular(word, amount = undefined) {
    if (amount !== undefined && amount !== 1) {
        return word
    }
    const singular = {
        '(quiz)zes$'             : "$1",
        '(matr)ices$'            : "$1ix",
        '(vert|ind)ices$'        : "$1ex",
        '^(ox)en$'               : "$1",
        '(alias)es$'             : "$1",
        '(octop|vir)i$'          : "$1us",
        '(cris|ax|test)es$'      : "$1is",
        '(shoe)s$'               : "$1",
        '(o)es$'                 : "$1",
        '(bus)es$'               : "$1",
        '([m|l])ice$'            : "$1ouse",
        '(x|ch|ss|sh)es$'        : "$1",
        '(m)ovies$'              : "$1ovie",
        '(s)eries$'              : "$1eries",
        '([^aeiouy]|qu)ies$'     : "$1y",
        '([lr])ves$'             : "$1f",
        '(tive)s$'               : "$1",
        '(hive)s$'               : "$1",
        '(li|wi|kni)ves$'        : "$1fe",
        '(shea|loa|lea|thie)ves$': "$1f",
        '(^analy)ses$'           : "$1sis",
        '((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$': "$1$2sis",
        '([ti])a$'               : "$1um",
        '(n)ews$'                : "$1ews",
        '(h|bl)ouses$'           : "$1ouse",
        '(corpse)s$'             : "$1",
        '(us)es$'                : "$1",
        's$'                     : ""
    }
    const irregular = {
        'move'   : 'moves',
        'foot'   : 'feet',
        'goose'  : 'geese',
        'sex'    : 'sexes',
        'child'  : 'children',
        'man'    : 'men',
        'tooth'  : 'teeth',
        'person' : 'people'
    }
    const uncountable = [
        'sheep',
        'fish',
        'deer',
        'moose',
        'series',
        'species',
        'money',
        'rice',
        'information',
        'equipment',
        'bison',
        'cod',
        'offspring',
        'pike',
        'salmon',
        'shrimp',
        'swine',
        'trout',
        'aircraft',
        'hovercraft',
        'spacecraft',
        'sugar',
        'tuna',
        'you',
        'wood'
    ]
    // save some time in the case that singular and plural are the same
    if (uncountable.indexOf(word.toLowerCase()) >= 0) {
        return word
    }
    // check for irregular forms
    for (const w in irregular) {
        const pattern = new RegExp(`${irregular[w]}$`, 'i')
        const replace = w
        if (pattern.test(word)) {
            return word.replace(pattern, replace)
        }
    }
    // check for matches using regular expressions
    for (const reg in singular) {
        const pattern = new RegExp(reg, 'i')
        if (pattern.test(word)) {
            return word.replace(pattern, singular[reg])
        }
    }
    return word
}
