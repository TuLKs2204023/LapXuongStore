@extends('admin.layout.layout')

@section('contents')
    <div class="pagetitle">
        <h1>Edit User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL::to('/all-user') }}">User List</a></li>
                <li class="breadcrumb-item active">Edit User</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        @if (auth()->user()->role == 'Adminr')
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">

            <h2>Sorry ! The page you are looking only availabled for Customer and Manager !</h2>

            <img src="{{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">

        </section>
        @endif
        @if (auth()->user()->role !== 'Admin')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create User Form</h5>

                <!-- Message Section -->
                @include('components.message')
                <!-- / Message Section -->

                <!-- Horizontal Form -->
                <form action="{{ URL::to('/update-byuser/' . $edit->id) }}" role="form" method="POST" class="card-body" enctype="multipart/form-data">
                    @csrf
                    <!-- Name Section -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" value="{{ $edit->name }}" required>
                        </div>
                    </div> <!-- / Name Section -->
                    <!-- Email Section -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" class="form-control" value="{{ $edit->email }}"" required>
                        </div>
                    </div> <!-- / Email Section -->
                    <!-- Password Section -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="text" name="password" class="form-control" placeholder="Enter your password"
                                required>
                        </div>
                    </div> <!-- / Password Section -->
                    <!-- Gender section -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-10">
                            <div class="my-custom-select">
                                <select name="gender" class="form-control" rules="required">
                                    <option value="">--- Select your gender ---</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="no thanks">No Thanks</option>

                                </select>
                            </div>
                        </div>
                        <span class="form-message"></span>
                    </div><!-- / Gender section -->
                    {{-- <!-- Role section -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <div class="my-custom-select">
                                <select name="role" class="form-control" rules="required">
                                    <option value="">--- Select your role ---</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Customer">Customer</option>
                                    <option value="Manager">Manager</option>

                                </select>
                            </div>
                        </div>
                        <span class="form-message"></span>
                    </div><!-- / Role section --> --}}

                    <!-- Address Section -->
                    <div class="form-group row mb-3">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" id="address" name="address" class="form-control"
                                value="{{ $edit->address }}" required>
                        </div>
                    </div> <!-- / Address Section -->

                    <!-- Phone Section -->
                    <div class="form-group row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone" class="form-control" value="{{ $edit->phone }}"" required>
                        </div>
                    </div><!-- / Phone Section -->
                    <!-- Image Section -->
                    <div class="form-group row mb-3 myFilesUpload">
                        <label for="photo" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10">
                            <div class="input-group hdtuto control-group lst increment">
                                <div class="list-input-hidden-upload">
                                    <input type="file" name="photo" id="file_upload" multiple
                                        class="myfrm form-control hidden" >

                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success btn-add-image" type="button">
                                        <i class="fldemo glyphicon glyphicon-plus"></i>
                                        + Add image
                                    </button>
                                </div>

                            </div>
                            <div class="list-images">
                                <div class="box-image">
                                    <input type="hidden" name="images_edited" value="" id="">
                                    <img src="{{ asset('images/' . $edit->image) }}" class="picture-box">
                                    <div class="wrap-btn-delete"><span data-id=""
                                        class="btn-delete-image">x</span></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- / Image Section -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Confirm Edit</button>
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
