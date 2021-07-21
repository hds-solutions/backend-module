<div class="modal fade @if (($show_company_selector ?? false) || ($force_company_selector ?? false)) show @endif" id="company-selector" tabindex="-1" role="dialog"
    aria-labelledby="company-selectorTitle" aria-hidden="{{ $show_company_selector ?? false ? 'false' : 'true' }}"
    @if (($show_company_selector ?? false) || ($force_company_selector ?? false)) data-backdrop="static" @if ($force_company_selector ?? false) data-keyboard="false" @endif @endif>

    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" action="{{ route('backend.env') }}" class="modal-content">
            @csrf

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="company-selector-title">Selector de compañía</h5>
                @if (!($force_company_selector ?? false))
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
                @endif
            </div>

            <div class="modal-body">

                <div class="row mb-2">
                    <div class="col">
                        <x-form-label text="backend::company.nav" class="mt-2 mb-0" />
                    </div>
                    <div class="col-8">
                        <x-form-foreign name="company_id" required
                            :values="backend()->companies()" :default="backend()->company()?->id" />
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col">
                        <x-form-label text="backend::branch.nav" class="mt-2 mb-0" />
                    </div>
                    <div class="col-8">
                        <x-form-foreign name="branch_id" required
                            :values="backend()->branches()" :default="backend()->branch()?->id"

                            filtered-by="#company-selector [name=company_id]" filtered-using="company" />
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col">
                        <x-form-label text="inventory::warehouse.nav" class="mt-2 mb-0" />
                    </div>
                    <div class="col-8">
                        <x-form-foreign name="warehouse_id" required
                            :values="backend()->warehouses()" :default="backend()->warehouse()?->id"

                            filtered-by="#company-selector [name=branch_id]" filtered-using="branch" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <x-form-label text="cash::cash_book.nav" class="mt-2 mb-0" />
                    </div>
                    <div class="col-8">
                        <x-form-foreign name="cash_book_id" required
                            :values="backend()->cashBooks()" :default="backend()->cashBook()?->id"

                            filtered-by="#company-selector [name=company_id]" filtered-using="company" />
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-primary btn-hover-success">Cambiar</button>
                @if (!($force_company_selector ?? false))
                <button type="reset" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                @endif
            </div>

        </form>
    </div>
</div>
