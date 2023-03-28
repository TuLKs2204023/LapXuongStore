@extends('admin.layout.layout')

@section('title', '- Rating')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Rating</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ Route('admin.rating.index') }}">Rating Management</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Start Main Section -->
    <section class="section">
            <!-- card -->
            <div class="card">
                <div class="card-header">
                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    {{-- <h3 class="card-title">DataTable with default features</h3> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="ratingsMgmt" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Product Name</th>
                                <th>Rating Level</th>
                                <th>Timestamp</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ratings as $rating)
                                <tr>
                                    <td>{{ $rating->id }}</td>
                                    <td>{{ $rating->user->name }}</td>
                                    <td>{{ $rating->product->subName() }}</td>
                                    <td>{{ $rating->rate }}</td>
                                    <td>{{ $rating->created_at }}</td>
                                    <td> <a class="btn btn-outline-info btn-sm"
                                            href="{{ Route('product.details', $rating->product->slug) }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            View
                                        </a>

                                        <form id="rating-delete" action="{{ Route('admin.rating.adminDelete') }}" method="post"
                                            style="display:inline-block">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id" value="{{ $rating->id }}">
                                            <div
                                                class="btn btn-outline-danger btn-sm button-control tu-button">
                                               Delete
                                            </div>
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
            $("#ratingsMgmt").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "aaSorting": [],
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#ratingsMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        jQuery(document).ready(function($) {
            const tuBtn = $(".tu-button");
            tuBtn.each(function(index, element) {
                $(element).on("click", function() {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this, once it's run, the review will be deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4154f1',
                        cancelButtonColor: 'crimson',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(element).html(
                                '<div class="spinner-border spinner-border-sm"></div> Processing'
                            );
                            Swal.fire(
                                'Deleting!',
                                'Delete is processing, please wait for a few seconds.',
                                'info',
                            )
                            $('#rating-delete').submit();
                        }
                    })
                })
            })
        })
    </script>
@endsection
