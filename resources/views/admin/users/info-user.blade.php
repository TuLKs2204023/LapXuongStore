@extends('admin.layout.layout')

@section('contents')
    <div class="pagetitle">
        <h1>{{ auth()->user()->name }} Information</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ auth()->user()->name }} Information</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-outline-primary" href="{{ URL::to('/edit-byuser/' . auth()->user()->id) }}">
                    <i class="bi bi-plus-circle-fill me-1"></i>
                    Edit my information
                </a>

                <!-- Message Section -->
                @include('components.message')
                <!-- / Message Section -->

                {{-- <h3 class="card-title">DataTable with default features</h3> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="manufacturesMgmt" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Address</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>{{ auth()->user()->id }}</td>
                            <td>
                                <img src="images/{{ auth()->user()->image }}" class="picture-box" style="height:50px">

                            </td>
                            <td>{{ auth()->user()->name }}</td>
                            <td>{{ auth()->user()->email }}</td>
                            <td>{{ auth()->user()->gender }}</td>
                            <td>{{ auth()->user()->phone }}</td>
                            <td>{{ auth()->user()->address }}</td>
                        </tr>

                    </tbody>

                    <tfoot>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
@endsection

{{-- @section('myJs')
    <script>
        $(function() {
            $("#manufacturesMgmt").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#manufacturesMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection --}}
