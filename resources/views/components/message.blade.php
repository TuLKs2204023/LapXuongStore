{{-- @if (count($errors) > 0) --}}
@if (session('errors'))
    <div class="alert alert-danger">
        <strong>Sorry!</strong> There were some troubles with your action:<br><br>
        <ul>
            {{-- @foreach ($errors->all() as $error) --}}
                <li>{{ $errors }}</li>
            {{-- @endforeach --}}
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
