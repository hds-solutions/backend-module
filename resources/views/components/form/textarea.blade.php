<div class="form-row form-group">
    <label class="col-12 col-md-3 control-label mt-2 mb-0">{{ $label }}</label>
    <div class="col-6">
        <textarea name="{{ $name }}"
            class="form-control resize-none wysiwyg {{ $errors->has($name) ? 'is-danger' : '' }}"
            placeholder="{{ $placeholder }}">{{ isset($resource) && !old($name) ? $resource->$field : old($name) }}</textarea>
    </div>
    @if ($helper)
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="{{ $helper }}"></i>
    </div>
    @endif
</div>