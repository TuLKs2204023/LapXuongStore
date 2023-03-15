@section('title','- Edit User')
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
        @if (auth()->user()->role == 'Customer')
        <p style="text-align:center"> Sorry ! This permission availabled only for Manager and Admin ! </p>
        @endif
        @if (auth()->user()->role !== 'Customer')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit User Form</h5>

                <!-- Message Section -->
                @include('components.message')
                <!-- / Message Section -->

                <!-- Horizontal Form -->
                <form action="{{ URL::to('/update-user/' . $edit->id) }}" role="form" method="POST" class="card-body" enctype="multipart/form-data">
                    @csrf
                    <!-- Name Section -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" value="{{ $edit->name }}" required placeholder="Please enter User name">
                        </div>
                    </div> <!-- / Name Section -->
                    <!-- Email Section -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" class="form-control" value="{{ $edit->email }}"" required placeholder="Please enter User email">
                        </div>
                    </div> <!-- / Email Section -->
                    <!-- Password Section -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" placeholder="Confirm edit will set User password to default" disabled
                                required>
                        </div>
                    </div> <!-- / Password Section -->
                    <!-- Gender section -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-10">
                            <div class="my-custom-select">
                                <select name="gender" class="form-control" rules="required" required>
                                    <option value="">--- Please select User gender ---</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="No thanks">No Thanks</option>

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
                                    <option value="">--- Please select User role ---</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Customer">Customer</option>
                                    <option value="Manager">Manager</option>

                                </select>
                            </div>
                        </div>
                        <span class="form-message"></span>
                    </div><!-- / Role section -->

                    <!-- Phone Section -->
                    <div class="form-group row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone" class="form-control" value="" required placeholder="Confirm edit will set User phone number to default" disabled>
                        </div>
                    </div><!-- / Phone Section -->

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
