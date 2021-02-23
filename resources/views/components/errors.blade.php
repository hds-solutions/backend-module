@if ($errors->any())
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card bg-danger text-white shadow">
            <div class="card-body">
                Error
                @foreach ($errors->all() as $error)
                    <div class="small">{{ $error }}</div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif