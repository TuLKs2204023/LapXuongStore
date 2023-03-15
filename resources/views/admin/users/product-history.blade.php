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
        @if (auth()->user()->role !== 'Admin')
            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">

                <h2>Sorry ! The page you are looking only availabled for Admin !</h2>

                <img src="{{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">

            </section>
        @endif
        @if (auth()->user()->role == 'Admin')
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
                            @foreach ($historyProduct as $key => $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->user->name }}</td>
                                    <td>
                                        <a href="{{ Route('product.details', $row->product->slug) }}">
                                            <img src="{{ isset($row->product->oldestImage->url) ? asset('images/' . $row->product->oldestImage->url) : '' }}"
                                                alt="" style='height:100px'>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $row->product->name }}
                                    </td>
                                    <td>{{ $row->fulldata }}</td>
                                    <td>{{$row->action}}</td>
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
@endif