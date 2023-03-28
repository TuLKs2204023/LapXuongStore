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

        h5 .badge.bg-danger.cancelBtn, h5 .badge.bg-danger.cancelBtn-late {
            color: white;
            cursor: pointer;
        }

        .status {
            color: white;
        }

        h5 .badge.bg-success,
        h5 .badge.bg-warning {
            color: white;
        }

        .section-big-py-space {
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .success-text {
            text-align: center;
        }

        .success-text i {
            font-size: 80px;
            color: var(--violet);
        }

        .success-text h2 {
            text-transform: uppercase;
            font-size: calc(20px + (36 - 20) * ((100vw - 320px) / (1920 - 320)));
            color: $font-color;
            font-weight: 700;
            padding: 1rem 0;
        }

        .success-text p {
            text-transform: capitalize;
            font-size: calc(14px + (18 - 14) * ((100vw - 320px) / (1920 - 320)));
        }

        .success-text.order-fail i {
            color: var(--danger);
        }

        button {
            text-align: center;
        }

        #back {
            margin-left: 90px;
        }

        #view {
            background-color: var(--violet);
        }
    </style>
@endsection

@section('content')
    @if (auth()->user()->role !== 'Customer')
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <br>
            <br>
            <h3>Sorry ! The page you are looking only availabled for Customer !</h3>
            <img src="{{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">
        </section>
    @endif
    @if (auth()->user()->role == 'Customer')
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
            @if (count($orders) > 0)
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
                                            @php echo $order->statusProcessingWithBadge() @endphp
                                        </div>
                                    </div>
                                    <div class="col"> <strong>Address:</strong> <br> {{ $order->address }} </div>
                                </div>
                            </article>
                            <div class="track">
                                @if ($order->status == 1)
                                    <div class="step order active"> <span class="icon"> <i class="fa fa-check"></i>
                                        </span>
                                        <span class="text">Order confirmed</span>
                                    </div>
                                    <div class="step pick @if ($order->statusByTime() >= 1) active @endif"> <span
                                            class="icon"> <i class="fa fa-user"></i> </span> <span class="text">
                                            Picked by courier</span> </div>
                                    <div class="step on-way @if ($order->statusByTime() >= 3) active @endif">
                                        <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text">
                                            On
                                            the way </span>
                                    </div>
                                    <div class="step arrived @if ($order->statusByTime() >= 7) active @endif"> <span
                                            class="icon">
                                            <i class="fa fa-box"></i> </span> <span class="text">Ready
                                            for pickup</span> </div>
                                @elseif($order->status == 0)
                                    <div class="step order active"> <span class="icon"> <i class="fa fa-frown-o"></i>
                                        </span>
                                        <span class="text">Cancelled</span>
                                    </div>
                                @endif
                            </div>
                            <hr>
                            <ul class="row">
                                @foreach ($order->details as $item)
                                    <li class="col-md-4">
                                        <figure class="itemside mb-3">
                                            <div class="aside"><img
                                                    src="{{ asset('images/' . $item->product->oldestImage->url) }}"
                                                    class="img-sm border">
                                            </div>
                                            <figcaption class="info align-self-center">
                                                <p class="title">{{ $item->product->name }} <br> x{{ $item->quantity }}
                                                </p>
                                                <span
                                                    class="text-muted">{{ number_format($item->product->fakePrice(), 0, ',', '.') . ' VND' }}
                                                </span>
                                            </figcaption>
                                        </figure>
                                    </li>
                                @endforeach
                            </ul>
                            @if ($order->statusByTime() >= 7)
                                <h5><span class="badge bg-success">Deliver successfully</span></h5>
                            @else
                                @if ($order->status == 1)
                                    @if ($order->statusByTime() > 1)
                                        <h5><span class="badge bg-danger cancelBtn-late">
                                                Cancel Order LXS-{{ $order->id }} </span></h5>
                                    @else
                                        <h5><span class="badge bg-danger cancelBtn">
                                                Cancel Order LXS-{{ $order->id }} </span></h5>
                                    @endif
                                @elseif($order->status == 0)
                                    <h5><span class="badge bg-warning">Your order has been cancelled</span></h5>
                                @endif
                            @endif
                            <div class="tu-send-mail-message"></div>
                        </fieldset>
                    @endforeach
                    <div>
                        {{ $orders->withQueryString()->links('vendor.pagination.footer') }}
                    </div>
                    <legend><a href="{{ Route('userProfile') }}" class="tu-back-btn"> <i class="fa fa-chevron-left"></i>
                            Back to
                            profile</a></legend>
                </article>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="success-text"><a href="{{ Route('fe.shop.index') }}"><i class="fa fa-shopping-basket"
                                    aria-hidden="true"></i></a>
                            <h2>No Order</h2>
                            <p>You still not have any orders yet</p>
                            <p>Would you prefer to take a trip to our shop?</p>
                            <p><i class="fa fa-hand-o-up" aria-hidden="true"></i> CLICK THE CART <i class="fa fa-hand-o-up"
                                    aria-hidden="true"></i></p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
