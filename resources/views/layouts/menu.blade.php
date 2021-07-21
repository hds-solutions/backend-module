@foreach($items as $item)
    @if (!$item->url() && !$item->hasChildren()) @continue @endif

    {{-- heading --}}
    @if (isset($item->attributes['header']))
    <div class="sidebar-heading">
        {!! $item->attributes['header'] !!}
    </div>
    @endif

    {{-- add menu item --}}
    <li @lm_attrs($item) class="nav-item" @lm_endattrs>
        <a href="{!! $item->url() !!}"
            class="nav-link {!! $item->isActive ? 'show' : 'collapsed' !!}"
            @if($item->hasChildren())
            data-toggle="collapse" data-target="#collapse-{!! $item->id !!}"
            aria-expanded="{!! $item->isActive ? 'true' : 'false' !!}" aria-controls="collapse-{!! $item->id !!}"
            @endif
            >
            <i class="fas fa-fw fa-{!! $item->attributes['icon'] ?? 'cube' !!}"></i>
            <span>{!! $item->title !!}</span>
        </a>
        @if($item->hasChildren())
        <div id="collapse-{!! $item->id !!}" class="collapse {!! $item->isActive ? 'show' : '' !!}" aria-labelledby="heading-users" data-parent="#accordionSidebar">
            <div class="bg-white collapse-inner rounded">
                @include('backend::layouts.menu.dropdown-items', [ 'items' => $item->children() ])
            </div>
        </div>
        @endif
    </li>

    {{-- add dividers --}}
    @foreach ($item->divider as $divider)
      <hr class="sidebar-divider">
    @endforeach

@endforeach
