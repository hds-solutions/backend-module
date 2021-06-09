export default class Preview {
    constructor(ele, prevent = true) {
        this.element = $(ele);
        if (this.element.data('preview-init') === false && prevent) return false;
        this.preview = $(this.element.attr('data-preview')).clone();
        this.container = $(this.element.attr('data-preview')).parent();
        this.prepend = $(this.element.attr('data-prepend-preview'));
        this.url_prepend = this.element.attr('data-preview-url-prepend') ?? '';
        this.change();
    }

    change() {
        // capture change event
        this.element.change(e => {
            // empty container
            if (e.originalEvent !== undefined) this.container.empty();
            // process field type
            switch(e.target.type) {
                case 'select-one':
                    // must have option with url attr
                    let option = this.element.find('>option:checked');
                    // validate url
                    if (this._getUrl(option) !== null) {
                        // clone object
                        let preview = this.preview.clone();
                        // set url on preview
                        preview.attr('src', this.url_prepend + this._getUrl(option));
                        // append to container
                        this.container.append(preview);
                        // show preview
                        preview.show();
                    }
                    break;
                case 'select-multiple':
                    // must have option with url attr
                    let options = this.element.find('>option:checked');
                    //
                    options.each((idx, option) => {
                        //
                        option = $(option);
                        // validate url
                        if (this._getUrl(option) === null) return;
                        // clone object
                        let preview = this.preview.clone();
                        // set url on preview
                        preview.attr('src', this.url_prepend + this._getUrl(option));
                        // append to container
                        this.container.append(preview);
                        // show preview
                        preview.show();
                    });
                    break;
                case 'file':
                    // prepend previews
                    if (this.prepend) { this.prepend.find('>option:checked').each((idx, option) => {
                        //
                        option = $(option);
                        // validate url
                        if (this._getUrl(option) === null) return;
                        // clone object
                        let preview = this.preview.clone();
                        // set url on preview
                        preview.attr('src', this.url_prepend + this._getUrl(option));
                        // append to container
                        this.container.append(preview);
                        // show preview
                        preview.show();
                    })}
                    // validate selected file
                    if (!e.target.files || e.target.files.length == 0) return;
                    // read images
                    for (let i=0; i < e.target.files.length; i++) {
                        // open file reader
                        let reader = new FileReader();
                        // capture load event
                        reader.onload = e => {
                            // clone object
                            let preview = this.preview.clone();
                            // set image src
                            preview.attr('src', e.target.result);
                            // append to container
                            this.container.append(preview);
                            // show preview
                            preview.show();
                        }
                        // load image
                        reader.readAsDataURL(e.target.files[i]);
                    }
                    break;
                default: console.log(e.target.type);
            }
        });
        // fire change on select only
        if (this.element[0].type === 'select-one' || this.element[0].type === 'select-multiple') this.element.change();
    }

    _getUrl(option) {
        if (option.dataset === undefined) option = option.get(0);
        let url = option.getAttribute('url') !== null ? option.getAttribute('url') : (option.dataset.url ?? null);
        return url !== null ? url.replace(new RegExp('^'+this.url_prepend), '') : null;
    }

}