@endsection

@section('myJs')
    <script>
        jQuery(document).ready(function($) {
            const cardBody = $(".card-body");

            //go to details of an order
            cardBody.each((index, element) => {
                const head = $(element).find("legend").get(0);
                $(head).on("click", function() {
                    let id = $(element).attr('data-index');
                    let url = `{{ url('/user/${id}/order-details') }}`;
                    window.location.href = url;
                });
            });

            //cancel order
            cardBody.each(function(index, element) {
                //cancel at order-confirmed
                const deleteBtn = $(element).find(".cancelBtn").get(0);
                $(deleteBtn).on("click", function(e) {
                    e.preventDefault();
                    const orderStt = $(element).find(".status").get(0);
                    const tracking = $(element).find(".track").get(0);
                    const message = $(element).find(".tu-send-mail-message").get(0);
                    const oId = $(element).attr('data-index');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this, once cancelled your promotion code won't be returned back anymore!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4154f1',
                        cancelButtonColor: 'crimson',
                        confirmButtonText: 'Yes, cancel it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(deleteBtn).html(
                                '<div class="spinner-border spinner-border-sm"></div> Cancellation is processing!'
                            );
                            Swal.fire(
                                'Cancelling!',
                                'Your cancellation is processing, please wait for a few seconds.',
                                'info',
                            )
                            $.ajax({
                                type: "GET",
                                url: "{{ Route('cancelOrder') }}",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                },
                                data: {
                                    oId: oId,
                                },
                                success: function(response) {
                                    if (response.status) {
                                        $(deleteBtn).removeClass("bg-danger");
                                        $(deleteBtn).addClass("bg-warning");
                                        $(deleteBtn).html(response.orderMsg);
                                        $(deleteBtn).removeClass("cancelBtn");
                                        $(orderStt).html(
                                            '<span class="badge rounded-pill bg-danger">Cancelled</span>'
                                        );
                                        $(tracking).empty();
                                        $(tracking).html(
                                            '<div class="step order active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Cancelled</span></div>'
                                        )
                                        $(message).addClass(
                                            "alert alert-success main-success"
                                        );
                                        $(message).html(response.emailMsg);
                                    } else {
                                        $(deleteBtn).html(response.orderMsg);
                                        $(deleteBtn).removeClass("cancelBtn");
                                        $(message).addClass(
                                            "alert alert-danger");
                                        $(message).html(response.emailMsg);
                                    }
                                }
                            })
                        }
                    })
                })

                //cancel late
                const deleteBtnLate = $(element).find(".cancelBtn-late").get(0);
                console.log(deleteBtnLate)
                $(deleteBtnLate).on("click", function(e) {
                    e.preventDefault();
                    Swal.fire(
                        'Announcement!',
                        `Your cancellation is refused to be cancelled, only <b>Order Confirmed</b> stage is allowed to be cancelled by yourself. If you strongly need to cancel this order, please contact our support <b><i>LapXuongShop@support.com</i></b> to have the best support, thank you!` ,
                        'info',
                    )
                })
            })
        })
    </script>
@endsection
