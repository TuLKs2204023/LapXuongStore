@extends('fe.layout.layout')

@section('fetitle', '- Edit Profile')

@section('myCss')
    <style>
        body {
            margin-top: 20px;
            color: #1a202c;
            text-align: left;
            /* background-color: #e2e8f0; */
        }

        .main-body {
            padding: 15px;


        }

        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100% !important;
        }

        .shadow-none {
            box-shadow: none !important;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="main-body">
            <!-- Breadcrumb -->
            <div class="breadcrumb-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-text">
                                <a href="{{ Route('fe.home') }}"><i class="fa fa-home"></i>Home</a>
                                <a href="{{ Route('userProfile') }}">{{ auth()->user()->name }}</a>
                                <span>Update Information</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /Breadcrumb -->
            <div class="col-lg-10">
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="{{ URL::to('/update-byuser/' . $edit->id) }}" role="form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <h4 class="d-flex align-items-center mb-3" style="padding-left: 270px"><i
                                    class="material-icons text-info mr-2">Information Update
                                    of {{ auth()->user()->name }}</i></h4>
                                    <br>
                            <input type="hidden" name="role" value="Customer">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0" style="vertical-align: middle">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="name" class="form-control" value="{{ $edit->name }}"
                                        required placeholder="Please update your name">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="email" name="email" class="form-control" value="{{ $edit->email }}"
                                        required disabled>
                                    <input type="hidden" name="email" value="{{ $edit->email }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="phone" name="phone" class="form-control" value="{{ $edit->phone }}"
                                        required placeholder="Please update your Phone numer">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Gender</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select name="gender" class="form-control" rules="required">
                                        <option value="{{ $edit->gender }}">
                                            {{ isset($edit->gender) ? $edit->gender : 'Select Gender' }} </option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="No thanks">No Thanks</option>

                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">City</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select id="City-dropdown" class="form-control" name="city">
                                        <option value="{{ auth()->user()->city_id ?? '' }}">
                                            {{ isset(auth()->user()->city->name) ? auth()->user()->city->name : 'Select your city' }}
                                        </option>
                                        @foreach ($city as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">District</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select id="district-dropdown" class="form-control" name="district">
                                        <option value="{{ auth()->user()->district_id ?? '' }}">
                                            {{ isset(auth()->user()->district->name) ? auth()->user()->district->name : 'Select your district' }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Ward</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select id="ward-dropdown" class="form-control" name="ward" value="">
                                        <option value="{{ auth()->user()->ward_id ?? '' }}">
                                            {{ isset(auth()->user()->ward->name) ? auth()->user()->ward->name : 'Select your ward' }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Street</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="address" class="form-control" value="{{ $edit->address }}"
                                        required placeholder="Please update your address">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Image</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="file" name="photo" class="form-control"
                                        @if (isset($edit->image)) value = "{{ $edit->image }}" @endif
                                        onchange="loadFile(event)" accept="image/*"
                                        >
                                    @if (isset($edit->image))
                                        <div class="col-lg-3">
                                            <br>
                                            <img id="output"/ src="{{ asset('images/' . $edit->image) }}" alt="{{ $edit->image }}" >

                                        </div>


                                    @endif


                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="btn btn-info " type="submit" style="background-color:#4154f1;border-color:#4154f1">Update</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
        </div>
    </div>
@endsection
@section('myJs')
    <!-- Start KienJs -->
    <script type="module">
        import {FilesUpload} from '{{ asset('/js/KienJs/FilesUpload.js') }}';
        import {CustomSelect} from '{{ asset('/js/KienJs/customSelect.js') }}';
        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {
                const customSelect = new CustomSelect({
                    orginialInput: "my-custom-select",
                });

                const filesUpload = new FilesUpload({
                    filesUpload: ".myFilesUpload",
                    multiple: false
                });
            }
        });
    </script><!-- End KienJs -->
    <!-- Start imgpreviewJs -->
    <script>
        var loadFile = function(event) {
          var output = document.getElementById('output');
          output.src = URL.createObjectURL(event.target.files[0]);
          output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
          }
        };
        </script>
    <!-- End imgpreviewJs -->

@endsection
