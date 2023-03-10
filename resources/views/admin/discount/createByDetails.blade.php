@extends('admin.layout.layout')

@section('title', '- Create Discount')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>{{ $product->subName() }} Discount</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.discount.index') }}">Discount Management</a></li>
                <li class="breadcrumb-item active">{{ $product->subName() }} Add Discount</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Start Main Section -->
    <section class="section">
        <!-- card -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Discount Form</h5>

                <!-- Message Section -->
                @include('components.message')
                <!-- / Message Section -->

                <!-- Horizontal Form -->
                <form action="{{ Route('admin.discount.store') }}" method="post" class="card-body"
                    enctype="multipart/form-data">
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
                        <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                        <div class="col-sm-10">
                            <input type="text" id="amount" name="amount" class="form-control" placeholder="(in %)">
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
