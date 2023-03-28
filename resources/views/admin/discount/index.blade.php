@extends('admin.layout.layout')

@section('title', '- Discounts')

@section('myHead')
@endsection

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Discount Management</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Discount</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Start Main Section -->
    <section class="section">
            <!-- card -->
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-outline-primary" href="{{ Route('admin.discount.create') }}">
                        <i class="bi bi-plus-circle-fill me-1"></i>
                        Add Discount
                    </a>

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    {{-- <h3 class="card-title">DataTable with default features</h3> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="discountManagement" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>P.d Name</th>
                                <th>P.d ID</th>
                                <th>Amount</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($discounts as $discount)
                                <tr>
                                    <td>{{ $discount->id }}</td>
                                    <td>{{ $discount->product->subName() }}</td>
                                    <td>{{ $discount->product->id }}</td>
                                    <td>{{ $discount->amount *100}}%</td>
                                    <td>{{ $discount->created_at }}</td>
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
            $("#discountManagement").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "aaSorting": [],
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#discountManagement_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
