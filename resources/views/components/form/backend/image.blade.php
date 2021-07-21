<x-form-row class="{{ $attributes->get('row-class') }}">
    <x-form-label text="{{ $attributes->get('label') }}" form-label />

    <x-form-row-group>

        <x-form-input-group {{ $attributes->only('prepend') }}>

            <select name="{{ $name.($multiple ? '[]' : '') }}" @if ($required) required @endif
                @if ($filteredBy) data-filtered-by="{{ $filteredBy }}" data-filtered-using="{{ $filteredUsing }}" @endif
                @if ($multiple) multiple @else value="{{ isset($resource) && !old($name) ? $resource->$field : old($name) }}" @endif
                data-preview="#image_preview" class="form-control selectpicker {{ $errors->has($name) ? 'is-danger' : '' }}"
                @if ($attributes->has('placeholder'))
                placeholder="@lang($attributes->get('placeholder', null))"
                data-none-selected-text="@lang($attributes->get('placeholder', null))"
                @endif
                {{ $attributes->except([ 'label', 'prepend' ]) }} >

                @if (!$multiple)
                <option value="" selected
                    @if ($required) disabled hidden @endif>@lang($attributes->get('placeholder', null))</option>
                @endif

                @foreach($images as $image)
                <option value="{{ $image->id }}" url="{{ $image->url }}"
                    {{-- append filtered-by data --}}
                    @if ($filteredBy) data-{{ $filteredUsing }}="{{ $image->pivot->{"{$filteredUsing}_id"} }}" @endif
                    @if (!$multiple)
                        {{-- select if $resource->$field contains $image->id --}}
                        @if ($image->id == (isset($resource) && !old($name) ? $resource->$field : old($name)) && (
                            // check filtered by and ignore if filter doesnt match
                            !$filteredBy || $filteredBy && $image->pivot->{"{$filteredUsing}_id"} == $resource->{"{$filteredUsing}_id"}
                        )) selected @endif
                    @else
                        {{-- select if $resource->$field equals $image->id --}}
                        @if (isset($resource) && $resource->$field->contains($image->id) && (
                            // check filtered by and ignore if filter doesnt match
                            !$filteredBy || $filteredBy && $image->pivot->{"{$filteredUsing}_id"} == $resource->{"{$filteredUsing}_id"}
                        )) selected @endif
                    @endif>{{ $image->name }}</option>
                @endforeach
            </select>

            <div class="input-group-append">
                <label class="btn btn-default btn-hover-secondary mb-0" for="upload">
                    <span class="fas fa-fw fa-cloud-upload-alt"></span>
                    <input type="file" name="{{ $name.($multiple ? '[]' : '') }}" accept="image/*" id="upload"
                        @if ($multiple) multiple @endif
                        class="d-none" data-preview="#image_preview" @if ($multiple) data-prepend-preview="select[name='{{ $name }}[]']" @endif>
                </label>
            </div>

        </x-form-input-group>

    </x-form-row-group>

    @include('backend::components.form.helper')

    <div class="w-100"></div>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4 offset-md-3 offset-lg-2 d-flex justify-content-center flex-wrap">
        <img src="#" id="image_preview" class="m-1 mh-150px rounded" style="display: none;">
    </div>

</x-form-row>
