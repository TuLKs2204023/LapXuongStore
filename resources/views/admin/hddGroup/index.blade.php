@extends('admin.layout.layout')

@section('title', '- HDD')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>HDD's category Management</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">HDD's category </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Start Main Section -->
    <section class="section">
        @if (auth()->user()->role == 'Customer')
            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">

                <h2>Sorry ! The page you are looking only availabled for Admin and Manager !</h2>

                <img src="{{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">

            </section>
        @endif
        @if (auth()->user()->role !== 'Customer')
            <!-- card -->
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-outline-primary my-btn-outline" href="{{ Route('admin.hddGroup.create') }}">
                        <i class="bi bi-plus-circle-fill me-1"></i>
                        Create New HDD's category
                    </a>

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    {{-- <h3 class="card-title">DataTable with default features</h3> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="hddGroupsMgmt" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Exact value</th>
                                <th>Range value</th>
                                {{-- <th>Image</th> --}}
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($hddGroups as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->value }}</td>
                                    <td>
                                        {{ $item->value == 0
                                            ? ($item->min == 0
                                                ? '0 → ' . $item->max
                                                : ($item->max == 0
                                                    ? $item->min . ' → ∞'
                                                    : $item->min . ' → ' . $item->max))
                                            : '' }}
                                    </td>
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
                                    href="{{ Route('hddGroup.details', $item->slug) }}">
                                    <i class="fas fa-folder">
                                    </i>
                                    View
                                </a> --}}
                                        <a class="btn btn-outline-info btn-sm"
                                            href="{{ Route('admin.hddGroup.edit', $item->id) }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                        <form action="{{ Route('admin.hddGroup.destroy') }}" method="post"
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
        @endif
    </section><!-- End Main Section -->
@endsection

@section('myJs')
    <script>
        $(function() {
            $("#hddGroupsMgmt").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#hddGroupsMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
