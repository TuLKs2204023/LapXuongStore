@extends('admin.layout.layout')

@section('title', '- Product')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Product Management</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Product</li>
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
                    <a class="btn btn-outline-primary my-btn-outline" href="{{ Route('admin.product.create') }}">
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
                    <table id="productsMgmt" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Manufacture</th>
                                <th>CPU</th>
                                <th>RAM</th>
                                <th>Screen</th>
                                <th>SSD</th>
                                <th>Price</th>
                                {{-- <th>Description</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($products as $item)
                                <tr data-id={{ $item->id }}>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @if (count($item->images) > 0)
                                            <img src="{{ asset('images/' . $item->oldestImage->url) }}" alt=""
                                                style="width: 80px; height: auto;">
                                        @endif
                                    </td>
                                    <td>{{ $item->subName() }}</td>
                                    <td>{{ $item->manufacture->name }}</td>
                                    <td>{{ $item->cpu->name }}</td>
                                    <td>{{ $item->ram->amount }}</td>
                                    <td>{{ $item->screen->amount }}</td>
                                    <td>{{ $item->ssd->amount }}</td>
                                    <td>{{ number_format($item->salePrice(), 0, ',', '.') }}</td>
                                    {{-- <td>
                                    <ul>
                                        @foreach (preg_split('/\\n/', str_replace('\r', '', $item->description)) as $subItm)
                                            <li>{{ $subItm }}</li>
                                        @endforeach
                                    </ul>
                                </td> --}}
                                    <td class="project-actions text-center">
                                        <a class="btn btn-outline-secondary btn-sm mb-2 button-control"
                                            href="{{ Route('product.details', $item->slug) }}">
                                            <i class="bi bi-folder2-open"></i>
                                            <div class="myTooltip myTooltip-top myTooltip-secondary">
                                                <span class="tooltiptext">View item</span>
                                            </div>
                                        </a>

                                        <a class="btn btn-outline-primary btn-sm mb-2 my-btn-outline button-control"
                                            href="{{ Route('admin.product.edit', $item->id) }}">
                                            <i class="bi bi-pencil-square"></i>
                                            <div class="myTooltip myTooltip-top">
                                                <span class="tooltiptext">Edit item</span>
                                            </div>
                                        </a>
                                        <a class="btn btn-outline-success btn-sm mb-2 button-control"
                                            href="{{ Route('admin.stock.details', $item->id) }}">
                                            <i class="bi bi-cart"></i>
                                            <div class="myTooltip myTooltip-top myTooltip-success">
                                                <span class="tooltiptext">Stock of item</span>
                                            </div>
                                        </a>

                                        <a class="btn btn-outline-warning btn-sm mb-2 button-control"
                                            href="{{ Route('admin.discount.details', $item->id) }}">
                                            <i class="bi bi-piggy-bank"></i>
                                            <div class="myTooltip myTooltip-top myTooltip-warning">
                                                <span class="tooltiptext">Discount</span>
                                            </div>
                                        </a>

                                        <form action="{{ Route('admin.product.destroy') }}" method="post"
                                            style="display:inline-block">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button type="submit" id="item-delete-btn-{{ $item->id }}"
                                                class="btn btn-outline-danger btn-sm mb-2 button-control item-delete-btn">
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
                const delParams = {
                    sourceJs: '{{ asset('/js/KienJs/itemsDelete.js') }}',
                    url: '{{ Route('admin.product.destroy') }}',
                    token: '{{ csrf_token() }}',
                }
                module.initTable("#productsMgmt", '', delParams);
            });
        });
    </script><!-- End KienJs -->
@endsection
