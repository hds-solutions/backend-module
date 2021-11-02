<div {{ $attributes->class([
    'input-group',
    'col'   => !str_contains($attributes->get('class'), 'col'),
])->except('prepend') }}>
    @if ($attributes->get('prepend', false))
    <div class="input-group-prepend {{ $attributes->get('prepend-class') }}">
        <div class="input-group-text {{ $attributes->get('text-class') }}">{{ $attributes->get('prepend') }}</div>
    </div>
    @endif

    {{ $slot ?? null }}
</div>
