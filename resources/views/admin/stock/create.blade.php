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
            <!-- card -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $isUpdate ? 'Edit' : 'Add' }} Stock Form</h5>

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    <!-- Horizontal Form -->
                    <form action="{{ Route('admin.stock.store') }}" method="post" class="card-body myForm"
                        enctype="multipart/form-data"  id="createStock">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="value" class="col-sm-2 col-form-label">
                                <div>Product Name<span class="form-required">&nbsp;*</span></div>
                            </label>

                            <div class="col-sm-10">
                                <input class="form-control" list="datalistOptions" id="product_name" rules="required"
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
                            <button type="submit" class="btn btn-primary">{{ $isUpdate ? 'Update' : 'Submit' }}</button>
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
                 const productForm = new Validator('#createStock');
            }
         });
</script>
@endsection
