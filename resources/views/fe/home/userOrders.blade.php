@section('fetitle', '- My Orders')
@extends('fe.layout.layout')
@section('myCss')
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');

        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: white;
            background-clip: border-box;
            border: 1px solid white;
            border-radius: 0.10rem
        }

        fieldset.card-body {
            background-color: #f9fafc;
            border-radius: 4px;
            box-shadow: 2px 2px 6px rgb(1 41 112 / 10%), -2px -2px 6px rgb(1 41 112 / 10%);
            margin-bottom: 25px;
            margin-top: 20px;
        }

        fieldset legend {
            float: none;
            text-transform: uppercase;
            font-size: 0.8rem;
            color: #fff;
            font-weight: bold;
            text-align: center;
            width: auto !important;
            background-color: var(--violet-tu);
            border-radius: 4px;
            padding: 10px 50px !important;
            margin: 0;
        }

        fieldset legend:hover {
            opacity: 0.5;
            cursor: pointer;
        }

        fieldset legend a {
            color: white;
        }

        .card-header:first-child {
            border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1)
        }

        .track {
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 60px;
            margin-top: 50px
        }

        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative
        }

        .track .step.active:before {
            background: var(--violet-tu);
        }

        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px
        }

        .track .step.active .icon {
            background: var(--violet-tu-dark);
            color: #fff
        }

        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd
        }

        .track .step.active .text {
            font-weight: 400;
            color: #000
        }

        .track .text {
            display: block;
            margin-top: 7px
        }

        .itemside {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 100%
        }

        .itemside .aside {
            position: relative;
            -ms-flex-negative: 0;
            flex-shrink: 0
        }

        .img-sm {
            width: 80px;
            height: 80px;
            padding: 7px
        }

        ul.row,
        ul.row-sm {
            list-style: none;
            padding: 0
        }

        .itemside .info {
            padding-left: 15px;
            padding-right: 7px
        }

        .itemside .title {
            display: block;
            margin-bottom: 5px;
            color: #212529
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem
        }

        .tu-back-btn {
            color: var(--violet);
        }

        .tu-back-btn:hover {
            color: var(--violet-main);
        }

        .cancelBtn {
            text-align: right !important;
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ Route('fe.home') }}"><i class="fa fa-home"></i>Home</a>
                        <a href="{{ Route('userProfile') }}">{{ auth()->user()->name }}</a>
                        <span>Orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->
    <div class="container">
        <article class="card">
            @foreach ($orders as $order)
                <fieldset class="card-body" data-index="{{ $order->id }}">
                    <legend class="order-head-name">
                        Order ID: LXS-{{ $order->id }}
                    </legend>
                    <article class="card">
                        <div class="card-body row">
                            <div class="col"> <strong>Estimated Delivery time:</strong>
                                <br>{{ $order->arrivalEstimate() }}
                            </div>
                            <div class="col"> <strong>Shipping BY:</strong> <br> LapXuongStore's Shipper<br>
                                <i class="fa fa-phone"></i>
                                +8413456789
                            </div>
                            <div class="col"> <strong>Status:</strong> <br>
                                <div class="status">
                                    @if ($order->status == 1)
                                        @if ($order->statusByTime() >= 0 && $order->statusByTime() < 1)
                                            Order confirmed
                                        @elseif($order->statusByTime() >= 1 && $order->statusByTime() < 3)
                                            Picked by courier
                                        @elseif($order->statusByTime() >= 3 && $order->statusByTime() < 7)
                                            On the way
                                        @else
                                            Ready for pickup
                                        @endif
                                    @else
                                        Canceled
                                    @endif
                                </div>
                            </div>
                            <div class="col"> <strong>Address:</strong> <br> {{ $order->address }} </div>
                        </div>
                    </article>
                    <div class="track">
                        <div class="step order active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                class="text">Order confirmed</span> </div>
                        <div class="step pick @if ($order->statusByTime() >= 1) active @endif"> <span class="icon"> <i
                                    class="fa fa-user"></i> </span> <span class="text">
                                Picked by courier</span> </div>
                        <div class="step on-way @if ($order->statusByTime() >= 3) active @endif">
                            <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text">
                                On
                                the way </span>
                        </div>
                        <div class="step arrived @if ($order->statusByTime() >= 7) active @endif"> <span class="icon"> <i
                                    class="fa fa-box"></i> </span> <span class="text">Ready
                                for pickup</span> </div>
                    </div>
                    <hr>
                    <ul class="row">
                        @foreach ($order->details as $item)
                            <li class="col-md-4">
                                <figure class="itemside mb-3">
                                    <div class="aside"><img src="{{ asset('images/' . $item->product->oldestImage->url) }}"
                                            class="img-sm border">
                                    </div>
                                    <figcaption class="info align-self-center">
                                        <p class="title">{{ $item->product->name }} <br> x{{ $item->quantity }}</p>
                                        <span
                                            class="text-muted">{{ number_format($item->product->fakePrice(), 0, ',', '.') . ' VND' }}
                                        </span>
                                    </figcaption>
                                </figure>
                            </li>
                        @endforeach
                    </ul>
                    @if ($order->statusByTime() >= 7)
                        <button class="btn btn-sm btn-success">Deliver successfully</button>
                    @else
                        @if ($order->status == 1)
                            <button class="btn btn-sm btn-danger cancelBtn">Cancel Order
                                LXS-{{ $order->id }}</button>
                        @elseif($order->status == 0)
                            <button class="btn btn-sm btn-warning">Your order has been canceled</button>
                        @endif
                    @endif
                </fieldset>
            @endforeach
            <div>
                {{ $orders->withQueryString()->links('vendor.pagination.footer') }}
            </div>
            <legend><a href="{{ Route('userProfile') }}" class="tu-back-btn"> <i class="fa fa-chevron-left"></i>
                    Back to
                    profile</a></legend>
        </article>
    </div>
@endsection

@section('myJs')
    <script>
        jQuery(document).ready(function($) {
            const cardBody = $(".card-body");

            //go to details of an order
            cardBody.each((index, element) => {
                const head = $(element).find("legend").get(0);
                $(head).on("click", function() {
                    let id = $(cardBody).attr('data-index');
                    let url = `{{ url('/user/${id}/order-details') }}`;
                    window.location.href = url;
                });
            });

            //cancel order
            cardBody.each(function(index, element) {
                const deleteBtn = $(element).find(".cancelBtn").get(0);
                $(deleteBtn).on("click", function(e) {
                    e.preventDefault();
                    const oId = $(element).attr('data-index');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this, once cancled your promotion code won't be returned back anymore!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4154f1',
                        cancelButtonColor: 'crimson',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "GET",
                                url: "{{ Route('cancelOrder') }}",
                                data: {
                                    oId: oId,
                                },
                                success: function(response) {
                                    const orderStt = $(element).find(".status")
                                        .get(0);
                                    $(deleteBtn).removeClass("btn-danger");
                                    $(deleteBtn).addClass("btn-warning");
                                    $(deleteBtn).html(
                                        "Your order has been canceled");
                                    $(deleteBtn).removeClass("cancelBtn");
                                    $(orderStt).html("Canceled");
                                }
                            })
                            Swal.fire(
                                'Canceled!',
                                'Your order is canceled successfully.',
                                'success',
                            )
                        }
                    })
                })
            })
        })
    </script>
@endsection
