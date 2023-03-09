@extends('admin.layout.layout')

@section('title', '- Create Manufacturer')

@section('myHead')
    <style>
        .myFilesUpload .control-group {
            justify-content: flex-start;
        }

        .myFilesUpload .input-group {
            width: auto;
        }

        .myFilesUpload .input-group-btn {
            width: 100%;
        }

        .myFilesUpload .input-group-btn .btn-add-image {
            width: 100%;
            font-size: 0.8rem;
            padding: 8px 12px;
        }
    </style>
@endsection

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>{{ $isUpdate ? 'Edit' : 'Create' }} Manufacture</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.manufacture.index') }}">Manufacture</a></li>
                <li class="breadcrumb-item active">{{ $isUpdate ? 'Edit' : 'Create' }} Manufacture</li>
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
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $isUpdate ? 'Edit' : 'Create' }} Manufacture Form</h5>
                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    <!-- Horizontal Form -->
                    <form action="{{ Route($isUpdate ? 'admin.manufacture.update' : 'admin.manufacture.store') }}"
                        method="post" class="card-body myForm" enctype="multipart/form-data" id="createManufacture">
                        @csrf
                        @if ($isUpdate)
                            @method('put')
                            <input type="hidden" name="id" value="{{ $manufacture->id }}">
                        @endif

                        <!-- Name Section -->
                        <div class="form-group row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">
                                <div>Name<span class="form-required">&nbsp;*</span></div>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" id="name" name="name" class="form-control" rules="required"
                                    value="{{ $isUpdate ? $manufacture->name : '' }}">
                                <span class="form-message heighter"></span>
                            </div>
                        </div> <!-- / Name Section -->

                        <!-- Address Section -->
                        <div class="form-group row mb-3">
                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                                <input type="text" id="address" name="address" class="form-control"
                                    value="{{ $isUpdate ? $manufacture->address : '' }}">
                                <span class="form-message heighter"></span>
                            </div>
                        </div> <!-- / Address Section -->

                        <!-- Phone Section -->
                        <div class="form-group row mb-3">
                            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" id="phone" name="phone" class="form-control"
                                    value="{{ $isUpdate ? $manufacture->phone : '' }}">
                                <span class="form-message heighter"></span>
                            </div>
                        </div><!-- / Phone Section -->

                        <!-- Description Section -->
                        <div class="form-group row mb-3">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea id="description" name="description" class="form-control" rows="8">{{ $isUpdate ? trim($manufacture->description) : '' }}</textarea>
                                <span class="form-message heighter"></span>
                            </div>
                        </div> <!-- / Description Section -->

                        <!-- Image Section -->
                        @include('components.imageUpload')
                        <!-- / Image Section -->

                        <div class="text-center">
                            <button type="submit"
                                class="btn btn-primary my-btn">{{ $isUpdate ? 'Update' : 'Submit' }}</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End Horizontal Form -->
                </div>
            </div><!-- /.card -->
        @endif
    </section><!-- End Main Section -->
@endsection

@section('myJs')
    <!-- Start KienJs -->
    <script type="module">
        import {FilesUpload} from '{{ asset('/js/KienJs/FilesUpload.js') }}';
        import {Validator} from '{{ asset('/js/KienJs/validator.js') }}';

        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {

                // Upload images
                const filesUpload = new FilesUpload({
                    filesUpload: ".myFilesUpload",
                    multiple: false
                });

                // Input validation
                const manufactureForm = new Validator('#createManufacture');
            }
        });
    </script><!-- End KienJs -->
@endsection
