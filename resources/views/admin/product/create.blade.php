@extends('admin.layout.layout')

@section('myHead')
    <style>
        .list-images {
            width: 100%;
            margin-top: 20px;
            display: inline-block;
        }

        .hidden {
            display: none;
        }

        .box-image {
            position: relative;
            float: left;
            margin: 5px 8px;
        }

        .box-image img {
            width: auto;
            height: 120px;
        }

        .wrap-btn-delete {
            position: absolute;
            top: 0;
            right: 2px;
            /* height: 2px; */
            /* font-size: 20px; */
            font-weight: bold;
            color: #fff;
        }

        .wrap-btn-delete span {
            border-radius: 2px;
            background-color: rgba(211, 211, 211, 0.7);
            padding: 0 5.5px;
        }

        .wrap-btn-delete span:hover {
            background-color: rgba(128, 128, 128, 0.7);
        }

        .btn-delete-image {
            cursor: pointer;
        }

        .table {
            width: 15%;
        }
    </style>
@endsection

@section('contents')
    <div class="pagetitle">
        <h1>{{ $isUpdate ? 'Edit' : 'Create' }} Product</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.product.index') }}">Product Management</a></li>
                <li class="breadcrumb-item active">{{ $isUpdate ? 'Edit' : 'Create' }} Product</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $isUpdate ? 'Edit' : 'Create' }} Product Form</h5>

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

                <!-- Horizontal Form -->
                <form action="{{ Route($isUpdate ? 'admin.product.update' : 'admin.product.store') }}" method="post"
                    class="card-body" enctype="multipart/form-data">
                    @csrf
                    @if ($isUpdate)
                        @method('put')
                        <input type="hidden" name="id" value="{{ $product->id }}">
                    @endif

                    <!-- Name section -->
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ $isUpdate ? $product->name : '' }}">
                        </div>
                    </div><!-- / Name section -->

                    <!-- Manufacture section -->
                    <div class="form-group row mb-3">
                        <label for="manufacture_id" class="col-sm-2 col-form-label">Manufacture</label>
                        <div class="col-sm-10">
                            <div class="my-custom-select">
                                <select id="manufacture_id" name="manufacture_id" class="form-control" rules="required">
                                    <option value="">--- Select ---</option>
                                    @foreach ($manufactures as $item)
                                        <option
                                            value="{{ $item->id }}"{{ $isUpdate ? ($product->manufacture->id == $item->id ? 'selected' : '') : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <span class="form-message"></span>
                    </div><!-- / Manufacture section -->

                    <!-- CPU section -->
                    <div class="form-group row mb-3">
                        <label for="cpu_id" class="col-sm-2 col-form-label">CPU</label>
                        <div class="col-sm-10">
                            <div class="my-custom-select">
                                <select id="cpu_id" name="cpu_id" class="form-control" rules="required">
                                    <option value="">--- Select ---</option>
                                    @foreach ($cpus as $item)
                                        <option
                                            value="{{ $item->id }}"{{ $isUpdate ? ($product->cpu->id == $item->id ? 'selected' : '') : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <span class="form-message"></span>
                    </div><!-- / CPU section -->

                    <!-- Name section -->
                    <div class="form-group row mb-3">
                        <label for="ram" class="col-sm-2 col-form-label">RAM (in GB)</label>
                        <div class="col-sm-10">
                            <input type="text" id="ram" name="ram" class="form-control"
                                value="{{ $isUpdate ? $product->ram->amount : '' }}">
                        </div>
                    </div><!-- / Name section -->

                    <!-- Price section -->
                    <div class="form-group row mb-3">
                        <label for="price" class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-10">
                            <input type="text" id="price" name="price" class="form-control"
                                value="{{ $isUpdate ? $product->price : '' }}">
                        </div>
                    </div><!-- / Price section -->

                    <!-- Description section -->
                    <div class="form-group row mb-3">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea id="description" name="description" class="form-control" rows="8">{{ $isUpdate ? trim($product->description) : '' }}</textarea>
                        </div>
                    </div><!-- / Description section -->

                    <!-- Images section -->
                    <div class="form-group row mb-3">
                        <label for="photo" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10">
                            <div class="input-group hdtuto control-group lst increment">
                                <div class="list-input-hidden-upload">
                                    <input type="file" name="photos[]" id="file_upload" multiple
                                        class="myfrm form-control hidden">
                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success btn-add-image" type="button">
                                        <i class="fldemo glyphicon glyphicon-plus"></i>
                                        + Add image
                                    </button>
                                </div>
                            </div>
                            <div class="list-images">
                                @if (isset($list_images) && !empty($list_images))
                                    @foreach ($list_images as $img)
                                        <div class="box-image">
                                            <input type="hidden" name="images_edited[]" value="{{ $img->url }}"
                                                id="img-{{ $img->id }}">
                                            <img src="{{ asset('images/' . $img->url) }}" class="picture-box">
                                            <div class="wrap-btn-delete"><span data-id="img-{{ $img->id }}"
                                                    class="btn-delete-image">x</span></div>
                                        </div>
                                    @endforeach
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                @endif
                            </div>
                        </div>
                    </div> <!-- / Images section -->

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">{{ $isUpdate ? 'Update' : 'Submit' }}</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- End Horizontal Form -->
            </div>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('myJs')
    <script type="module">
    import {FilesUpload} from '{{ asset('/js/KienJs/FilesUpload.js') }}';
    import {CustomSelect} from '{{ asset('/js/KienJs/customSelect.js') }}';
    document.addEventListener("readystatechange", (e) => {
        if (e.target.readyState === "complete") {
            const customSelect = new CustomSelect({
                orginialInput: "my-custom-select",
            });

            const filesUpload = new FilesUpload({});
        }
    });
</script>
@endsection
