@extends('admin.layout.layout')

@section('title', '- Create Stock')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>{{ $product->subName() }} Stock</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.stock.index') }}">Stock Management</a></li>
                <li class="breadcrumb-item active">{{ $product->subName() }} Add Stock</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Start Main Section -->
    <section class="section">
        <!-- card -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Stock Form</h5>

                <!-- Message Section -->
                @include('components.message')
                <!-- / Message Section -->

                <!-- Horizontal Form -->
                <form action="{{ Route('admin.stock.store') }}" method="post" class="card-body myForm"
                    enctype="multipart/form-data" id="createStockDetails">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="product_name" class="col-sm-2 col-form-label">Product Name</label>
                        <div class="col-sm-10">
                            <input disabled type="text" id="product_name" class="form-control"
                                value="{{ $product->name }}">
                            <input hidden name="product_name" value="{{ $product->name }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="price" class="col-sm-2 col-form-label">
                            <div>Unit Price<span class="form-required">&nbsp;*</span></div>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="exact-value" name="price" class="form-control"
                                rules="required|min:0,exclude" >
                            <span class="form-message heighter"></span>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="in_qty" class="col-sm-2 col-form-label">
                            <div>In Quantity<span class="form-required">&nbsp;*</span></div>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="exact-value" name="in_qty" class="form-control"
                                rules="required|min:0,exclude" >
                            <span class="form-message heighter"></span>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- End Horizontal Form -->
            </div>
        </div>
        <!-- /.card -->
    </section><!-- End Main Section -->
@endsection

@section('myJs')
    <script type="module">
    import {Validator} from '{{ asset('/js/KienJs/validator.js') }}';
    import {CustomSelect} from '{{ asset('/js/KienJs/customSelect.js') }}';
    document.addEventListener("readystatechange", (e) => {
        if (e.target.readyState === "complete") {
            const customSelect = new CustomSelect({
                orginialInput: "my-custom-select",
            });
            // Input validation
            const productForm = new Validator('#createStockDetails');
        }
    });
</script>
@endsection
