@section('title','- Product')
@extends('admin.layout.layout')
@section('myHead')
@endsection

@section('contents')
    <div class="pagetitle">
        <h1>Product Management</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Product</li>
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
                <a class="btn btn-outline-primary" href="{{ Route('admin.product.create') }}">
                    <i class="bi bi-plus-circle-fill me-1"></i>
                    Create New Product
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
                            <th>HDD</th>
                            <th>Price</th>
                            {{-- <th>Description</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $item)
                            <tr>
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
                                <td>{{ $item->hdd->amount }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                                {{-- <td>
                                    <ul>
                                        @foreach (preg_split('/\\n/', str_replace('\r', '', $item->description)) as $subItm)
                                            <li>{{ $subItm }}</li>
                                        @endforeach
                                    </ul>
                                </td> --}}
                                <td class="project-actions text-right">
                                    <a class="btn btn-outline-primary btn-sm"
                                        href="{{ Route('product.details', $item->slug) }}">
                                        <i class="fas fa-folder">
                                        </i>
                                        View
                                    </a>
                                    <a class="btn btn-outline-info btn-sm"
                                        href="{{ Route('admin.product.edit', $item->id) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <a class="btn btn-outline-success btn-sm"
                                        href="{{ Route('admin.stock.details', $item->id) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Stock
                                    </a>


                                        <a href="{{ URL::to('admin/product/destroy/' . $item->id) }}" class="btn btn-sm btn-danger" id="delete">
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
            $("#productsMgmt").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "aaSorting": [],
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#productsMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
@endif
