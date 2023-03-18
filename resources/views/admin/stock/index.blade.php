@extends('admin.layout.layout')

@section('title', '- Stocks')

@section('myHead')
@endsection

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Stock Management</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Stock</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Start Main Section -->
    <section class="section">
        @if (auth()->user()->role == 'Customer')
            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">

                <h2>Sorry ! The page you are looking only availabled for Admin and Manager !</h2>

                <img src="{{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">

            </section>
        @endif
        @if (auth()->user()->role !== 'Customer')
            <!-- card -->
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
                    <table id="stockManagement" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>P.d Name</th>
                                <th>P.d ID</th>
                                <th>In Qty</th>
                                <th>In U.Price</th>
                                <th>Out Qty</th>
                                <th>Out U.Price</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($stocks as $stock)
                                <tr>
                                    <td>{{ $stock->id }}</td>
                                    <td>{{ $stock->product->subName() }}</td>
                                    <td>{{ $stock->product->id }}</td>
                                    <td>{{ $stock->in_qty }}</td>
                                    <td>{{ number_format($stock->price->origin ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $stock->out_qty }}</td>
                                    <td>{{ number_format($stock->price->sale ?? 0, 0, ',', '.') }}</td>
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
        @endif
    </section><!-- End Main Section -->
@endsection

@section('myJs')
    <script>
        $(function() {
            $("#stockManagement").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "aaSorting": [],
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#stockManagement_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
