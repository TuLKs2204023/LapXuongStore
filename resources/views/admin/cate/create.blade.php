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
        <h1>{{ $isUpdate ? 'Edit' : 'Create' }} CPU</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.cpu.index') }}">CPU</a></li>
                <li class="breadcrumb-item active">{{ $isUpdate ? 'Edit' : 'Create' }} CPU</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $isUpdate ? 'Edit' : 'Create' }} CPU Form</h5>

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
                <form action="{{ Route($isUpdate ? 'admin.cpu.update' : 'admin.cpu.store') }}"
                    method="post" class="card-body" enctype="multipart/form-data">
                    @csrf
                    @if ($isUpdate)
                        @method('put')
                        <input type="hidden" name="id" value="{{ $cpu->id }}">
                    @endif
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ $isUpdate ? $cpu->name : '' }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea id="description" name="description" class="form-control" rows="8">{{ $isUpdate ? trim($cpu->description) : '' }}</textarea>
                        </div>
                    </div>

                    {{-- <div class="form-group row mb-3">
                        <label for="photo" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10">
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
                                @if ($isUpdate)
                                    @if ($cpu->image()->count() > 0)
                                        <div class="box-image">
                                            <input type="hidden" name="images_edited[]"
                                                value="{{ $cpu->image->url }}"
                                                id="img-{{ $cpu->image->id }}">
                                            <img src="{{ asset('images/' . $cpu->image->url) }}"
                                                class="picture-box">
                                            <div class="wrap-btn-delete"><span data-id="img-{{ $cpu->image->id }}"
                                                    class="btn-delete-image">x</span></div>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $cpu->id }}">
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div> --}}

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
@endsection
