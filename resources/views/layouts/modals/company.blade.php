<div class="modal fade" id="company-selector" tabindex="-1" role="dialog" aria-labelledby="company-selectorTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" action="{{ route('backend.env') }}" class="modal-content">
            @csrf

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="company-selector-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </form>
    </div>
</div>
