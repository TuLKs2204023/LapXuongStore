@section('title','- Create Manufacturer')

@extends('admin.layout.layout')
@section('contents')
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
                    method="post" class="card-body" enctype="multipart/form-data">
                    @csrf
                    @if ($isUpdate)
                        @method('put')
                        <input type="hidden" name="id" value="{{ $manufacture->id }}">
                    @endif

                    <!-- Name Section -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ $isUpdate ? $manufacture->name : '' }}">
                        </div>
                    </div> <!-- / Name Section -->

                    <!-- Address Section -->
                    <div class="form-group row mb-3">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" id="address" name="address" class="form-control"
                                value="{{ $isUpdate ? $manufacture->address : '' }}">
                        </div>
                    </div> <!-- / Address Section -->

                    <!-- Phone Section -->
                    <div class="form-group row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                            <input type="text" id="phone" name="phone" class="form-control"
                                value="{{ $isUpdate ? $manufacture->phone : '' }}">
                        </div>
                    </div><!-- / Phone Section -->

                    <!-- Description Section -->
                    <div class="form-group row mb-3">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea id="description" name="description" class="form-control" rows="8">{{ $isUpdate ? trim($manufacture->description) : '' }}</textarea>
                        </div>
                    </div> <!-- / Description Section -->

                    <!-- Image Section -->
                    @include('components.imageUpload')
                    <!-- / Image Section -->

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

                const filesUpload = new FilesUpload({
                    filesUpload: ".myFilesUpload",
                    multiple: false
                });
            }
        });
    </script>
@endsection
@endif
