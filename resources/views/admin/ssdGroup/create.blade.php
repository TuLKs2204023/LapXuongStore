@extends('admin.layout.layout')

@section('title', '- Create SSD')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>{{ $isUpdate ? 'Edit' : 'Create' }} SSD's category</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.ssdGroup.index') }}">SSD's category</a></li>
                <li class="breadcrumb-item active">{{ $isUpdate ? 'Edit' : 'Create' }} SSD's category</li>
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
                    <h5 class="card-title">{{ $isUpdate ? 'Edit' : 'Create' }} SSD's category Form</h5>
                    <hr>
                    <h6 class="card-title">Choose 1 of 2 options: EXACT or RANGE value [from ... - to ...]</h6>

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    <!-- Horizontal Form -->
                    <form action="{{ Route($isUpdate ? 'admin.ssdGroup.update' : 'admin.ssdGroup.store') }}" method="post"
                        class="card-body myForm" enctype="multipart/form-data" id="createSsdGroups">
                        @csrf
                        @if ($isUpdate)
                            @method('put')
                            <input type="hidden" name="id" value="{{ $ssdGroup->id }}">
                        @endif

                        <!-- Exact Value Section -->
                        <fieldset class="exact-value row g-3">
                            <legend class="exact-value-btn">Exact Value</legend>
                            <div class="form-group row mb-3">
                                <label for="value" class="col-sm-2 col-form-label">
                                    <div>Value<span class="form-required">&nbsp;*</span></div>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" id="value" name="value" class="form-control"
                                        rules="required|min:0,exclude" value="{{ $isUpdate ? $ssdGroup->value : '' }}">
                                    <span class="form-message heighter"></span>
                                </div>
                            </div>
                        </fieldset><!-- / Exact Value Section -->

                        <!-- Range Value Section -->
                        <fieldset class="range-value row g-3">
                            <legend class="range-value-btn">Range Value</legend>
                            <!-- Min Value Section -->
                            <div class="form-group row mb-3">
                                <label for="min" class="col-sm-2 col-form-label">
                                    <div>Min<span class="form-required">&nbsp;*</span></div>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" id="range-min" name="min" class="form-control range-value-min"
                                        rules="requiredOr:#range-max|min:0,exclude"
                                        value="{{ $isUpdate ? $ssdGroup->min : '' }}">
                                    <span class="form-message heighter"></span>
                                </div>
                            </div> <!-- / Min Value Section -->

                            <!-- Max Value Section -->
                            <div class="form-group row mb-3">
                                <label for="max" class="col-sm-2 col-form-label">
                                    <div>Max<span class="form-required">&nbsp;*</span></div>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" id="range-max" name="max" class="form-control range-value-max"
                                        rules="requiredOr:#range-min|min:0,exclude|compareMin:.range-value-min"
                                        value="{{ $isUpdate ? $ssdGroup->max : '' }}">
                                    <span class="form-message heighter"></span>
                                </div>
                            </div> <!-- / Max Value Section -->
                        </fieldset><!-- / Range Value Section -->

                        <!-- Description Section -->
                        <div class="form-group row mb-3">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea id="description" name="description" class="form-control" rows="8">{{ $isUpdate ? trim($ssdGroup->description) : '' }}</textarea>
                            </div>
                        </div> <!-- / Description Section -->

                        <div class="text-center">
                            <button type="submit"
                                class="btn btn-primary my-btn">{{ $isUpdate ? 'Update' : 'Submit' }}</button>
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
    <!-- Start KienJs -->
    <script type="module">
        import {Validator} from '{{ asset('/js/KienJs/validator.js') }}';
        import {GroupHandler} from '{{ asset('/js/KienJs/createGroup.js') }}';

        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {
                // Input validation
                const productForm = new Validator('#createSsdGroups');

                // Update select SSD options
                const ssdGroupHandler = new GroupHandler({formSelector: "#createSsdGroups"});
                
            }
        });
    </script><!-- End KienJs -->
@endsection
