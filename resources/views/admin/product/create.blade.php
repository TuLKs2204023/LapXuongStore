@extends('admin.layout.layout')

@section('contents')
    <div class="pagetitle">
        <h1>{{ $isUpdate ? 'Edit' : 'Create' }} Product</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
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

                    <!-- RAM section -->
                    <div class="form-group row mb-3">
                        <label for="ram" class="col-sm-2 col-form-label">RAM (in GB)</label>
                        <div class="col-sm-10">
                            <input type="text" id="ram" name="ram" class="form-control"
                                value="{{ $isUpdate ? $product->ram->amount : '' }}">
                        </div>
                    </div><!-- / RAM section -->

                    {{--------------------------------Description section start---------------------------------------------- --}}
                    <!-- Weight section -->
                    <div class="form-group row mb-3">
                        <label for="weight" class="col-sm-2 col-form-label">Weight</label>
                        <div class="col-sm-10">
                            <input type="number" id="weight" name="weight" class="form-control" placeholder="(kg)"
                                value="{{ $isUpdate ? $product->description->weight : '' }}">
                        </div>
                    </div><!-- / Weight section -->

                    <!-- Dimension section -->
                    <div class="form-group row mb-3">
                        <label for="dimension" class="col-sm-2 col-form-label">Dimension</label>
                        <div class="col-sm-10">
                            <input type="text" id="dimension" name="dimension" class="form-control" placeholder="00 x 00 x 00"
                                value="{{ $isUpdate ? $product->description->dimension : '' }}">
                        </div>
                    </div><!-- / Dimension section -->

                    <!-- Webcam section -->
                    <div class="form-group row mb-3">
                        <label for="webcam" class="col-sm-2 col-form-label">Webcam</label>
                        <div class="col-sm-10">
                            <input type="text" id="webcam" name="webcam" class="form-control" 
                                value="{{ $isUpdate ? $product->description->webcam : '' }}">
                        </div>
                    </div><!-- / Webcam section -->

                    <!-- OS section -->
                    <div class="form-group row mb-3">
                        <label for="o_s" class="col-sm-2 col-form-label">Operating System</label>
                        <div class="col-sm-10">
                            <input type="text" id="o_s" name="o_s" class="form-control" 
                                value="{{ $isUpdate ? $product->description->o_s : '' }}">
                        </div>
                    </div><!-- / OS section -->

                    <!-- Battery section -->
                    <div class="form-group row mb-3">
                        <label for="battery" class="col-sm-2 col-form-label">Battery</label>
                        <div class="col-sm-10">
                            <input type="number" id="battery" name="battery" class="form-control" placeholder="Amount of mAh"
                                value="{{ $isUpdate ? $product->description->battery : '' }}">
                        </div>
                    </div><!-- / Battery section -->

                    <!-- Warranty section -->
                    <div class="form-group row mb-3">
                        <label for="warranty" class="col-sm-2 col-form-label">Warranty</label>
                        <div class="col-sm-10">
                            <input type="number" id="warranty" name="warranty" class="form-control" placeholder="Amount of month"
                                value="{{ $isUpdate ? $product->description->warranty : '' }}">
                        </div>
                    </div><!-- / Warranty section -->

                    <!-- Instruction section -->
                    <div class="form-group row mb-3">
                        <label for="instruction" class="col-sm-2 col-form-label">Instruction</label>
                        <div class="col-sm-10">
                            <textarea type="text" id="instruction" name="instruction" class="form-control" rows="6"
                                    >{{ $isUpdate ? $product->description->instruction : '' }}</textarea>
                        </div>
                    </div><!-- / Instruction section -->

                    <!-- Feature section -->
                    <div class="form-group row mb-3">
                        <label for="feature" class="col-sm-2 col-form-label">Feature</label>
                        <div class="col-sm-10">
                            <textarea type="text" id="feature" name="feature" class="form-control" rows="14"
                                >{{ $isUpdate ? $product->description->feature : '' }}</textarea>
                        </div>
                    </div><!-- / Feature section -->
                    {{--------------------------------Description section end---------------------------------------------- --}}

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
