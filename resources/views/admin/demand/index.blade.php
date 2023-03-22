@extends('admin.layout.layout')

@section('title', '- Demand')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Demand Management</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Demand</li>
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
            <!-- Card -->
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-outline-primary my-btn-outline" href="{{ Route('admin.demand.create') }}">
                        <i class="bi bi-plus-circle-fill me-1"></i>
                        Create New
                    </a>

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    {{-- <h3 class="card-title">DataTable with default features</h3> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="demandsMgmt" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($demands as $item)
                                <tr data-id={{ $item->id }}>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <ul>
                                            @foreach (preg_split('/\\n/', str_replace('\r', '', $item->description)) as $subItm)
                                                <li>{{ $subItm }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="project-actions text-center">
                                        {{-- <a class="btn btn-outline-primary btn-sm"
                                    href="{{ Route('demand.details', $item->slug) }}">
                                    <i class="fas fa-folder">
                                    </i>
                                    View
                                </a> --}}
                                        <a class="btn btn-outline-primary btn-sm mx-1 mb-2 my-btn-outline button-control"
                                            href="{{ Route('admin.demand.edit', $item->id) }}">
                                            <i class="bi bi-pencil-square"></i>
                                            <div class="myTooltip myTooltip-top">
                                                <span class="tooltiptext">Edit item</span>
                                            </div>
                                        </a>
                                        <form action="{{ Route('admin.demand.destroy') }}" method="post"
                                            style="display:inline-block">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button type="submit" id="item-delete-btn-{{ $item->id }}"
                                                class="btn btn-outline-danger btn-sm mx-1 mb-2 button-control item-delete-btn">
                                                <i class="bi bi-trash"></i>
                                                <div class="myTooltip myTooltip-top myTooltip-danger">
                                                    <span class="tooltiptext">Delete item</span>
                                                </div>
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
    </section><!-- Start Main Section -->
@endsection

@section('myJs')
    <!-- Start KienJs -->
    <script>
        document.addEventListener("DOMContentLoaded", (e) => {
            import('{{ asset('/js/KienJs/initializeTable.js') }}').then((module) => {
                const delParams = {
                    sourceJs: '{{ asset('/js/KienJs/itemsDelete.js') }}',
                    handler: 'ItemsDeleteHandler',
                    url: '{{ Route('admin.demand.destroy') }}',
                    token: '{{ csrf_token() }}',
                }
                module.initTable("#demandsMgmt", delParams);
            });
        });
    </script><!-- End KienJs -->
@endsection
