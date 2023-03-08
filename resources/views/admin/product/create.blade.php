@extends('admin.layout.layout')

@section('title', '- Create Product')

@section('myHead')
    <style>
        .product-spec,
        .product-desc,
        .product-image {
            background-color: #f9fafc;
            border-radius: 4px;
            margin: 0 auto !important;
            padding-bottom: 20px;
            box-shadow: 2px 2px 6px rgb(1 41 112 / 10%), -2px -2px 6px rgb(1 41 112 / 10%);
        }

        fieldset>legend {
            float: none;
            text-transform: uppercase;
            font-size: 0.8rem;
            color: #fff;
            font-weight: bold;
            text-align: center;
            width: auto !important;
            background-color: var(--blue-dark);
            border-radius: 4px;
            padding: 10px 50px !important;
            margin: 0;
        }

        .myFilesUpload .control-group {
            width: 100%;
            justify-content: center;
        }

        .myFilesUpload .input-group-btn {
            width: 95%;
        }

        .myFilesUpload .input-group-btn .btn-add-image {
            width: 100%;
            font-size: 0.8rem;
            padding: 8px 12px;
        }
    </style>
@endsection

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>{{ $isUpdate ? 'Edit' : 'Create' }} Product</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ Route('admin.product.index') }}">Product Management</a></li>
                <li class="breadcrumb-item active">{{ $isUpdate ? 'Edit' : 'Create' }} Product</li>
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
                <div class="card-body">
                    <h5 class="card-title">{{ $isUpdate ? 'Edit' : 'Create' }} Product Form</h5>

                    <!-- Message section -->
                    @include('components.message')
                    <!-- / Message section -->

                    <!-- Horizontal Form -->
                    <form action="{{ Route($isUpdate ? 'admin.product.update' : 'admin.product.store') }}" method="post"
                        class="card-body row g-3 myForm" enctype="multipart/form-data" id="createProduct">
                        @csrf
                        @if ($isUpdate)
                            @method('put')
                            <input type="hidden" name="id" value="{{ $product->id }}">
                        @endif

                        <div class="product-name">
                            <!-- Name section -->
                            <div class="form-group col-md-12">
                                <label for="name" class="form-label">
                                    <div>Name<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message"></span>
                                </label>
                                <div class="col-sm-12">
                                    <input type="text" id="name" name="name" class="form-control"
                                        rules="required" value="{{ $isUpdate ? $product->name : '' }}">
                                </div>

                            </div><!-- / Name section -->
                        </div>

                        <div class="spacer"></div>

                        <fieldset class="product-spec row g-3">
                            <legend>Specification</legend>

                            <!-- Manufacture section -->
                            <div class="form-group col-md-6">
                                <label for="manufacture_id" class="form-label">
                                    <div>Manufacture<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message"></span>
                                </label>
                                <div class="col-sm-12">
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
                                </div>
                                <span class="form-message"></span>
                            </div><!-- / Manufacture section -->

                            <!-- Series section -->
                            <div class="form-group col-md-6">
                                <label for="series_id" class="form-label">
                                    <div>Series<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message"></span>
                                </label>
                                <div class="col-sm-12">
                                    <div class="my-custom-select">
                                        <select id="series_id" name="series_id" class="form-control" rules="required">
                                            <option value="">--- Select ---</option>
                                            @foreach ($series as $item)
                                                <option
                                                    value="{{ $item->id }}"{{ $isUpdate ? ($product->series->id == $item->id ? 'selected' : '') : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <span class="form-message"></span>
                            </div><!-- / Series section -->

                            <!-- CPU section -->
                            <div class="form-group col-md-6">
                                <label for="cpu_id" class="form-label">
                                    <div>CPU<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message"></span>
                                </label>
                                <div class="col-sm-12">
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

                            <!-- GPU section -->
                            <div class="form-group col-md-6">
                                <label for="gpu_id" class="form-label">
                                    <div>GPU<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message"></span>
                                </label>
                                <div class="col-sm-12">
                                    <div class="my-custom-select">
                                        <select id="gpu_id" name="gpu_id" class="form-control" rules="required">
                                            <option value="">--- Select ---</option>
                                            @foreach ($gpus as $item)
                                                <option
                                                    value="{{ $item->id }}"{{ $isUpdate ? ($product->gpu->id == $item->id ? 'selected' : '') : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <span class="form-message"></span>
                            </div><!-- / GPU section -->

                            <!-- RAM section -->
                            <div class="form-group col-md-4">
                                <label for="ram" class="form-label">
                                    <div>RAM<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message"></span>
                                </label>
                                <div class="col-sm-12 input-group my-input-group">
                                    <div class="my-custom-select input-group-prepend">
                                        <select id="ram_select" name="ram_select">
                                            <option
                                                value="1"{{ $isUpdate ? ($product->ram->amount < 1024 ? 'selected' : '') : 'selected' }}>
                                                in GB</option>
                                            <option
                                                value="2"{{ $isUpdate ? ($product->ram->amount >= 1024 ? 'selected' : '') : '' }}>
                                                in TB</option>
                                        </select>
                                    </div>
                                    <input type="text" id="ram" name="ram" class="form-control"
                                        rules="required|min:0,exclude"
                                        value="{{ $isUpdate ? ($product->ram->amount < 1024 ? $product->ram->amount : $product->ram->amount / 1024) : '' }}">
                                </div>
                                <span class="form-message"></span>
                            </div><!-- / RAM section -->

                            <!-- HDD section -->
                            <div class="form-group col-md-4">
                                <label for="hdd" class="form-label">
                                    <div>HDD<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message"></span>
                                </label>
                                <div class="col-sm-12 input-group my-input-group">
                                    <div class="my-custom-select input-group-prepend">
                                        <select id="hdd_select" name="hdd_select">
                                            <option
                                                value="1"{{ $isUpdate ? ($product->hdd->amount < 1024 ? 'selected' : '') : 'selected' }}>
                                                in GB</option>
                                            <option
                                                value="2"{{ $isUpdate ? ($product->hdd->amount >= 1024 ? 'selected' : '') : '' }}>
                                                in TB</option>
                                        </select>
                                    </div>
                                    <input type="text" id="hdd" name="hdd" class="form-control"
                                        rules="required|min:0"
                                        value="{{ $isUpdate ? ($product->hdd->amount < 1024 ? $product->hdd->amount : $product->hdd->amount / 1024) : '' }}">
                                    <div class="myTooltip">
                                        <span class="tooltiptext">0 indicates product has no HDD</span>
                                    </div>
                                </div>
                                <span class="form-message"></span>
                            </div><!-- / HDD section -->

                            <!-- SSD section -->
                            <div class="form-group col-md-4">
                                <label for="ssd" class="form-label">
                                    <div>SSD<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message"></span>
                                </label>
                                <div class="col-sm-12 input-group my-input-group">
                                    <div class="my-custom-select input-group-prepend">
                                        <select id="ssd_select" name="ssd_select">
                                            <option
                                                value="1"{{ $isUpdate ? ($product->ssd->amount < 1024 ? 'selected' : '') : 'selected' }}>
                                                in GB</option>
                                            <option
                                                value="2"{{ $isUpdate ? ($product->ssd->amount >= 1024 ? 'selected' : '') : '' }}>
                                                in TB</option>
                                        </select>
                                    </div>
                                    <input type="text" id="ssd" name="ssd" class="form-control"
                                        rules="required|min:0"
                                        value="{{ $isUpdate ? ($product->ssd->amount < 1024 ? $product->ssd->amount : $product->ssd->amount / 1024) : '' }}">
                                    <div class="myTooltip">
                                        <span class="tooltiptext">0 indicates product has no SSD</span>
                                    </div>

                                </div>
                                <span class="form-message"></span>
                            </div><!-- / SSD section -->

                            <!-- Resolution section -->
                            <div class="form-group col-md-6">
                                <label for="resolution_id" class="form-label">
                                    <div>Screen Resolution<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message"></span>
                                </label>
                                <div class="col-sm-12">
                                    <div class="my-custom-select">
                                        <select id="resolution_id" name="resolution_id" class="form-control"
                                            rules="required">
                                            <option value="">--- Select ---</option>
                                            @foreach ($resolutions as $item)
                                                <option
                                                    value="{{ $item->id }}"{{ $isUpdate ? ($product->resolution->id == $item->id ? 'selected' : '') : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <span class="form-message"></span>
                            </div><!-- / Resolution section -->

                            <!-- Screen section -->
                            <div class="form-group col-md-6">
                                <label for="screen" class="form-label">
                                    <div>Screen Size<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message"></span>
                                </label>
                                <div class="col-sm-12">
                                    <input type="text" id="screen" name="screen" class="form-control"
                                        rules="required|min:0,exclude" placeholder="(in inch)"
                                        value="{{ $isUpdate ? $product->screen->amount : '' }}">
                                </div>
                                <span class="form-message"></span>
                            </div><!-- / Screen section -->

                            <!-- Color section -->
                            <div class="form-group col-md-6">
                                <label for="color_id" class="form-label">
                                    <div>Color<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message"></span>
                                </label>
                                <div class="col-sm-12">
                                    <div class="my-custom-select">
                                        <select id="color_id" name="color_id" class="form-control" rules="required">
                                            <option value="">--- Select ---</option>
                                            @foreach ($colors as $item)
                                                <option
                                                    value="{{ $item->id }}"{{ $isUpdate ? ($product->color->id == $item->id ? 'selected' : '') : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <span class="form-message"></span>
                            </div><!-- / Color section -->

                            <!-- Demand section -->
                            <div class="form-group col-md-6">
                                <label for="demand_id" class="form-label">
                                    <div>Demand<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message"></span>
                                </label>
                                <div class="col-sm-12">
                                    <div class="my-custom-select">
                                        <select id="demand_id" name="demand_id" class="form-control" rules="required">
                                            <option value="">--- Select ---</option>
                                            @foreach ($demands as $item)
                                                <option
                                                    value="{{ $item->id }}"{{ $isUpdate ? ($product->demand->id == $item->id ? 'selected' : '') : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <span class="form-message"></span>
                            </div><!-- / Demand section -->
                        </fieldset>

                        <div class="spacer"></div>

                        {{-- ------------------------------Description section start---------------------------------------------- --}}
                        <fieldset class="product-desc row g-3">
                            <legend>Description</legend>

                            <!-- Weight section -->
                            <div class="form-group col-md-6">
                                <label for="weight" class="form-label">Weight</label>
                                <div class="col-sm-12">
                                    <input type="text" id="weight" name="weight" class="form-control"
                                        placeholder="(in Kg)"
                                        value="{{ $isUpdate ? $product->description->weight ?? '' : '' }}">
                                </div>
                            </div><!-- / Weight section -->

                            <!-- Dimension section -->
                            <div class="form-group col-md-6">
                                <label for="dimension" class="form-label">Dimension</label>
                                <div class="col-sm-12">
                                    <input type="text" id="dimension" name="dimension" class="form-control"
                                        placeholder="Height x Width x Depth (in cm)"
                                        value="{{ $isUpdate ? $product->description->dimension ?? '' : '' }}">
                                </div>
                            </div><!-- / Dimension section -->

                            <!-- Webcam section -->
                            <div class="form-group col-md-3">
                                <label for="webcam" class="form-label">Webcam</label>
                                <div class="col-sm-12">
                                    <input type="text" id="webcam" name="webcam" class="form-control"
                                        value="{{ $isUpdate ? $product->description->webcam ?? '' : '' }}">
                                </div>
                            </div><!-- / Webcam section -->

                            <!-- OS section -->
                            <div class="form-group col-md-3">
                                <label for="o_s" class="form-label">Operating System</label>
                                <div class="col-sm-12">
                                    <input type="text" id="o_s" name="o_s" class="form-control"
                                        value="{{ $isUpdate ? $product->description->o_s ?? '' : '' }}">
                                </div>
                            </div><!-- / OS section -->

                            <!-- Battery section -->
                            <div class="form-group col-md-3">
                                <label for="battery" class="form-label">Battery</label>
                                <div class="col-sm-12">
                                    <input type="text" id="battery" name="battery" class="form-control"
                                        placeholder="(in Wh)"
                                        value="{{ $isUpdate ? $product->description->battery ?? '' : '' }}">
                                </div>
                            </div><!-- / Battery section -->

                            <!-- Warranty section -->
                            <div class="form-group col-md-3">
                                <label for="warranty" class="form-label">Warranty</label>
                                <div class="col-sm-12">
                                    <input type="text" id="warranty" name="warranty" class="form-control"
                                        placeholder="(in month)"
                                        value="{{ $isUpdate ? $product->description->warranty ?? '' : '' }}">
                                </div>
                            </div><!-- / Warranty section -->

                            <!-- Instruction section -->
                            <div class="form-group col-md-12">
                                <label for="instruction" class="form-label">Instruction</label>
                                <div class="col-sm-12">
                                    <textarea type="text" id="instruction" name="instruction" class="form-control" rows="6">{{ $isUpdate ? $product->description->instruction ?? '' : '' }}</textarea>
                                </div>
                            </div><!-- / Instruction section -->

                            <!-- Feature section -->
                            <div class="form-group col-md-12">
                                <label for="feature" class="form-label">Feature</label>
                                <div class="col-sm-12">
                                    <textarea type="text" id="feature" name="feature" class="form-control" rows="14">{{ $isUpdate ? $product->description->feature ?? '' : '' }}</textarea>
                                </div>
                            </div><!-- / Feature section -->

                            <!-- Create the editor container -->
                            {{-- <div id="quillEditor">
                                <p>Hello World!</p>
                                <p>Some initial <strong>bold</strong> text</p>
                                <p><br></p>
                            </div> --}}
                        </fieldset>
                        {{-- ------------------------------Description section end---------------------------------------------- --}}

                        <div class="spacer"></div>

                        <!-- Images section -->
                        <fieldset class="product-image">
                            <legend>Image</legend>
                            @include('components.imageUpload')
                        </fieldset>
                        <!-- / Images section -->

                        <div class="text-center">
                            <button type="submit"
                                class="btn btn-primary my-btn">{{ $isUpdate ? 'Update' : 'Submit' }}</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End Horizontal Form -->
                </div>
            </div>
            <!-- /.card -->
        @endif
    </section><!-- End Main Section -->
@endsection

@section('myJs')
    <!-- Start KienJs -->
    <script type="module">
        import {FilesUpload} from '{{ asset('/js/KienJs/FilesUpload.js') }}';
        import {CustomSelect} from '{{ asset('/js/KienJs/customSelect.js') }}';
        import {Validator} from '{{ asset('/js/KienJs/validator.js') }}';


        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {

                // Custom-select
                const customSelect = new CustomSelect({
                    orginialInput: "my-custom-select",
                });

                // Upload images
                const filesUpload = new FilesUpload({filesUpload: ".myFilesUpload"});

                // Input validation
                const productForm = new Validator('#createProduct');

                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace('instruction', {
                    filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}'
                });
                CKEDITOR.replace('feature', {
                    filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}'
                });
            }
        });
    </script><!-- End KienJs -->

    @include('ckfinder::setup')

@endsection
