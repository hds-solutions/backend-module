<div {{ $attributes->class([
    'col-11 col-md-8 col-lg-6 col-xl-4' => $attributes->get('count', 1) == 1,
    'col-12 col-md-9 col-xl-3' => $attributes->get('count', 1) >= 2,
])->except([ 'row-class', 'count' ]) }}>
    <div class="form-row {{ $attributes->has('row-class') ? $attributes->get('row-class') : '' }}">
        {{ $slot ?? null }}
    </div>
</div>
