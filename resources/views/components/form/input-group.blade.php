<div {{ $attributes->class([
    'input-group',
    'col'   => !str_contains($attributes->get('class'), 'col'),
])->except('prepend') }}>
    @if ($attributes->get('prepend', false))
    <div class="input-group-prepend">
        <div class="input-group-text">{{ $attributes->get('prepend') }}</div>
    </div>
    @endif

    {{ $slot ?? null }}
</div>
