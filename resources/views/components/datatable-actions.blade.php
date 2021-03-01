<div class="text-center d-flex justify-content-around align-items-center">

@foreach($actions ?? [] as $action)

    @switch($action)
        @case('visible')
            <form method="POST" action="route.update" class="d-inline"
                title="Visibilidad"
                data-toggle="tooltip" data-placement="top"
                data-visible="fa-eye" data-hidden="fa-eye-slash" data-visibility=":resource.visible:"
                data-icon="label>i" data-spinner='[role="status"]'>
                @csrf
                @method('PUT')

                <label for="visible-:resource:"
                    class="text-:resource.visible: b-0 m-0 cursor-pointer">
                    <i class="fas fa-eye:resource.visible:"></i>
                    <div class="spinner-border spinner-border-sm text-info d-none" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </label>

                <button type="submit" id="visible-:resource:" class="d-none"></button>
            </form>
            @break

        @case('show')
            <a href="route.show"
                title="Ver Detalle"
                data-toggle="tooltip" data-placement="top"
                class="text-primary"><i class="fas fa-bars"></i></a>
            @break

        @case('update')
            <a href="route.edit"
                title="Editar {{ $label ?? 'el registro' }}"
                data-toggle="tooltip" data-placement="top"
                class="text-success">
                <i class="fas fa-pen"></i><!--
            --></a>
            @break

        @case('delete')
            <form method="POST" action="route.destroy" class="d-inline">
                @csrf
                @method('DELETE')

                <label for="delete-:resource:"
                    title="Eliminar {{ $label ?? 'el registro' }}"
                    data-toggle="tooltip" data-placement="top"
                    class="text-danger b-0 m-0 cursor-pointer"><i class="fas fa-trash"></i></label>

                <button type="submit" id="delete-:resource:" class="d-none"
                    data-confirm="Eliminar {{ $label ?? 'el registro' }}"
                    data-text="Esta seguro de eliminar {{ $label ?? 'el registro' }}?"
                    data-accept="Si, eliminar"></button>
            </form>
            @break

    @endswitch

@endforeach

</div>