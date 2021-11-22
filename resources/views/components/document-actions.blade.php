<div class="row mt-5">
    <div class="col text-right">

    @if ($resource->isDrafted() || $resource->isInvalid())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_Prepare }}">
            <button type="submit"
                data-confirm="@lang('backend::document.prepareIt._', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])?"
                data-text="@lang('backend::document.prepareIt.?', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])"
                data-accept="@lang('backend::document.prepareIt.0')"
                data-accept-class="btn-outline-secondary btn-hover-primary"
                class="btn btn-lg btn-outline-primary">@lang('backend::document.prepareIt.0')</button>
        </form>
    @endif

    @if ($resource->isDrafted() || $resource->isInProgress() || $resource->isRejected())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_Approve }}">
            <button type="submit"
                data-confirm="@lang('backend::document.approveIt._', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])?"
                data-text="@lang('backend::document.approveIt.?', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])"
                data-accept="@lang('backend::document.approveIt.0')"
                data-accept-class="btn-outline-secondary btn-hover-success"
                class="btn btn-lg btn-outline-primary btn-hover-success">@lang('backend::document.approveIt.0')</button>
        </form>
    @endif

    @if ($resource->isDrafted() || $resource->isInProgress() || $resource->isApproved())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_Reject }}">
            <button type="submit"
                data-confirm="@lang('backend::document.rejectIt._', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])?"
                data-text="@lang('backend::document.rejectIt.?', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])"
                data-accept="@lang('backend::document.rejectIt.0')"
                data-text-type="danger"
                data-accept-class="btn-outline-danger btn-hover-danger"
                data-cancel-class="btn-danger"
                data-modal-type="danger"
                class="btn btn-lg btn-outline-primary btn-hover-danger">@lang('backend::document.rejectIt.0')</button>
        </form>
    @endif

    @if ($resource->isDrafted() || $resource->isInProgress() || $resource->isApproved())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_Complete }}">
            <button type="submit"
                data-confirm="@lang('backend::document.completeIt._', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])?"
                data-text="@lang('backend::document.completeIt.?', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])"
                data-accept="@lang('backend::document.completeIt.0')"
                data-accept-class="btn-outline-secondary btn-hover-primary"
                class="btn btn-lg btn-outline-primary">@lang('backend::document.completeIt.0')</button>
        </form>
    @endif

    @if ($resource->isCompleted() && $resource->canCloseIt())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_Close }}">
            <button type="submit"
                data-confirm="@lang('backend::document.closeIt._', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])?"
                data-text="@lang('backend::document.closeIt.?', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])"
                data-accept="@lang('backend::document.closeIt.0')"
                class="btn btn-lg btn-outline-primary">@lang('backend::document.closeIt.0')</button>
        </form>
    @endif

    @if ($resource->isClosed())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_ReOpen }}">
            <button type="submit"
                data-confirm="@lang('backend::document.reOpenIt._', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])?"
                data-text="@lang('backend::document.reOpenIt.?', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])"
                data-accept="@lang('backend::document.reOpenIt.0')"
                class="btn btn-lg btn-outline-primary">@lang('backend::document.reOpenIt.0')</button>
        </form>
    @endif

    @if (($resource->isCompleted() || $resource->isRejected()) && $resource->canVoidIt())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_Void }}">
            <button type="submit"
                data-confirm="@lang('backend::document.voidIt._', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])?"
                data-text="@lang('backend::document.voidIt.?', [ 'document' => $resource->name ?? $resource->description ?? $title ?? 'document' ])"
                data-accept="@lang('backend::document.voidIt.0')"
                data-text-type="danger"
                data-accept-class="btn-outline-danger btn-hover-danger"
                data-cancel-class="btn-danger"
                data-modal-type="danger"
                class="btn btn-lg btn-outline-primary btn-hover-danger">@lang('backend::document.voidIt.0')</button>
        </form>
    @endif

    </div>
</div>
