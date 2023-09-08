@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <button type="button" class="close absolute top-0 right-0 px-4 py-3">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="font-bold"><i class="fas fa-ban"></i> Error!</h5>
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::get('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <button type="button" class="close absolute top-0 right-0 px-4 py-3">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="font-bold"><i class="fas fa-check"></i> Alert!</h5>
        {{ Session::get('success') }}
    </div>
@endif

@if (Session::get('update'))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
        <button type="button" class="close absolute top-0 right-0 px-4 py-3">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="font-bold"><i class="fas fa-check"></i> Alert!</h5>
        {{ Session::get('update') }}
    </div>
@endif
