@extends('admin.layout.layout')

@section('title', '- Promotion')

@section('myHead')
    <style>
        .row.g-3.align-items-center {
            margin-top: 1px;
        }

        .text-left {
            margin-top: 10px;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('contents')
    @if (auth()->user()->role == 'Customer')
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">

            <h2>Sorry ! The page you are looking only availabled for Admin and Manager !</h2>

            <img src="{{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">

        </section>
    @endif
    @if (auth()->user()->role !== 'Customer')
        <!-- Start Page Title -->
        <div class="pagetitle">
            <h1>Promotion Management</h1>
            <nav style="--bs-breadcrumb-divider: '>';">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Promotion</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- Start Main Section -->
        <section class="section">
            <!-- card -->
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
                                <form action="{{ Route('admin.promotion.store') }}" method="POST" id="createPromotions"
                                    class="myForm">
                                    @csrf
                                    <div class="row g-3 align-items-center">
                                        <div class="form-group row mb-3">
                                            <div class="col-1">
                                                <label for="amount" class="col-form-label">
                                                    <div>Amount<span class="form-required">&nbsp;*</span></div>
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <input type="text" id="amount" name="amount" class="form-control"
                                                    rules="required|range:1,100" placeholder="Amount of promotions">
                                                <span class="form-message heighter"></span>
                                            </div>
                                            <div class="col-auto">
                                                <span id="discountHelpInline" class="form-text">
                                                    Must be written from 1 to 100.
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-items-center">
                                        <div class="form-group row mb-3">
                                            <div class="col-1">
                                                <label for="length" class="col-form-label">
                                                    <div>Length<span class="form-required">&nbsp;*</span></div>
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <input type="text" id="length" name="codeLength" class="form-control"
                                                    rules="required|range:5,15" placeholder="Length of a code">
                                                <span class="form-message heighter"></span>
                                            </div>
                                            <div class="col-auto">
                                                <span id="discountHelpInline" class="form-text">
                                                    Must be written from 5 to 15 characters.
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-items-center">
                                        <div class="form-group row mb-3">
                                            <div class="col-1">
                                                <label for="discount" class="col-form-label">
                                                    <div>Discount<span class="form-required">&nbsp;*</span></div>
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <input type="text" id="discount" name="discount" class="form-control"
                                                    rules="required|range:1,99" placeholder="Discount (%)">
                                                <span class="form-message heighter"></span>
                                            </div>
                                            <div class="col-auto">
                                                <span id="discountHelpInline" class="form-text">
                                                    Must be written from 1 to 99.
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-left">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    {{-- <h3 class="card-title">DataTable with default features</h3> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    <table id="promotionManagement" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Discount</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <td>Action</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($promotions as $promotion)
                                <tr>
                                    <td>{{ $promotion->id }}</td>
                                    <td>{{ $promotion->code }}</td>
                                    <td>{{ $promotion->discount * 100 }}%</td>
                                    <td>{{ $promotion->created_at }}</td>
                                    <td><button
                                            class="btn {{ $promotion->isAvailable() ? 'btn-success' : 'btn-danger' }} rounded-pill">{{ $promotion->isAvailable() ? 'Available' : 'Used' }}</button>
                                    </td>
                                    <td>
                                        @if ($promotion->status == 1)
                                            <form id="promotion-delete" action="{{ Route('admin.promotion.destroy') }}"
                                                method="POST" style="display:inline-block">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="id" value="{{ $promotion->id }}">
                                                <div class="btn btn-sm btn-outline-danger tu-button"
                                                    data-index="{{ $promotion->id }}">Delete</div>
                                            </form>
                                        @endif
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
    @endif
@endsection

@section('myJs')
    <script type="module">
        import {Validator} from '{{ asset('/js/KienJs/validator.js') }}';
        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {
                // Input validation
                const productForm = new Validator('#createPromotions');
            }
        });
    </script>
    <script>
        $(function() {
            $("#promotionManagement").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "aaSorting": [],
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#promotionManagement_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        jQuery(document).ready(function($) {
            const tuBtn = $(".tu-button");
            tuBtn.each(function(index, element) {
                $(element).on("click", function() {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this, once it's run, the code will be deleted!",
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
                                'Cancelling!',
                                'Your cancellation is processing, please wait for a few seconds.',
                                'info',
                            )
                            $('#promotion-delete').submit();
                        }
                    })
                })
            })
        })
    </script>
@endsection
