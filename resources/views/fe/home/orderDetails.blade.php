@section('fetitle', '- Order Details')
@extends('fe.layout.layout')
@section('myCss')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

        #order-heading {
            background-color: var(--violet-3rd);
            position: relative;
            border-top-left-radius: 25px;
            max-width: 800px;
            padding-top: 20px;
            margin-top: 30px !important;
            margin: 30px auto 0px;
            /* border-radius: 4px; */
            box-shadow: 2px 2px 6px rgb(1 41 112 / 10%), -2px -2px 6px rgb(1 41 112 / 10%);
        }

        #order-heading .text-uppercase {
            font-size: 0.9rem;
            color: #777;
            font-weight: 600
        }

        #order-heading .h4 {
            font-weight: 600
        }

        #order-heading .h4+div p {
            font-size: 0.8rem;
            color: #777
        }

        .close {
            padding: 10px 15px;
            background-color: #777;
            border-radius: 50%;
            position: absolute;
            right: -15px;
            top: -20px
        }

        .wrapper {
            background-color: #ffffff !important;
            padding: 0px 50px 50px;
            max-width: 800px;
            margin: 0px auto 40px;
            border-bottom-left-radius: 25px;
            border-bottom-right-radius: 25px;
            /* border-radius: 4px; */
            box-shadow: 2px 2px 6px rgb(1 41 112 / 10%), -2px -2px 6px rgb(1 41 112 / 10%);
        }

        .table th {
            border-top: none
        }

        .table thead tr.text-uppercase th {
            font-size: 0.8rem;
            padding-left: 0px;
            padding-right: 0px
        }

        .table tbody tr th,
        .table tbody tr td {
            font-size: 0.9rem;
            padding-left: 0px;
            padding-right: 0px;
            padding-bottom: 5px
        }

        .list div b {
            font-size: 0.8rem
        }

        .list .order-item {
            font-weight: 600;
        }

        .list:hover {
            background-color: #f4f4f4;
            cursor: pointer;
            border-radius: 5px
        }

        label {
            margin-bottom: 0;
            padding: 0;
            font-weight: 900
        }

        button.btn {
            font-size: 0.9rem;
            background-color: #66cdaa
        }

        button.btn:hover {
            background-color: #5cb99a
        }

        .price {
            color: var(--orange-dark-tu) !important;
            font-weight: 700
        }

        p.text-justify {
            font-size: 0.9rem;
            margin: 0
        }

        .row {
            margin: 0px
        }

        .subscriptions {
            border: 1px solid #ddd;
            border-left: 5px solid #ffa500;
            padding: 10px
        }

        .subscriptions div {
            font-size: 0.9rem
        }

        @media(max-width: 425px) {
            .wrapper {
                padding: 20px
            }

            body {
                font-size: 0.85rem
            }

            .subscriptions div {
                padding-left: 5px
            }

            img+label {
                font-size: 0.75rem
            }
        }

        .detail-price-tu {
            text-align: right;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .text-muted .text-white.btn
        {
            background-color: var(--violet-3rd) !important;
        }

        div.ml-auto.h5{
            color: var(--violet);
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
                        <a href="{{ Route('userOrders') }}">Orders</a>
                        <span>Orders LXS-{{ $order->id }} Details</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    {{-- -----------------------------------------------Content----------------------------------------------- --}}
    <div class="d-flex flex-column justify-content-center align-items-center" id="order-heading">
        <div class="text-uppercase">
            <p>Order detail</p>
        </div>
        <div class="h4">{{ $order->created_at->format('jS F Y h:i:s A') }}</div>
        <div class="pt-1">
            <p>Order LXS-{{ $order->id }} is currently<b class="text-dark"> processing</b></p>
        </div>
        <div class="btn close text-white">&times;</div>
    </div>
    <div class="wrapper bg-white">
        <div class="table-responsive">
            <table class="table table-borderless">
                <thead>
                    <tr class="text-uppercase text-muted">
                        <th scope="col">product</th>
                        <th scope="col" class="text-right">price</th>
                    </tr>
                </thead>
            </table>
        </div>
        @foreach ($orderItems as $item)
            <div class="d-flex justify-content-start align-items-center list py-1">
                <div>
                    @if ($item->quantity == 1)
                        <b>{{ $item->quantity }} (PD)</b>
                    @else
                        <b>{{ $item->quantity }} (PDs)</b>
                    @endif
                </div>
                <div class="mx-4">
                    <img src="{{ asset('images/' . $item->product->oldestImage->url) }}"
                        alt="{{ $item->product->subName() }}" class="rounded-circle" width="30" height="30">
                </div>
                <div class="order-item">{{ $item->product->name }}</div>
                <div class="detail-price-tu">{{ number_format($item->product->salePrice(), 0, ',', '.') . ' VND' }}</div>
            </div>
        @endforeach
        <div class="pt-2 border-bottom mb-3"></div>
        <div class="d-flex justify-content-start align-items-center pl-3">
            <div class="text-muted">Payment Method</div>
            <div class="ml-auto">
                @if ($order->payment == 1)
                    <img src="https://www.freepnglogos.com/uploads/dollar-sign-png/dollar-sign-business-cash-cashe-dollar-dollars-earn-earn-36.png"
                        width="15" height="15" alt="">
                    <label>Cash on delivery</label>
                @elseif($order->payment == 2)
                    <img src="https://www.freepnglogos.com/uploads/mastercard-png/mastercard-logo-logok-15.png"
                        alt="" width="30" height="30">
                    <label>Bank on transfer</label>
                @endif
            </div>
        </div>
        <div class="d-flex justify-content-start align-items-center py-1 pl-3">
            <div class="text-muted">Shipping</div>
            <div class="ml-auto"> <label>Free</label> </div>
        </div>
        <div class="d-flex justify-content-start align-items-center pb-4 pl-3 border-bottom">
            <div class="text-muted"> <button class="text-white btn">{{ $order->discount() * 100 }}% Discount</button>
            </div>
            <div class="ml-auto price"> -{{ number_format($order->discountAmount(), 0, ',', '.') . ' VND' }} </div>
        </div>
        <div class="d-flex justify-content-start align-items-center pl-3 py-3 mb-4 border-bottom">
            <div class="text-muted"> Total </div>
            <div class="ml-auto h5"> {{ number_format($order->totalAfterDiscount(), 0, ',', '.') . ' VND' }} </div>
        </div>
        <div class="row border rounded p-1 my-3">
            <div class="col-md-6 py-3">
                <div class="d-flex flex-column align-items start"> <b>Billing Address</b>
                    <p class="text-justify pt-2">{{ $order->name }}, 356 Jonathon Apt.220,</p>
                    <p class="text-justify">Việt Nam</p>
                </div>
            </div>
            <div class="col-md-6 py-3">
                <div class="d-flex flex-column align-items start"> <b>Shipping Address</b>
                    <p class="text-justify pt-2">{{ $order->address }}</p>
                    <p class="text-justify">Việt Nam</p>
                </div>
            </div>
        </div>
        <div class="pl-3 font-weight-bold">Note</div>
        <div class="d-sm-flex justify-content-between rounded my-3 subscriptions">
            {{ $order->notes }}
        </div>
    </div>
    {{-- ----------------------------------------------- endContent----------------------------------------------- --}}
@endsection

@section('myJs')
    <script>
        jQuery(document).ready(function($) {
            $('.btn.close.text-white').on('click', function(){
                window.location.href = "{{ Route('userOrders') }}";
            })
        });
    </script>
@endsection
