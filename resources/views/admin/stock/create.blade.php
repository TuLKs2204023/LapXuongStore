@extends('admin.layout.layout')

@section('title', '- Create Stock')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>{{ $isUpdate ? 'Edit' : 'Add' }} Stock</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.stock.index') }}">Stock Management</a></li>
                <li class="breadcrumb-item active">{{ $isUpdate ? 'Edit' : 'Add' }} Stock</li>
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
                <div class="card-body">
                    <h5 class="card-title">{{ $isUpdate ? 'Edit' : 'Add' }} Stock Form</h5>

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    <!-- Horizontal Form -->
                    <form action="{{ Route('admin.stock.store') }}" method="post" class="card-body"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="product_id" class="col-sm-2 col-form-label">Product Name</label>

                            <div class="col-sm-10">
                                <input class="form-control" list="datalistOptions" id="product_name"
                                    placeholder="Type to search..." name="product_name">
                                <datalist id="datalistOptions">
                                    @foreach ($products as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <span class="form-message"></span>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="price" class="col-sm-2 col-form-label">Unit Price</label>
                            <div class="col-sm-10">
                                <input type="text" id="price" name="price" class="form-control" placeholder="In Unit Price (VND)" required
                                    value="{{ $isUpdate ? $product->price : '' }}">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="in_qty" class="col-sm-2 col-form-label">In Quantity</label>
                            <div class="col-sm-10">
                                <input type="text" id="in_qty" name="in_qty" class="form-control" placeholder="In Quantity" required
                                    value="{{ $isUpdate ? $product->price : '' }}">
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ $isUpdate ? 'Update' : 'Submit' }}</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End Horizontal Form -->
                </div>
            </div>
            <!-- /.card -->
        @endif
    </section><!-- End Main Section -->
@endsection

@section('myJs')
    <script type="module">
    import {CustomSelect} from '{{ asset('/js/KienJs/customSelect.js') }}';
    document.addEventListener("readystatechange", (e) => {
        if (e.target.readyState === "complete") {
            const customSelect = new CustomSelect({
                orginialInput: "my-custom-select",
            });
        }
    });
</script>
@endsection
