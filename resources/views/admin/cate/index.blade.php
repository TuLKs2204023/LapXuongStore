@extends('admin.layout.layout')

@section('contents')
    <div class="pagetitle">
        <h1>Categories Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-outline-primary" href="{{ Route('admin.cate.create') }}">
                    <i class="bi bi-plus-circle-fill me-1"></i>
                    Refresh
                </a>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Sorry!</strong> There were some troubles with your HTML input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

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
                            <th>Products</th>
                            {{-- <th>Image</th> --}}
                            <th>Description</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($cates as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->cate_group->name }}</td>
                                {{-- <td>
                                    @if (!empty($item->image))
                                        <img src="{{ asset('images/' . $item->image->url) }}" alt=""
                                            style="width: 80px; height: auto;">
                                    @endif

                                </td> --}}
                                <td>
                                    <ol>
                                        @if (isset($item->cateable->products))
                                            @foreach ($item->cateable->products as $product)
                                                <li>{{ $product->name }}</li>
                                            @endforeach
                                        @endif
                                        @if (method_exists(get_class($item->cateable), 'cateItems'))
                                            @foreach ($item->cateable->cateItems() as $subItems)
                                                @foreach ($subItems->products as $product)
                                                    <li>{{ $product->name }}</li>
                                                @endforeach
                                            @endforeach
                                        @endif

                                    </ol>
                                </td>
                                <td>
                                    <ul>
                                        @foreach (preg_split('/\\n/', str_replace('\r', '', $item->description)) as $subItm)
                                            <li>{{ $subItm }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                {{-- <td class="project-actions text-right">
                                    <a class="btn btn-outline-primary btn-sm"
                                        href="{{ Route('cpu.details', $item->slug) }}">
                                        <i class="fas fa-folder">
                                        </i>
                                        View
                                    </a>
                                    <a class="btn btn-outline-info btn-sm" href="{{ Route('admin.cpu.edit', $item->id) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <form action="{{ Route('admin.cpu.destroy') }}" method="post"
                                        style="display:inline-block">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </td> --}}
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
            $("#catesMgmt").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#catesMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
