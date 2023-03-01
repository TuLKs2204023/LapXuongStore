@section('title','- Rating')
@extends('admin.layout.layout')
@section('myHead')
@endsection

@section('contents')
    <div class="pagetitle">
        <h1>Rating</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ Route('admin.rating.index') }}">Rating Management</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        @if (auth()->user()->role !== 'Admin')
            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">

                <h2>Sorry ! The page you are looking only availabled for Admin and Manager !</h2>

                <img src="{{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">

            </section>
        @endif
        @if (auth()->user()->role == 'Admin')
            <div class="card">
                <div class="card-header">
                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    {{-- <h3 class="card-title">DataTable with default features</h3> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="productsMgmt" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Product Name</th>
                                <th>Rating Level</th>
                                <th>Review</th>
                                <th>Timestamp</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ratings as $rating)
                                <tr>
                                    <td>{{ $rating->id }}</td>
                                    <td>{{ $rating->user->name }}</td>
                                    <td>{{ $rating->product->name }}</td>
                                    <td>{{ $rating->rate }}</td>
                                    <td>{{ $rating->review }}</td>
                                    <td>{{ $rating->created_at }}</td>
                                    <td> <a class="btn btn-outline-info btn-sm"
                                            href="{{ Route('admin.rating.edit', $rating->id) }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                        <form action="{{ Route('admin.rating.destroy') }}" method="post"
                                            style="display:inline-block">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id" value="{{ $rating->id }}">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
    </section>
@endsection

@section('myJs')
    <script>
        $(function() {
            $("#productsMgmt").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "aaSorting": [],
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#productsMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
@endif