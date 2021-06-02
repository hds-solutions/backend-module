<div {{ $attributes->class(['form-row']) }}>
    <div class="offset-0 offset-md-3 offset-lg-2 col-12 col-md-9">
        <button type="submit"
            class="btn btn-success">@lang( $submit ?? 'submit' )</button>
        <a href="{{ route($cancelRoute ?? '/', $cancelRouteParams + (request()->has('only-form') ? [ 'only-form' ] : [])) }}"
            class="btn btn-danger">@lang( $cancel ?? 'cancel' )</a>
    </div>
</div>
