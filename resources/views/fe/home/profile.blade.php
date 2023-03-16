@extends('fe.layout.layout')

@section('fetitle', '- Profile')

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
                                <span>{{ auth()->user()->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Breadcrumb -->
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card ">
                        <div class="card-body >
                            <h5 class="d-flex align-items-center mb-3"><i
                                class="material-icons text-info mr-2" style="padding-left: 95px">Avatar
                                of</i>{{ auth()->user()->name }}</h5>


                            <div class="d-flex flex-column align-items-center text-center">
                                <br>
                                <img src="{{ isset(auth()->user()->image)
                                    ? asset('images/' . auth()->user()->image)
                                    : 'https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/626fd8140423801.6241b91e24d9c.png' }}"
                                    alt="Admin" class="rounded" width="150">
                                <div class="mt-3">
                                    <h4>{{ auth()->user()->name }}</h4>
                                    <p class="text-secondary mb-1">{{ auth()->user()->role }}</p>
                                    <p class="text-muted font-size-sm">{{ auth()->user()->address }}</p>
                                    <a class="btn btn-info " style="background-color:#4154f1;border-color:#4154f1;"
                                        href="{{ Route('wishlist') }}">Wishlist</a>
                                    <a href="{{ Route('userOrders') }}" class="btn  btn-info"
                                        style="border-color:#4154f1; background-color:#4154f1;">My Orders</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="d-flex align-items-center mb-3" style="padding-left: 250px"><i
                                    class="material-icons text-info mr-2">Information
                                    of</i>{{ auth()->user()->name }}</h5>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ auth()->user()->name }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Gender</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ auth()->user()->gender }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ auth()->user()->phone }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ auth()->user()->address ?? 'Not updated' }} -
                                    {{ auth()->user()->ward->name ?? '' }} - {{ auth()->user()->district->name ?? '' }} -
                                    {{ auth()->user()->city->name ?? '' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row" style="text-align:center">
                                <div class="col-sm-12">
                                    <a class="btn btn-info " style="background-color:#4154f1;border-color:#4154f1"
                                        href="{{ Route('editbyuser', auth()->user()->id) }}">Edit</a>
                                    <a class="btn btn-info" style="border-color:#4154f1; background-color:#4154f1;"
                                        href="{{ Route('passwordUser', auth()->user()->id) }}">Change Password</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row gutters-sm">

                        <div class="col-sm-12 mb-3">
                            <div class="card h-100">
                                <div class="card-body"
                                    style="
                                height: 300px;
                                overflow: auto;">
                                    <h5 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2"
                                            style="padding-left: 220px">History Interaction
                                            of</i>{{ auth()->user()->name }}</h5>

                                    @foreach ($rating as $key => $val)
                                        @if ($val->user->name == auth()->user()->name)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-forward-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="m9.77 12.11 4.012-2.953a.647.647 0 0 0 0-1.114L9.771 5.09a.644.644 0 0 0-.971.557V6.65H2v3.9h6.8v1.003c0 .505.545.808.97.557z" />
                                            </svg>
                                            <small>{{ $val->time() }}</small>
                                            <div>
                                                <a href="{{ Route('product.details', $val->product->slug) }}"
                                                    class="fw-bold text-dark" style="margin-block-end:0.5em;">

                                                    <span class="fw-light">{{ $val->rating }}</span> and Reviewed :
                                                    <span class="fw-light">{{ $val->review }}</span> on
                                                    <span class="fw-light">{{ $val->product->name }} .</span>
                                                </a>
                                            </div>
                                            <hr>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
