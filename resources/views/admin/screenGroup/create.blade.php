@extends('admin.layout.layout')

@section('title', '- Create Screen')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>{{ $isUpdate ? 'Edit' : 'Create' }} Screen's category</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.screenGroup.index') }}">Screen's category</a></li>
                <li class="breadcrumb-item active">{{ $isUpdate ? 'Edit' : 'Create' }} Screen's category</li>
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
                    <h5 class="card-title">{{ $isUpdate ? 'Edit' : 'Create' }} Screen's category Form</h5>
                    <hr>
                    <h6 class="card-title">Choose 1 of 2 options: EXACT or RANGE value [from ... - to ...]</h6>

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    <!-- Horizontal Form -->
                    <form action="{{ Route($isUpdate ? 'admin.screenGroup.update' : 'admin.screenGroup.store') }}"
                        method="post" class="card-body" enctype="multipart/form-data">
                        @csrf
                        @if ($isUpdate)
                            @method('put')
                            <input type="hidden" name="id" value="{{ $screenGroup->id }}">
                        @endif

                        <!-- Exact Value Section -->
                        <div class="form-group row mb-3">
                            <label for="value" class="col-sm-2 col-form-label">Exact Value</label>
                            <div class="col-sm-10">
                                <input type="text" id="value" name="value" class="form-control"
                                    value="{{ $isUpdate ? $screenGroup->value : '' }}">
                            </div>
                        </div> <!-- / Exact Value Section -->

                        <!-- Min Value Section -->
                        <div class="form-group row mb-3">
                            <label for="min" class="col-sm-2 col-form-label">Min Value</label>
                            <div class="col-sm-10">
                                <input type="text" id="min" name="min" class="form-control"
                                    value="{{ $isUpdate ? $screenGroup->min : '' }}">
                            </div>
                        </div> <!-- / Min Value Section -->

                        <!-- Max Value Section -->
                        <div class="form-group row mb-3">
                            <label for="max" class="col-sm-2 col-form-label">Max Value</label>
                            <div class="col-sm-10">
                                <input type="text" id="max" name="max" class="form-control"
                                    value="{{ $isUpdate ? $screenGroup->max : '' }}">
                            </div>
                        </div> <!-- / Max Value Section -->

                        <!-- Description Section -->
                        <div class="form-group row mb-3">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea id="description" name="description" class="form-control" rows="8">{{ $isUpdate ? trim($screenGroup->description) : '' }}</textarea>
                            </div>
                        </div> <!-- / Description Section -->

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
