
@extends('backend.layouts.app')
@section('content')

    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            @if (auth()->user()->role!='Admin')
            <p>Warning : "You dont have permission to access info here !"</p>

            @endif
            @if(auth()->user()->role=='Admin')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All User</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($all as $key=>$row)
                                      <tr>
                                          <td>{{$key+1}}</td>
                                          <td>{{$row->name}}</td>
                                          <td>{{$row->email}}</td>
                                          <td>{{$row->role}}</td>

                                      </td>
                                      <td>
                                        <a href="{{URL::to('/edit-user/'.$row->id)}}" class="btn btn-sm btn-info">Edit</a>
                                        <a href="{{URL::to('/delete-user/'.$row->id)}}" class=" btn btn-sm btn-danger" id ="delete">Delete</a>
                                      </td>
                                    </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

        @endif

    </div>

    @endsection

