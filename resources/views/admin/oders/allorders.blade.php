@section('title','- Oders')
@extends('admin.layout.layout')
@section('contents')
    <div class="pagetitle">
        <h1>Oders List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Oders List</li>
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
                            <th>Customer ID</th>
                            <th>Oder Date</th>
                            <th>Shipping Name</th>
                            <th>Shipping Phone</th>
                            <th>Shipping Address</th>

                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($all as $key => $row)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{$row->user_id}}</td>
                                <td>{{ $row->order_date }}</td>
                                <td>{{ $row->shipping_name}}</td>
                                <td>{{ $row->shipping_phone }}</td>
                                <td>{{ $row->shipping_address }}</td>



                                <td>
                                    <a href="{{ URL::to('/edit-user/' . $row->id) }}"
                                        class="btn btn-sm btn-info">Edit</a>
                                    <a href="{{ URL::to('/delete-user/' . $row->id) }}"
                                        class=" btn btn-sm btn-danger" id="delete">Delete</a>
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
            $("#manufacturesMgmt").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#manufacturesMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
