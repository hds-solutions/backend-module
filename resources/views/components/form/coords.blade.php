<div class="form-row form-group align-items-center">
    <div class="col-11 col-md-8 col-lg-6 offset-md-3 offset-lg-2">
        <input type="text" name="latitude" @if ($required) required @endif
            value="{{ isset($resource) && !old('latitude') ? $resource->latitude : old('latitude') }}"
            style="color: transparent; border: none; width: calc(100% - 30px); height: 100%; display: flex; position: absolute; z-index: -1">
        <input type="text" name="longitude" @if ($required) required @endif
            value="{{ isset($resource) && !old('longitude') ? $resource->longitude : old('longitude') }}"
            class="d-none">
        <div class="embed-responsive h-300px" id="gmap-pin"
            data-latitude="[name='latitude']"
            data-longitude="[name='longitude']"></div>
    </div>

    @if ($helper)
    <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="{{ $helper }}"></i>
    </div>
    @endif

</div>
