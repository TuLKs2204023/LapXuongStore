@extends('admin.layout.layout')

@section('myHead')
@endsection

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Wishlist</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ Route('admin.rating.index') }}">Wishlist Management</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Start Main Section -->
    <section class="section">
            <div class="card">
                <div class="card-header">
                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    {{-- <h3 class="card-title">DataTable with default features</h3> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="wishlistMgmt" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Product Name</th>
                                <th>Timestamp</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($wishlistItems as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <form action="{{ Route('admin.wishlist.destroy') }}" method="post"
                                            style="display:inline-block">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id" value="{{ $item->id }}">
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
    </section><!-- End Main Section -->

@endsection

@section('myJs')
    <script>
        $(function() {
            $("#wishlistMgmt").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "aaSorting": [],
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#wishlistMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
