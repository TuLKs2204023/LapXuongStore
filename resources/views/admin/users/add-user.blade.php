@section('title', '- Create User')
@extends('admin.layout.layout')
@section('contents')
    <div class="pagetitle">
        <h1>Create User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL::to('/all-user') }}">User List</a></li>
                <li class="breadcrumb-item active">Create User</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Create User Form</h5>

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    <!-- Horizontal Form -->
                    <form action="{{ URL::to('/insert-user') }}" role="form" method="POST" class="card-body"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Name Section -->
                        <div class="form-group row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control"
                                    placeholder="Please enter User name" required>
                            </div>
                        </div> <!-- / Name Section -->
                        <!-- Email Section -->
                        <div class="form-group row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control"
                                    placeholder="Please enter User email" required>
                            </div>
                        </div> <!-- / Name Section -->
                        <!-- Password Section -->
                        <div class="form-group row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control"
                                    placeholder="This creation will set user password to default" required disabled>
                            </div>
                        </div> <!-- / Password Section -->
                        <!-- Gender section -->
                        <div class="form-group row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Gender</label>
                            <div class="col-sm-10">
                                <div class="my-custom-select">
                                    <select name="gender" class="form-control" rules="required" required>
                                        <option value="">--- Plesae select User gender ---</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="no thanks">No Thanks</option>

                                    </select>
                                </div>
                            </div>
                            <span class="form-message"></span>
                        </div><!-- / Gender section -->
                        <!-- Role section -->
                        <div class="form-group row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-10">
                                <div class="my-custom-select">
                                    <select name="role" class="form-control" rules="required" required>
                                        <option value="">---Please select User role ---</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Customer">Customer</option>
                                        <option value="Manager">Manager</option>

                                    </select>
                                </div>
                            </div>
                            <span class="form-message"></span>
                        </div><!-- / Role section -->

                        <!-- Address Section -->
                        <div class="form-group row mb-3">
                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                                <input type="text" id="address" name="address" class="form-control" disabled required
                                    placeholder="This creation will set user address to default">
                            </div>
                        </div> <!-- / Address Section -->

                        <!-- Phone Section -->
                        <div class="form-group row mb-3">
                            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" name="phone" class="form-control" disabled required
                                    placeholder="This creation will set user phone number to default">
                            </div>
                        </div><!-- / Phone Section -->
                        <!-- Image Section -->
                        <div class="form-group row mb-3 myFilesUpload">
                            <label for="photo" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <div class="input-group hdtuto control-group lst increment">
                                    <div class="list-input-hidden-upload">
                                        <input type="file" name="photo" id="file_upload" multiple
                                            class="myfrm form-control hidden">
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
                                        <img src="" class="picture-box">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Image Section -->

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Create</button>
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
