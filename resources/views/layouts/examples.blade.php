@php
    use HDSSolutions\Finpar\Models\{ File, CashLine, Product, Line, Type, Family, Brand, Model };

    $images = File::images()->get();
    $product = Product::find( request('product', 3) );
@endphp

<form class="mb-5">

    <h4 class="mt-4">Simple label</h4>
    <x-form-label text="label text"/>

    <h4 class="mt-4">Simple input</h4>
    <x-form-input name="text"
        placeholder="Simple input" />
    <x-form-input name="number" type="number"
        placeholder="Simple input type=number" />
    <x-form-input name="date" type="date"
        placeholder="Simple input type=date" />

    <x-form-amount name="amount"
        placeholder="Simple amount" />

    <x-form-boolean name="boolean"
        placeholder="Simple boolean" />

    <x-form-text-area name="text-area"
        value="value (overriden if element content exists)"
        placeholder="Simple text-area" />

    <x-form-select name="select"
        :values="CashLine::CASH_TYPES"
        :default="CashLine::CASH_TYPE_Difference"
        placeholder="Simple select" />

    <x-form-foreign name="brand_id"
        :values="Brand::all()"
        foreign="brands"
        show="[created_at] name"
        error="example error"

        request="brand"
        {{-- default="1" --}}

        foreign-add-label="products-catalog::brands.add"
        label="products-catalog::product.brand_id.0"
        placeholder="products-catalog::product.brand_id._"
        helper="products-catalog::product.brand_id.?" />

    <x-form-foreign name="model_id"
        :values="Model::all()"
        foreign="models"
        show="[created_at] name"

        request="model"

        filtered-by="[name=brand_id]" filtered-using="brand"

        foreign-add-label="add label text"
        label="test-foreign-label"
        placeholder="Simple foreign"
        helper="Example helper text" />

    <h4 class="mt-4">Form row with input</h4>
    <x-form-row>
        <x-form-label text="label text" form-label/>

        <x-form-row-group>

            <x-form-input-group>
                <x-form-input name="number" type="number"
                    placeholder="Form row input type=number" />
            </x-form-input-group>

        </x-form-row-group>

    </x-form-row>

    <x-form-row>
        <x-form-label text="label text" form-label/>

        <x-form-row-group count="2">

            <x-form-input-group>
                <x-form-input name="number2"
                    placeholder="Form row input" />
            </x-form-input-group>

        </x-form-row-group>

        <x-form-row-group count="2" class="offset-md-3 offset-lg-2 offset-xl-0 mt-2 mt-xl-0">

            <x-form-input-group>
                <x-form-input name="number3" type="date"
                    placeholder="Form row input type=date" />
            </x-form-input-group>

        </x-form-row-group>

    </x-form-row>

    <x-form-row>
        <x-form-label text="label text" form-label/>

        <x-form-row-group count="3">

            <x-form-input-group>
                <x-form-input name="number2"
                    placeholder="Form row text" />
            </x-form-input-group>

        </x-form-row-group>

        <x-form-row-group count="3" class="offset-md-3 offset-lg-2 offset-xl-0 mt-2 mt-xl-0">

            <x-form-input-group>
                <x-form-input name="number3"
                    placeholder="Form row text 2" />
            </x-form-input-group>

        </x-form-row-group>

        <x-form-row-group count="3" class="offset-md-3 offset-lg-2 offset-xl-0 mt-2 mt-xl-0">

            <x-form-input-group>
                <x-form-input name="number3" type="number"
                    placeholder="Form row input type=number" />
            </x-form-input-group>

        </x-form-row-group>

    </x-form-row>

    <x-form-row>
        <x-form-label text="label text" form-label/>

        <x-form-row-group>

            <x-form-input-group>
                <x-form-select name="select"
                    :values="CashLine::CASH_TYPES"
                    placeholder="Form row with select" />
            </x-form-input-group>

        </x-form-row-group>

    </x-form-row>

    <h4 class="mt-4">Backend &lt;x-fields&gt;</h4>
    <x-backend-form-text name="name" required
        :resource="$product"
        label="test-text-label"
        helper="Example helper text"
        placeholder="Backend text" />
    <x-backend-form-date name="test-date" required
        label="test-date-label"
        helper="Example helper text"
        placeholder="Backend date" />
    <x-backend-form-number name="test-number" required
        label="test-number-label"
        helper="Example helper text"
        placeholder="Backend number" />
    <x-backend-form-email name="test-email" required
        label="test-email-label"
        helper="Example helper text"
        placeholder="Backend email" />
    <x-backend-form-hidden name="test-hidden" required
        label="test-hidden-label"
        helper="Example helper text"
        placeholder="Backend hidden" />
    <x-backend-form-textarea name="test-textarea" required
        label="test-textarea-label"
        value="value"
        placeholder="Backend textarea"
        helper="Example helper text" />
    <x-backend-form-textarea name="description" required
        :resource="$product"
        label="test-textarea-label"
        default="default value"
        wysiwyg

        placeholder="Backend textarea with WYSIWYG editor"
        helper="Example helper text">

        {{-- content value with <b>wisiwyg</b> <i>editor</i> --}}

    </x-backend-form-textarea>

    <x-backend-form-amount name="test-amount" required
        label="test-amount-label"
        placeholder="Backend amount"
        helper="Example helper text" />

    <x-backend-form-amount name="test-amount" required
        label="test-amount-label"
        placeholder="Backend amount"
        helper="Example helper text">

        <x-backend-form-amount name="test-amount2" secondary
            label="test-amount-label"
            placeholder="Backend amount" />

    </x-backend-form-amount>

    <x-backend-form-boolean name="test-boolean" required
        label="test-boolean-label"
        placeholder="Backend boolean"
        helper="Example helper text" />

    <x-backend-form-select name="select" required
        :values="CashLine::CASH_TYPES"
        :resource="CashLine::find(142)" field="cash_type"
        :default="CashLine::CASH_TYPE_Difference"

        label="test-select-label"
        placeholder="Backend select"
        helper="Example helper text" />

    <x-backend-form-foreign name="line_id"
        :resource="$product"
        :values="Line::all()"
        foreign="lines"
        show="[created_at] name"
        request="line"

        foreign-add-label="add label text"
        label="test-foreign-label"
        placeholder="Backend foreign"
        helper="Example helper text" />

    <x-backend-form-foreign name="family_id"
        :resource="$product"
        :values="$families = Family::all()"
        foreign="families"
        show="[created_at] name"
        request="family"

        foreign-add-label="add label text"
        label="test-foreign-label"
        placeholder="Backend foreign"
        helper="Example helper text">

        <x-backend-form-foreign name="sub_family_id" secondary
            :resource="$product"
            :values="$families->pluck('subFamilies')->flatten()"
            foreign="sub_families"
            show="[created_at] name"
            request="sub_family"

            filtered-by="[name=family_id]" filtered-using="family"
            data-filtered-keep-id="true"

            foreign-add-label="products-catalog::sub_families.add"
            label="test-foreign-label"
            placeholder="Backend foreign"
            helper="Example helper text" />

    </x-backend-form-foreign>

    <x-backend-form-image name="images" multiple
        :images="$images"
        label="test-image-label"
        placeholder="Backend image"
        helper="Example helper text" />

</form>
