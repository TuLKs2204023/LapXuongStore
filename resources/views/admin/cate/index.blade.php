@extends('admin.layout.layout')

@section('title', '- Categories')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Categories Management</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
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
                    <a class="btn btn-outline-primary my-btn-outline" href="{{ Route('admin.cate.refresh') }}">
                        <i class="bi bi-arrow-repeat me-1"></i>
                        Refresh
                    </a>

                    <!-- Message Section -->
                    @include('components.message')
                    <!-- / Message Section -->

                    {{-- <h3 class="card-title">DataTable with default features</h3> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="catesMgmt" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Cate Group</th>
                                <th>Show on Nav-bar</th>
                                <th>Show on Search-page</th>
                                <th>Products</th>
                                {{-- <th>Description</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($cates as $item)
                                <tr data-id={{ $item->id }}>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->cate_group->name }}</td>
                                    <td class="text-center">
                                        <label for="showOnNav-{{ $item->id }}" class="my-switch form-label">
                                            <input type="checkbox" id="showOnNav-{{ $item->id }}"
                                                name="showOnNav-{{ $item->id }}" class="form-control"
                                                {{ $item->showOnNav == 1 ? 'checked' : '' }}>
                                            <span class="switch-slider round"></span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <label for="showOnSearch-{{ $item->id }}" class="my-switch form-label">
                                            <input type="checkbox" id="showOnSearch-{{ $item->id }}"
                                                name="showOnSearch-{{ $item->id }}" class="form-control"
                                                {{ $item->showOnSearch == 1 ? 'checked' : '' }}>
                                            <span class="switch-slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <ol>
                                            @if (isset($item->cateable->products))
                                                @foreach ($item->cateable->products as $product)
                                                    <li>{{ $product->name }}</li>
                                                @endforeach
                                            @endif
                                            @if (method_exists(get_class($item->cateable), 'cateItems'))
                                                @foreach ($item->cateable->cateItems()->load('products') as $subItems)
                                                    @foreach ($subItems->products as $product)
                                                        <li>{{ $product->name }}</li>
                                                    @endforeach
                                                @endforeach
                                            @endif

                                        </ol>
                                    </td>
                                    {{-- <td>
                                        <ul>
                                            @foreach (preg_split('/\\n/', str_replace('\r', '', $item->description)) as $subItm)
                                                <li>{{ $subItm }}</li>
                                            @endforeach
                                        </ul>
                                    </td> --}}
                                    <td class="project-actions text-center">
                                        {{-- <a class="btn btn-outline-primary btn-sm"
                                        href="{{ Route('cate.details', $item->slug) }}">
                                        <i class="fas fa-folder">
                                        </i>
                                        View
                                    </a>
                                        <a class="btn btn-outline-primary btn-sm mx-1 mb-2 my-btn-outline button-control"
                                            href="{{ Route('admin.cate.edit', $item->id) }}">
                                             <i class="bi bi-pencil-square"></i>
                                            <div class="myTooltip myTooltip-top">
                                                <span class="tooltiptext">Edit item</span>
                                            </div>
                                        </a> --}}
                                        <form action="{{ Route('admin.cate.destroy') }}" method="post"
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
    </section><!-- End Main Section -->
@endsection

@section('myJs')
    <!-- Start KienJs -->
    <script>
        document.addEventListener("DOMContentLoaded", (e) => {
            import('{{ asset('/js/KienJs/initializeTable.js') }}').then((module) => {
                const showParams = {
                    sourceJs: '{{ asset('/js/KienJs/createGroup.js') }}',
                    handler: 'CateGroupsHandler',
                    url: '{{ Route('admin.cate.toggleDisplay') }}',
                    token: '{{ csrf_token() }}'
                }

                const delParams = {
                    sourceJs: '{{ asset('/js/KienJs/itemsDelete.js') }}',
                    handler: 'ItemsDeleteHandler',
                    url: '{{ Route('admin.cate.destroy') }}',
                    token: '{{ csrf_token() }}',
                }
                
                module.initTable("#catesMgmt", showParams, delParams);
            });
        });
    </script><!-- End KienJs -->
@endsection
