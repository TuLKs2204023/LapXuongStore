@extends('admin.layout.layout')

@section('myHead')
@endsection

@section('contents')
    <div class="pagetitle">
        <h1>Stock Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Stock</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-outline-primary" href="{{ Route('admin.stock.create') }}">
                    <i class="bi bi-plus-circle-fill me-1"></i>
                    Add Stock
                </a>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Sorry!</strong> There were some troubles with your HTML input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                {{-- <h3 class="card-title">DataTable with default features</h3> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="productsMgmt" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product ID</th>
                            <th>In Quantity</th>
                            <th>Unit Price</th>
                            <th>Out Quantity</th>
                            <th>Final Price</th>
                            <th>Timestamp</th>
                            <th>Available</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $item)
                            @foreach($item->stocks as $stock)
                            <tr>
                                <td>{{ $stock->id }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $stock->in_qty }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $stock->out_qty }}</td>
                                <td>Still not input</td>
                                <td>{{$stock->created_at}}</td>
                                @if (($stock->in_qty - $stock->out_ty) > 0)
                                    <td><button class="btn btn-success rounded-pill">In Stock</button></td>
                                @elseif(($stock->in_qty - $stock->out_ty) < 0)
                                    <td><button class="btn btn-danger rounded-pill">Out Of Stock</button></td>
                                @else
                                    <td><button class="btn btn-warning rounded-pill">Empty</button></td>    
                                @endif
                            </tr>
                            @endforeach
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
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#productsMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
