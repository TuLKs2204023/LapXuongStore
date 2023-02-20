@extends('backend.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-lg-1"></div>
            </div>
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit User</h5>
                    </div>
                    <div class="card-body">
                        <!--Start cartbody-->
                        <form action="{{ URL::to('/update-user/'.$edit->id) }}" role="form" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">User name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" placeholder="Enter your name"
                                        value= "{{$edit->name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">User Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email"
                                        placeholder="Enter your user email" value="{{$edit->email}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">User Role</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="exampleFormControlSelect1" name="role" required>

                                        <option value="Admin" {{'Admin'==$edit->role ? 'selected' : '' }}>Admin</option>
                                        <option value="Customer" {{'Customer'==$edit->role ? 'selected' : '' }}>Customer</option>
                                        <option value="Manager" {{'Manager'==$edit->role ? 'selected' : '' }}>Manager</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Enter your password" value="{{$edit->password}}">
                                </div>
                            </div>

                    </div>
                    <!--end cardbody-->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>




                    </form>
                </div>
            </div>

    </div>
    </section>

    </div>
@endsection
