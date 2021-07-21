@include('backend::components.errors')

<x-form-row>
    <x-form-label text="backend::file.file.0" form-label />

    <x-form-row-group>

        <input name="file" type="file" id="upload-image" required
            value="{{ isset($resource) && !old('file') ? $resource->file : old('file') }}" accept="image/*"
            class="form-control custom-file-input {{ $errors->has('name') ? 'is-danger' : '' }}"
            placeholder="@lang('backend::file.file._')" data-preview="#image_preview">

        <label class="custom-file-label" for="upload-image">@lang('backend::file.file._')</label>

    </x-form-row-group>

    <div class="w-100"></div>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4 offset-md-3 offset-lg-2 d-flex justify-content-center flex-wrap">
        <img src="#" id="image_preview" class="m-1 mh-250px rounded" style="display: none;">
    </div>

</x-form-row>

<x-backend-form-controls
    submit="backend::files.save"
    cancel="backend::files.cancel" cancel-route="backend.files" />
