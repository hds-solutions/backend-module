<x-form-row class="{{ $attributes->get('row-class') }}">
    <x-form-label text="{{ $attributes->get('label') }}" form-label />

    @if ($card !== null)
    <div class="col card {{ $card }}">
        <div class="card-body row py-0">
    @endif

    <div data-multiple=".{{ $singular = Str::singular($name) }}-container" data-template="#new"
        {{ $attributes->class([
            'col',
            'col-md-8'  => !in_array($attributes->get('contents-size'), [ 'sm', 'md', 'lg', 'xl' ]),
            'col-lg-6'  => !in_array($attributes->get('contents-size'), [ 'md', 'lg', 'xl' ]),
            'col-xl-4'  => !in_array($attributes->get('contents-size'), [ 'lg', 'xl' ]),
        ])->except([ 'grouped', 'old-filter-fields', 'contents-size', 'label' ]) }}>

        {{-- load old values --}}
        <?php
            $old_lines = old($name) ?? [];
            if ($attributes->has('grouped')) $old_lines = array_group($old_lines);
        ?>

        {{-- show current selected values --}}
        @foreach($selecteds as $idx => $selected)
            @include('backend::components.form.backend.multiple.container', [
                'selected'  => $selected,
                'old'       => $old_lines[$idx] ?? null,
            ])
            <?php unset($old_lines[$idx]); ?>
        @endforeach

        {{-- add recently added (old) --}}
        <?php $filterFields = $attributes->get('old-filter-fields', null); ?>
        @foreach($old_lines as $old)
            {{-- filter empty old values --}}
            <?php
                if ($filterFields === null) {
                    if (($old ?? null) === null) {
                        continue;
                    }
                } else {
                    $hasValue = true;
                    foreach (explode(',', $filterFields) as $filterField) {
                        $filterField = trim($filterField);
                        $hasValue = $hasValue && (($old[$filterField] ?? null) !== null);
                    }
                    if (!$hasValue) {
                        continue;
                    }
                }
            ?>
            @include('backend::components.form.backend.multiple.container', [
                'selected'  => null,
                'old'       => $old,
            ])
        @endforeach

        {{-- add empty for adding new --}}
        @include('backend::components.form.backend.multiple.container', [
            'selected'  => null,
            'old'       => null,
        ])
    </div>

    @include('backend::components.form.helper')

    @if ($card !== null)
        </div>
        @if ($cardFooter !== null)
            <div class="card-footer">
                {{ $cardFooter }}
            </div>
        @endif
    </div>
    @endif

</x-form-row>
