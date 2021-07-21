@foreach($items as $item)
    <a @lm_attrs($item) class="collapse-item" href="{!! $item->url() !!}" @lm_endattrs>
        <i class="fas fa-fw fa-{!! $item->attributes['icon'] ?? 'cube' !!} text-{{ $item->active ? 'primary' : 'gray-600' }}"></i>
        <span>{!! $item->title !!}</span>
    </a>
@endforeach
