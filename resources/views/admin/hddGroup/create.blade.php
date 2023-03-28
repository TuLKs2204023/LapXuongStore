@extends('admin.layout.layout')

@section('title', '- Create HDD')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>{{ $isUpdate ? 'Edit' : 'Create' }} HDD's category</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.hddGroup.index') }}">HDD's category</a></li>
                <li class="breadcrumb-item active">{{ $isUpdate ? 'Edit' : 'Create' }} HDD's category</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Start Main Section -->
    <section class="section">
            <!-- card -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $isUpdate ? 'Edit' : 'Create' }} HDD's category Form</h5>
                    <hr>
                    <h6 class="card-title">Choose 1 of 2 options: EXACT or RANGE value [from ... - to ...]</h6>

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    <!-- Horizontal Form -->
                    <form action="{{ Route($isUpdate ? 'admin.hddGroup.update' : 'admin.hddGroup.store') }}" method="post"
                        class="card-body myForm" enctype="multipart/form-data" id="createHddGroups">
                        @csrf
                        @if ($isUpdate)
                            @method('put')
                            <input type="hidden" name="id" value="{{ $hddGroup->id }}">
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
                                        rules="required|min:0,exclude" value="{{ $isUpdate ? $hddGroup->value : '' }}">
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
                                        rules="requiredOr:#range-max|min:0,exclude" value="{{ $isUpdate ? $hddGroup->min : '' }}">
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
                                        value="{{ $isUpdate ? $hddGroup->max : '' }}">
                                    <span class="form-message heighter"></span>
                                </div>
                            </div> <!-- / Max Value Section -->
                        </fieldset><!-- / Range Value Section -->

                        <!-- Description Section -->
                        <div class="form-group row mb-3">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea id="description" name="description" class="form-control" rows="8">{{ $isUpdate ? trim($hddGroup->description) : '' }}</textarea>
                            </div>
                        </div> <!-- / Description Section -->

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary my-btn">{{ $isUpdate ? 'Update' : 'Submit' }}</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End Horizontal Form -->
                </div>
            </div>
            <!-- /.card -->
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
                const productForm = new Validator('#createHddGroups');

                // Update select HDD options
                const hddGroupHandler = new GroupHandler({formSelector: "#createHddGroups"});
                
            }
        });
    </script><!-- End KienJs -->
@endsection
