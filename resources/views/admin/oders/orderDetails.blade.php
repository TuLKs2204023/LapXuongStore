@section('title', '- Orders')
@extends('admin.layout.layout')
@section('contents')
    <div class="pagetitle">
        <h1>Orders List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Orders List</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-header">
                {{-- <a class="btn btn-outline-primary" href="#">
                    <i class="bi bi-plus-circle-fill me-1"></i>
                    Create New Orders
                </a> --}}
                <!-- Message Section -->
                @include('components.message')
                <!-- / Message Section -->
                {{-- <h3 class="card-title">DataTable with default features</h3> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="manufacturesMgmt" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Order ID</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orderItems as $key => $row)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $row->order_id }}</td>
                                <td>{{ $row->quantity }}</td>
                                <td>{{ $row->price->origin }}</td>
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
            $("#manufacturesMgmt").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#manufacturesMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
