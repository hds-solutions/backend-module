@include('backend::components.errors')

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('backend::file.file.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="file" type="file" id="upload-image" required
            value="{{ isset($resource) && !old('file') ? $resource->file : old('file') }}" accept="image/*"
            class="form-control custom-file-input {{ $errors->has('name') ? 'is-danger' : '' }}"
            placeholder="@lang('backend::file.file._')" data-preview="#image_preview">
        <label class="custom-file-label" for="upload-image">@lang('backend::file.file._')</label>
    </div>
    <div class="offset-0 offset-md-3 col-11 col-md-8 col-lg-6 col-xl-4 d-flex justify-content-center">
        <img src="#" id="image_preview" class="my-1 mh-300px rounded" style="display: none;">
    </div>
</div>

<x-backend-form-controls
    submit="backend::files.save"
    cancel="backend::files.cancel" cancel-route="backend.files" />
