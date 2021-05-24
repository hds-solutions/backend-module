<div {{ $attributes->class([
    'col-11 col-md-8 col-lg-6 col-xl-4' => $attributes->get('count', 1) == 1,
    'col-12 col-md-9 col-xl-3' => $attributes->get('count', 1) >= 2,
])->except('count') }}>
    <div class="form-row">
        {{ $slot ?? null }}
    </div>
</div>
