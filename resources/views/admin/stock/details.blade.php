@extends('admin.layout.layout')

@section('myHead')
@endsection

@section('contents')
    <div class="pagetitle">
        <h1>Stocks of {{ $product->subName() }}</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.stock.index') }}">Stock Management</a></li>
                <li class="breadcrumb-item active">{{ $product->subName() }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        @if (auth()->user()->role == 'Customer')
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">

            <h2>Sorry ! The page you are looking only availabled for Admin and Manager !</h2>

            <img src="{{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">

        </section>
        @endif
        @if (auth()->user()->role !== 'Customer')
        <div class="card">
            <div class="card-header">
                <a class="btn btn-outline-primary" href="{{ Route('admin.stock.createStockByDetails', $product->id ) }}">
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
                            <th>In Quantity</th>
                            <th>Unit Price</th>
                            <th>Out Quantity</th>
                            <th>Final Price</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($product->stocks as $stock)
                            <tr>
                                <td>{{ $stock->id }}</td>
                                <td>{{ $stock->in_qty }}</td>
                                <td>{{ number_format($stock->price->origin, 0, ',', '.') }}</td>
                                <td>{{ $stock->out_qty }}</td>
                                <td>Still not input</td>
                                <td>{{ $stock->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr class="table-secondary">
                            <td colspan="3"></td>
                            <th  style="text-align: right">Condition</th>
                            @if ($product->inStock() - $product->outStock() > 0)
                                <td><button class="btn btn-success rounded-pill">In stock</button></td>
                            @else
                                <td><button class="btn btn-danger rounded-pill">Out of stock</button></td>
                            @endif
                            <td><span style="font-weight: bolder">{{$product->inStock() - $product->outStock()}}</span> (Items) </td>
                        </tr>
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
