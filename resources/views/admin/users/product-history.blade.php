@section('title', '- History Product')
@extends('admin.layout.layout')
@section('contents')
    <div class="pagetitle">
        <h1>Product History</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Product History</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <!-- Message Section -->
            @include('components.message')
            <!-- / Message Section -->
            <!-- /.card-header -->
            <div class="card-body">
                <table id="manufacturesMgmt" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Preview</th>
                            <th>Name Product</th>
                            <th>Content Change</th>
                            <th>Action</th>
                            <th>Time</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($hisPro as $key => $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->user->name }}</td>
                                <td>
                                    <a href="{{ isset($row->slug) ? Route('product.details', $row->slug) : '' }}">
                                        <img src="{{ isset($row->url) ? asset('images/' . $row->url) : '' }}"
                                            alt="" style='height:100px'>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ isset($row->slug) ? Route('product.details', $row->slug) : '' }}"
                                        class="text-dark">
                                        {{ $row->name }}
                                    </a>
                                </td>
                                <td>{{ $row->fulldata ?? $row->data }}
                                </td>
                                <td>{{ $row->action }}</td>
                                <td>{{ $row->timePro() }}</td>

                            </tr>
                        @endforeach
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

@section('myJs')
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
@endsection
