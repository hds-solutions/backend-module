<div class="row">
    <div class="col">

    @if ($resource->isDrafted() || $resource->isInvalid())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_Prepare }}">
            <button type="submit"
                data-confirm="@lang('backend/document.prepareIt._', [ 'document' => $resource->name ?? $resource->description ?? 'document' ])?"
                data-text="@lang('backend/document.prepareIt.?', [ 'document' => $resource->name ?? $resource->description ?? 'document' ])"
                data-accept="@lang('backend/document.prepareIt.0')"
                class="btn btn-lg btn-info">@lang('backend/document.prepareIt.0')</button>
        </form>
    @endif

    @if ($resource->isDrafted() || $resource->isInProgress() || $resource->isRejected())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_Approve }}">
            <button type="submit"
                data-confirm="@lang('backend/document.approveIt._', [ 'document' => $resource->name ?? $resource->description ?? 'document' ])?"
                data-text="@lang('backend/document.approveIt.?', [ 'document' => $resource->name ?? $resource->description ?? 'document' ])"
                data-accept="@lang('backend/document.approveIt.0')"
                class="btn btn-lg btn-success">@lang('backend/document.approveIt.0')</button>
        </form>
    @endif

    @if ($resource->isDrafted() || $resource->isInProgress() || $resource->isApproved())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_Reject }}">
            <button type="submit"
                data-confirm="@lang('backend/document.rejectIt._', [ 'document' => $resource->name ?? $resource->description ?? 'document' ])?"
                data-text="@lang('backend/document.rejectIt.?', [ 'document' => $resource->name ?? $resource->description ?? 'document' ])"
                data-accept="@lang('backend/document.rejectIt.0')"
                class="btn btn-lg btn-danger">@lang('backend/document.rejectIt.0')</button>
        </form>
    @endif

    @if ($resource->isDrafted() || $resource->isInProgress() || $resource->isApproved())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_Complete }}">
            <button type="submit"
                data-confirm="@lang('backend/document.completeIt._', [ 'document' => $resource->name ?? $resource->description ?? 'document' ])?"
                data-text="@lang('backend/document.completeIt.?', [ 'document' => $resource->name ?? $resource->description ?? 'document' ])"
                data-accept="@lang('backend/document.completeIt.0')"
                class="btn btn-lg btn-success">@lang('backend/document.completeIt.0')</button>
        </form>
    @endif

    @if ($resource->isCompleted() && $resource->canCloseIt())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_Close }}">
            <button type="submit"
                data-confirm="@lang('backend/document.closeIt._', [ 'document' => $resource->name ?? $resource->description ?? 'document' ])?"
                data-text="@lang('backend/document.closeIt.?', [ 'document' => $resource->name ?? $resource->description ?? 'document' ])"
                data-accept="@lang('backend/document.closeIt.0')"
                class="btn btn-lg btn-danger">@lang('backend/document.closeIt.0')</button>
        </form>
    @endif

    @if ($resource->isClosed())
        <form method="POST" action="{{ route($route, $resource) }}"
            enctype="multipart/form-data" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="{{ Document::ACTION_ReOpen }}">
            <button type="submit"
                data-confirm="@lang('backend/document.reOpenIt._', [ 'document' => $resource->name ?? $resource->description ?? 'document' ])?"
                data-text="@lang('backend/document.reOpenIt.?', [ 'document' => $resource->name ?? $resource->description ?? 'document' ])"
                data-accept="@lang('backend/document.reOpenIt.0')"
                class="btn btn-lg btn-warning">@lang('backend/document.reOpenIt.0')</button>
        </form>
    @endif

    </div>
</div>