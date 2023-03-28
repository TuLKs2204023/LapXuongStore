@extends('admin.layout.layout')

@section('title', '- Create Demand')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>{{ $isUpdate ? 'Edit' : 'Create' }} Demand</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.demand.index') }}">Demand</a></li>
                <li class="breadcrumb-item active">{{ $isUpdate ? 'Edit' : 'Create' }} Demand</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Start Main Section -->
    <section class="section">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $isUpdate ? 'Edit' : 'Create' }} Demand Form</h5>

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    <!-- Horizontal Form -->
                    <form action="{{ Route($isUpdate ? 'admin.demand.update' : 'admin.demand.store') }}" method="post"
                        class="card-body myForm" enctype="multipart/form-data" id="createDemands">
                        @csrf
                        @if ($isUpdate)
                            @method('put')
                            <input type="hidden" name="id" value="{{ $demand->id }}">
                        @endif

                        <!-- Name Section -->
                        <div class="form-group row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">
                                <div>Name<span class="form-required">&nbsp;*</span></div>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" id="name" name="name" class="form-control" rules="required"
                                    value="{{ $isUpdate ? $demand->name : '' }}">
                                <span class="form-message heighter"></span>
                            </div>
                        </div><!-- / Name Section -->

                        <!-- Description Section -->
                        <div class="form-group row mb-3">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea id="description" name="description" class="form-control" rows="8">{{ $isUpdate ? trim($demand->description) : '' }}</textarea>
                            </div>
                        </div><!-- / Description Section -->

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

        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {
                // Input validation
                const demandsForm = new Validator('#createDemands');
            }
        });
    </script><!-- End KienJs -->
@endsection
