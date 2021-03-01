export default class Visibility {
    constructor(form) {
        this.form = form;
        this.icon = this.form.querySelector( this.form.dataset.icon );
        this.spinner = this.form.querySelector( this.form.dataset.spinner );
        this.init();
    }

    init() {
        // capture form submit
        this.form.addEventListener('submit', e => {
            //
            e.preventDefault();
            // show spinner
            this.icon.classList.add('d-none');
            this.spinner.classList.remove('d-none');
            // get form data
            let data = {};
            this.form.querySelectorAll('input').forEach(input => {
                data[input.name] = input.value;
            });
            // append status change
            data.visible = !(this.form.dataset.visibility == 'true');
            //
            $.ajax({
                method: this.form.method,
                url: this.form.action,
                data: data,
                success: resource => {
                    // update status
                    if (resource.visible !== undefined) this.form.dataset.visibility = resource.visible ? 'true' : 'false';
                    // update color
                    this.icon.parentNode.classList.remove( this.form.dataset.visibility == 'true' ? 'text-muted' : 'text-info' );
                    this.icon.parentNode.classList.add( this.form.dataset.visibility == 'true' ? 'text-info' : 'text-muted' );
                    // update icon
                    this.icon.classList.remove( this.form.dataset.visibility == 'true' ? this.form.dataset.hidden : this.form.dataset.visible );
                    this.icon.classList.add( this.form.dataset.visibility == 'true' ? this.form.dataset.visible : this.form.dataset.hidden );
                    // hide spinner
                    this.spinner.classList.add('d-none');
                    this.icon.classList.remove('d-none');
                }
            });
        });
    }
}
