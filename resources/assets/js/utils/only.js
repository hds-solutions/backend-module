$(_ => {
    class Only {
        constructor(field, data) {
            this.field = field;
            this.source = $('[name="'+data.field+'"]');
            this.values = data.values;
            this.modifier = data.modifier;
            this.display = [];
            this.field.classList.forEach(className => {
                // save display class names
                if (className.match(/^d-/)) this.display.push(className);
            });
            //
            this.change();
        }

        change() {
            this.source
                // capture change on source
                .change(e => {
                    // remove display
                    this.display.forEach(className => { this.field.classList.remove(className); })
                    // hide by default
                    this.field.classList.add('d-none');
                    // get current value
                    let value = this.source.val() !== null ? this.source.val().trim() : null;
                    // check modifier
                    if (
                        // equals
                        (this.modifier == '=' && this.values.indexOf(value) != -1) ||
                        // lt
                        (this.modifier == '<' && value < this.values[0]) ||
                        // gt
                        (this.modifier == '>' && value > this.values[0])) {
                        // show field
                        this.field.classList.remove('d-none');
                        // append original class names
                        this.display.forEach(className => { this.field.classList.add(className); })
                    }
                })
                // execute change for first time
                .change();
        }
    }

    $('[data-only]').each((idx, ele) => {
        // get only params
        let data = $(ele).data('only');
        let only = [];
        // split fields
        data = data.split('&');
        // foreach fields
        for (let i in data) {
            only[i] = {};
            // find comparator
            if (data[i].match(/\=/)) {
                // split field from values
                data[i] = data[i].split('=');
                // save modifier
                only[i].modifier = '=';
            } else if (data[i].match(/\</)) {
                // split field from values
                data[i] = data[i].split('<');
                // save modifier
                only[i].modifier = '<';
            } else if (data[i].match(/\>/)) {
                // split field from values
                data[i] = data[i].split('>');
                // save modifier
                only[i].modifier = '>';
            }
            // split values
            data[i][1] = data[i][1].split('|');
            // save field name & values
            only[i].field = data[i][0];
            only[i].values = data[i][1];
        }
        // capture compare fields change
        for (let i in only)
            new Only(ele, only[i]);
    });
});
