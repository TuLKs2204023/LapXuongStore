@section('title','- Manufacture')
@extends('admin.layout.layout')
@section('contents')
    <div class="pagetitle">
        <h1>Manufacture Management</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Manufacture</li>
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
                <a class="btn btn-outline-primary" href="{{ Route('admin.manufacture.create') }}">
                    <i class="bi bi-plus-circle-fill me-1"></i>
                    Create New Manufacture
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
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($manufactures as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->address }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>
                                    @if (!empty($item->image))
                                        <img src="{{ asset('images/' . $item->image->url) }}" alt=""
                                            style="width: 80px; height: auto;">
                                    @endif

                                </td>
                                <td>
                                    <ul>
                                        @foreach (preg_split('/\\n/', str_replace('\r', '', $item->description)) as $subItm)
                                            <li>{{ $subItm }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="project-actions text-right">
                                    {{-- <a class="btn btn-outline-primary btn-sm"
                                    href="{{ Route('manufacture.details', $item->slug) }}">
                                    <i class="fas fa-folder">
                                    </i>
                                    View
                                </a> --}}
                                    <a class="btn btn-outline-info btn-sm"
                                        href="{{ Route('admin.manufacture.edit', $item->id) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <form action="{{ Route('admin.manufacture.destroy') }}" method="post"
                                        style="display:inline-block">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>

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
