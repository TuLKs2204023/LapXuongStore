@section('title','- Ram')
@extends('admin.layout.layout')
@section('contents')
    <div class="pagetitle">
        <h1>RAM's category Management</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">RAM's category </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        @if (auth()->user()->role == 'Customer')
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">

            <h2>Sorry ! The page you are looking only availabled for Admin and Manager !</h2>

            <img src="{{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">

        </section>
        @endif
        @if (auth()->user()->role !== 'Customer')
        <div class="card">
            <div class="card-header">
                <a class="btn btn-outline-primary" href="{{ Route('admin.ramGroup.create') }}">
                    <i class="bi bi-plus-circle-fill me-1"></i>
                    Create New RAM's category
                </a>

                <!-- Message Section -->
                @include('components.message')
                <!-- / Message Section -->

                {{-- <h3 class="card-title">DataTable with default features</h3> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="ramGroupsMgmt" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Exact value</th>
                            <th>Min value</th>
                            <th>Max value</th>
                            {{-- <th>Image</th> --}}
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($ramGroups as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->value }}</td>
                                <td>{{ $item->min }}</td>
                                <td>{{ $item->max }}</td>
                                {{-- <td>
                                    @if (!empty($item->image))
                                        <img src="{{ asset('images/' . $item->image->url) }}" alt=""
                                            style="width: 80px; height: auto;">
                                    @endif

                                </td> --}}
                                <td>
                                    <ul>
                                        @foreach (preg_split('/\\n/', str_replace('\r', '', $item->description)) as $subItm)
                                            <li>{{ $subItm }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="project-actions text-right">
                                    {{-- <a class="btn btn-outline-primary btn-sm"
                                    href="{{ Route('ramGroup.details', $item->slug) }}">
                                    <i class="fas fa-folder">
                                    </i>
                                    View
                                </a> --}}
                                    <a class="btn btn-outline-info btn-sm" href="{{ Route('admin.ramGroup.edit', $item->id) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <a href="{{ URL::to('admin/ram/destroy/' . $item->id) }}" class="btn btn-sm btn-danger" id="delete">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </a>

                                </td>
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
            $("#ramGroupsMgmt").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#ramGroupsMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
@endif
