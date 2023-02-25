@extends('admin.layout.layout')

@section('myHead')
    <style>
        .row.g-3.align-items-center {
            margin-top: 1px; 
        }

        .text-left{
            margin-top: 10px;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('contents')
    <div class="pagetitle">
        <h1>Promotion Management</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Promotion</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-header">
                {{-- <a class="btn btn-outline-primary" href="{{ Route('admin.stock.create') }}">
                    <i class="bi bi-plus-circle-fill me-1"></i>
                    Create Promotion
                </a> --}}

                <div class="accordion" id="accordionExample">
                    <div class="accordion-item" style="border: none">
                        <h2 class="accordion-header" style="margin-bottom: 15px" id="headingOne">
                            <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="bi bi-plus-circle-fill me-1"></i>
                                Create Promotion
                            </button>
                        </h2>

                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <form action="{{ Route('admin.promotion.store') }}" method="POST">
                                @csrf
                                <div class="row g-3 align-items-center">
                                    <div class="col-1">
                                        <label for="inputPassword6" class="col-form-label">Amount</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="number" id="amount" class="form-control" name="amount"
                                            aria-describedby="amountHelpInLine" placeholder="Amount of promotion" required>
                                    </div>
                                    <div class="col-auto">
                                        <span id="amountHelpInline" class="form-text">
                                            Must be 1-10 characters long.
                                        </span>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-1">
                                        <label for="inputPassword6" class="col-form-label">Length</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="number" id="codeLength" class="form-control" name="codeLength"
                                            aria-describedby="codeLengthHelpInline" placeholder="Length of promotion" required>
                                    </div>
                                    <div class="col-auto">
                                        <span id="codeLengthHelpInline" class="form-text">
                                            Must be under 15 characters long.
                                        </span>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-1">
                                        <label for="from" class="col-form-label">Discount</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="number" id="discount" class="form-control" name="discount"
                                            aria-describedby="discountHelpInline" min="1" max="100" placeholder="Discount (no need %)" required>
                                    </div>
                                    <div class="col-auto">
                                        <span id="discountHelpInline" class="form-text">
                                            Must be 1-3 characters long.
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="text-left">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                            <th>Code</th>
                            <th>Discount</th>
                            <th>Created At</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($promotions as $promotion)
                            <tr>
                                <td>{{ $promotion->id }}</td>
                                <td>{{ $promotion->code }}</td>
                                <td>{{ $promotion->discount * 100 }}%</td>
                                <td>{{ $promotion->created_at }}</td>
                                <td>{{ $promotion->status }}</td>
                                {{-- <td><button
                                        class="btn {{ $promotion->isAvailable() ? 'btn-danger' : 'btn-success' }} rounded-pill">{{ $promotion->isAvailable() ? 'Used' : 'Available' }}</button>
                                </td> --}}
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
