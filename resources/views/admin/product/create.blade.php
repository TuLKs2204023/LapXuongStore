@extends('admin.layout.layout')

@section('contents')
    <div class="pagetitle">
        <h1>{{ $isUpdate ? 'Edit' : 'Create' }} Product</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.product.index') }}">Product Management</a></li>
                <li class="breadcrumb-item active">{{ $isUpdate ? 'Edit' : 'Create' }} Product</li>
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
            <div class="card-body">
                <h5 class="card-title">{{ $isUpdate ? 'Edit' : 'Create' }} Product Form</h5>

                <!-- Message section -->
                @include('components.message')
                <!-- / Message section -->

                <!-- Horizontal Form -->
                <form action="{{ Route($isUpdate ? 'admin.product.update' : 'admin.product.store') }}" method="post"
                    class="card-body" enctype="multipart/form-data">
                    @csrf
                    @if ($isUpdate)
                        @method('put')
                        <input type="hidden" name="id" value="{{ $product->id }}">
                    @endif

                    <!-- Name section -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ $isUpdate ? $product->name : '' }}">
                        </div>
                    </div><!-- / Name section -->

                    <!-- Manufacture section -->
                    <div class="form-group row mb-3">
                        <label for="manufacture_id" class="col-sm-2 col-form-label">Manufacture</label>
                        <div class="col-sm-10">
                            <div class="my-custom-select">
                                <select id="manufacture_id" name="manufacture_id" class="form-control" rules="required">
                                    <option value="">--- Select ---</option>
                                    @foreach ($manufactures as $item)
                                        <option
                                            value="{{ $item->id }}"{{ $isUpdate ? ($product->manufacture->id == $item->id ? 'selected' : '') : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <span class="form-message"></span>
                    </div><!-- / Manufacture section -->

                    <!-- CPU section -->
                    <div class="form-group row mb-3">
                        <label for="cpu_id" class="col-sm-2 col-form-label">CPU</label>
                        <div class="col-sm-10">
                            <div class="my-custom-select">
                                <select id="cpu_id" name="cpu_id" class="form-control" rules="required">
                                    <option value="">--- Select ---</option>
                                    @foreach ($cpus as $item)
                                        <option
                                            value="{{ $item->id }}"{{ $isUpdate ? ($product->cpu->id == $item->id ? 'selected' : '') : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <span class="form-message"></span>
                    </div><!-- / CPU section -->

                    <!-- Name section -->
                    <div class="form-group row mb-3">
                        <label for="ram" class="col-sm-2 col-form-label">RAM (in GB)</label>
                        <div class="col-sm-10">
                            <input type="text" id="ram" name="ram" class="form-control"
                                value="{{ $isUpdate ? $product->ram->amount : '' }}">
                        </div>
                    </div><!-- / Name section -->

                    <!-- Description section -->
                    <div class="form-group row mb-3">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea id="description" name="description" class="form-control" rows="8">{{ $isUpdate ? trim($product->description) : '' }}</textarea>
                        </div>
                    </div><!-- / Description section -->

                    <!-- Images section -->
                    @include('components.imageUpload')
                    <!-- / Images section -->

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">{{ $isUpdate ? 'Update' : 'Submit' }}</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- End Horizontal Form -->
            </div>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('myJs')
    <script type="module">
    import {FilesUpload} from '{{ asset('/js/KienJs/FilesUpload.js') }}';
    import {CustomSelect} from '{{ asset('/js/KienJs/customSelect.js') }}';
    document.addEventListener("readystatechange", (e) => {
        if (e.target.readyState === "complete") {
            const customSelect = new CustomSelect({
                orginialInput: "my-custom-select",
            });

            const filesUpload = new FilesUpload({filesUpload: ".myFilesUpload"});
        }
    });
</script>
@endsection
@endif
