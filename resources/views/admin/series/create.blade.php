@extends('admin.layout.layout')

@section('title', '- Create Series')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>{{ $isUpdate ? 'Edit' : 'Create' }} Series</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.series.index') }}">Series</a></li>
                <li class="breadcrumb-item active">{{ $isUpdate ? 'Edit' : 'Create' }} Series</li>
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
                    <h5 class="card-title">{{ $isUpdate ? 'Edit' : 'Create' }} Series Form</h5>

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    <!-- Horizontal Form -->
                    <form action="{{ Route($isUpdate ? 'admin.series.update' : 'admin.series.store') }}" method="post"
                        class="card-body myForm" enctype="multipart/form-data" id="createSeries">
                        @csrf
                        @if ($isUpdate)
                            @method('put')
                            <input type="hidden" name="id" value="{{ $series->id }}">
                        @endif

                        <!-- Manufacture Section -->
                        <div class="form-group row mb-3">
                            <label for="manufacture_id" class="col-sm-2 col-form-label">
                                <div>Manufacture<span class="form-required">&nbsp;*</span></div>
                            </label>
                            <div class="col-sm-10">
                                <div class="my-custom-select">
                                    <select id="manufacture_id" name="manufacture_id" class="form-control" rules="required">
                                        <option value="">--- Select ---</option>
                                        @foreach ($manufactures as $item)
                                            <option
                                                value="{{ $item->id }}"{{ $isUpdate ? ($series->manufacture->id == $item->id ? 'selected' : '') : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="form-message heighter"></span>
                            </div>
                        </div><!-- / Manufacture Section -->

                        <!-- Name Section -->
                        <div class="form-group row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">
                                <div>Name<span class="form-required">&nbsp;*</span></div>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" id="name" name="name" class="form-control" rules="required"
                                    value="{{ $isUpdate ? $series->name : '' }}">
                                <span class="form-message heighter"></span>
                            </div>
                        </div><!-- / Name Section -->

                        <!-- Description Section -->
                        <div class="form-group row mb-3">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea id="description" name="description" class="form-control" rows="8">{{ $isUpdate ? trim($series->description) : '' }}</textarea>
                            </div>
                        </div><!-- / Description Section -->

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary my-btn">{{ $isUpdate ? 'Update' : 'Submit' }}</button>
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
        import {Validator} from '{{ asset('/js/KienJs/validator.js') }}';

        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {
                // Input validation
                const seriesForm = new Validator('#createSeries');
            }
        });
    </script><!-- End KienJs -->
@endsection
