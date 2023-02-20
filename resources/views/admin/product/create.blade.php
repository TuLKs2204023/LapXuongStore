@extends('backend.layouts.app')

@section('heads')
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

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Products</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ Route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ Route('admin.product.index') }}">Products</a></li>
                            <li class="breadcrumb-item active">{{ $isUpdate ? 'Edit' : 'Create' }} Product</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Products</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Sorry!</strong> There were more problems with your HTML input.<br><br>
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
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">General</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <form action="{{ Route($isUpdate ? 'admin.product.update' : 'admin.product.store') }}"
                                    method="post" class="card-body" enctype="multipart/form-data">
                                    @csrf
                                    @if ($isUpdate)
                                        @method('put')
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                    @endif

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ $isUpdate ? $product->name : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="manufacture_id" class="form-label">Manufacture</label>
                                        <div class="my-custom-select">
                                            <select id="manufacture_id" name="manufacture_id" class="form-control"
                                                rules="required">
                                                <option value="">--- Select ---</option>
                                                @foreach ($manufactures as $item)
                                                    <option
                                                        value="{{ $item->id }}"{{ $isUpdate ? ($product->manufacture->id == $item->id ? 'selected' : '') : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="form-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="cpu_id" class="form-label">CPU</label>
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
                                        <span class="form-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea id="description" name="description" class="form-control" rows="8">{{ $isUpdate ? trim($product->description) : '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="text" id="price" name="price" class="form-control"
                                            value="{{ $isUpdate ? $product->price : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Image</label>
                                        <div class="input-group hdtuto control-group lst increment">
                                            <div class="list-input-hidden-upload">
                                                <input type="file" name="photos[]" id="file_upload" multiple
                                                    class="myfrm form-control hidden">
                                            </div>
                                            <div class="input-group-btn">
                                                <button class="btn btn-success btn-add-image" type="button"><i
                                                        class="fldemo glyphicon glyphicon-plus"></i>+ Add image</button>
                                            </div>
                                        </div>
                                        <div class="list-images">
                                            @if (isset($list_images) && !empty($list_images))
                                                @foreach ($list_images as $img)
                                                    <div class="box-image">
                                                        <input type="hidden" name="images_edited[]"
                                                            value="{{ $img->url }}" id="img-{{ $img->id }}">
                                                        <img src="{{ asset('images/' . $img->url) }}"
                                                            class="picture-box">
                                                        <div class="wrap-btn-delete"><span
                                                                data-id="img-{{ $img->id }}"
                                                                class="btn-delete-image">x</span></div>
                                                    </div>
                                                @endforeach
                                                <input type="hidden" name="id" value="{{ $product->id }}">
                                            @endif

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <a href="" class="btn btn-outline-secondary">Reset</a>
                                            <input type="submit" value="{{ $isUpdate ? 'Update' : 'Submit' }}"
                                                class="btn btn-success">
                                        </div>
                                    </div>
                                </form>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection

@section('myJs')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".btn-add-image").click(function() {
                $('#file_upload').trigger('click');
            });

            $('.list-input-hidden-upload').on('change', '#file_upload', function(event) {
                let today = new Date();
                let time = today.getTime();
                let image = event.target.files[0];
                let file_name = event.target.files[0].name;
                let box_image = $('<div class="box-image"></div>');
                box_image.append('<img src="' + URL.createObjectURL(image) + '" class="picture-box">');
                box_image.append('<div class="wrap-btn-delete"><span data-id=' + time +
                    ' class="btn-delete-image">x</span></div>');
                $(".list-images").append(box_image);

                $(this).removeAttr('id');
                $(this).attr('id', time);
                let input_type_file =
                    '<input type="file" name="photos[]" id="file_upload" multiple class="myfrm form-control hidden">';
                $('.list-input-hidden-upload').append(input_type_file);
            });

            $(".list-images").on('click', '.btn-delete-image', function() {
                let id = $(this).data('id');
                $('#' + id).remove();
                $(this).parents('.box-image').remove();
            });
        });
    </script>
    <script type="module">
        import {CustomSelect} from '{{ asset('/js/KienJs/customSelect.js') }}';
        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {
                const customSelect = new CustomSelect({
                    orginialInput: "my-custom-select",
                });
            }
        });
    </script>
@endsection
