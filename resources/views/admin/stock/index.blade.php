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
                            <th>P.d Name</th>
                            <th>P.d ID</th>
                            <th>In Quantity</th>
                            <th>Unit Price</th>
                            <th>Out Quantity</th>
                            <th>Final Price</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>

                    <tbody>
                            @foreach ($stocks as $stock)
                                    <tr>
                                        <td>{{ $stock->id }}</td>
                                        <td>{{ $stock->product->name }}</td>
                                        <td>{{ $stock->product->id }}</td>
                                        <td>{{ $stock->in_qty }}</td>
                                        <td>{{ number_format($stock->price->origin, 0, ',', '.') }}</td>
                                        <td>{{ $stock->out_qty }}</td>
                                        <td>Still not input</td>
                                        <td>{{ $stock->created_at }}</td>
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
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#productsMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
