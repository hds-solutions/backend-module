@foreach($items as $item)
    <a @lm_attrs($item) class="collapse-item" href="{!! $item->url() !!}" @lm_endattrs>{!! $item->title !!}</a>
@endforeach