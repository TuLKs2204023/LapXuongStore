@if ($errors->any())
    <div class="main-errors">
        <div class="alert alert-danger">
            <strong>Sorry!</strong> There were some troubles with your action:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success main-success">
        {{ session('success') }}
    </div>
@endif
