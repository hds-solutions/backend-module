<div class="text-center d-flex justify-content-around align-items-center">

@foreach($actions ?? [] as $action)

    @switch($action)
        @case('visible')
            <form method="POST" action="{{ route('backend.'.$resource.'.update', $record) }}" class="d-inline"
                title="Visibilidad"
                data-toggle="tooltip" data-placement="top"
                data-visible="fa-eye" data-hidden="fa-eye-slash" data-visibility="{{ $record->visible ? 'true' : 'false' }}"
                data-icon="label>i" data-spinner='[role="status"]'>
                @csrf
                @method('PUT')

                <label for="visible-{{ $record instanceof Illuminate\Database\Eloquent\Model ? $record->getKey() : $record }}"
                    class="text-{{ $record->visible ? 'info' : 'gray' }} b-0 m-0 cursor-pointer">
                    <i class="fas fa-eye{{ $record->visible ? '' : '-slash' }}"></i>
                    <div class="spinner-border spinner-border-sm text-info d-none" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </label>

                <button type="submit" id="visible-{{ $record instanceof Illuminate\Database\Eloquent\Model ? $record->getKey() : $record }}" class="d-none"></button>
            </form>
            @break

        @case('show')
            <a href="{{ route('backend.'.$resource.'.show', array_merge([ Str::singular($resource) => $record ], $show ?? []) ) }}"
                title="Ver Detalle"
                data-toggle="tooltip" data-placement="top"
                class="text-primary"><i class="fas fa-bars"></i></a>
            @break

        @case('update')
            <a href="{{ route('backend.'.$resource.'.edit', $record) }}"
                title="Editar {{ $label ?? '' }}"
                data-toggle="tooltip" data-placement="top"
                class="text-success">
                <i class="fas fa-pen"></i><!--
            --></a>
            @break

        @case('delete')
            <form method="POST" action="{{ route('backend.'.$resource.'.destroy', $record) }}" class="d-inline">
                @csrf
                @method('DELETE')

                <label for="delete-{{ $record instanceof Illuminate\Database\Eloquent\Model ? $record->getKey() : $record }}"
                    title="Eliminar {{ $label ?? '' }}"
                    data-toggle="tooltip" data-placement="top"
                    class="text-danger b-0 m-0 cursor-pointer"><i class="fas fa-trash"></i></label>

                <button type="submit" id="delete-{{ $record instanceof Illuminate\Database\Eloquent\Model ? $record->getKey() : $record }}" class="d-none"
                    data-confirm="Eliminar {{ $label ?? '' }}"
                    data-text="Esta seguro de eliminar {{ $label ?? '' }}?"
                    data-accept="Si, eliminar"></button>
            </form>
            @break

    @endswitch

@endforeach

</div>