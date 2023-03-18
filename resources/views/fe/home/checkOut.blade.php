@extends('fe.layout.layout')

@section('fetitle', '- Checkout')

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
        <!-- BREADCUMB SECTION BEGIN-->
        <div class="breadcrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-text">
                            <a href="{{ Route('fe.home') }}"><i class="fa fa-home"></i> Home</a>
                            <a href="{{ Route('fe.shop.index') }}">Shop</a>
                            <span>Check out</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BREADCUMB SECTION END-->

        <!-- Message section -->
        @include('components.message')
        <!-- / Message section -->

        <!-- Check-out SECTION BEGIN-->
        <div class="checkout-section spad">
            <div class="container">
                <form action="{{ Route('processCheckout') }}" class="checkout-form" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-5">
                            {{-- <div class="checkout-content">
                            <a href="{{ Route('login') }}" class="content-btn">Click Here To Login</a>
                        </div> --}}
                            <h4>Biling Details</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="name">Name<span>*</span></label>
                                    <input type="text" id="name" name="name" placeholder="Your name"
                                        value="{{ auth()->user()->name ?? '' }}">
                                </div>
                                <div class="col-lg-6">
                                    <label for="email">Email<span>*</span></label>
                                    <input type="email" id="email" name="email" placeholder="Your email address"
                                        value="{{ auth()->user()->email ?? '' }}">
                                </div>
                                <div class="col-lg-6">
                                    <label for="phone">Phone<span>*</span></label>
                                    <input type="text" id="phone" name="phone" placeholder="Your phone number"
                                        value="{{ auth()->user()->phone ?? '' }}">
                                </div>
                                <div class="col-lg-12">
                                    <label for="city">City<span>*</span></label>
                                    <input type="text" id="city" name="city" class="address"
                                        placeholder="Shipping city name" value="{{ auth()->user()->city->name ?? '' }}">
                                </div>
                                <div class="col-lg-12">
                                    <label for="district">District<span>*</span></label>
                                    <input type="text" id="district" name="district" class="address"
                                        placeholder="Shipping district name"
                                        value="{{ auth()->user()->district->name ?? '' }}">
                                </div>
                                <div class="col-lg-12">
                                    <label for="ward">Ward<span>*</span></label>
                                    <input type="text" id="ward" name="ward" class="address"
                                        placeholder="Shipping ward name" value="{{ auth()->user()->ward->name ?? '' }}">
                                </div>
                                <div class="col-lg-12">
                                    <label for="address">Address<span>*</span></label>
                                    <input type="text" id="address" name="address" class="address"
                                        placeholder="Ship to this address" value="{{ auth()->user()->address ?? '' }}">
                                </div>

                                <div class="col-lg-12">
                                    <label for="notes">Notes<span></span></label>
                                    <textarea type="text" id="notes" name="notes" rows="3"></textarea>
                                </div>
                                {{-- <div class="col-lg-12">
                                <div class="create-item">
                                    <label for="acc-create">
                                        Create an Account?
                                        <input type="checkbox" id="acc-create">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div> --}}
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="checkout-content discount-coupon coupon-form">
                                <input type="text" placeholder="Enter Your Coupon Code" id="couponCode"
                                    name="couponCode">
                                <button type="submit" class="site-btn coupon-btn">Apply</button>
                            </div>
                            <div class="place-order">
                                <H4>YOUR ORDER</H4>
                                <div class="order-total">
                                    <ul class="order-table">
                                        <li>Product <span>Total</span></li>
                                        <li class="order-summary">
                                            <ul class="order-summaries">
                                                @if (session('cart'))
                                                    @foreach (session('cart') as $item)
                                                        <li class="order-product" data-index="{{ $item->product->id }}">
                                                            <div class="order-product-image">
                                                                <img src="{{ asset('images/' . $item->product->oldestImage->url) }}"
                                                                    alt="{{ $item->product->name }}">
                                                            </div>
                                                            <div class="order-product-name">{{ $item->product->name }}
                                                            </div>
                                                            <div class="order-product-price">
                                                                <div>x&nbsp;
                                                                    <span class="order-product-quantity">
                                                                        {{ number_format($item->quantity, 0, ',', '.') }}
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    {{ number_format($item->product->fakePrice(), 0, ',', '.') }}
                                                                    VND</div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li class="order-product">
                                                        <div>Your cart is currently empty.</div>
                                                    </li>
                                                @endif
                                            </ul>
                                        </li>

                                        <li class="fw-nomal order-product-subtotal" data-value="{{ $res['totalAmt'] }}">
                                            Subtotal <span>{{ $res['totalVal'] }}
                                                VND</span></li>
                                        <li class="total-discount">Discount (<a>0</a>%)
                                            <span>0 VND</span>
                                        </li>
                                        <li class="total-price">Total <span>{{ $res['totalVal'] }} VND</span></li>
                                    </ul>
                                    <div class="order-payment">
                                        <div class="select-option">
                                            <select class="sorting" id="payment" name="payment" class="form-control">
                                                <option value="">--- Payment ---</option>
                                                <option value="1">Cash on Delivery</option>
                                                <option value="2">Bank Transfer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="order-btn">
                                        <button type="submit" class="site-btn place-btn">Place Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Check-out  SECTION END-->
    @endif
@endsection

@section('myJs')
    <!-- Start KienJs -->
    <script type="module">
        import {CheckoutHandler, CouponHandler} from '{{ asset('/js/KienJs/checkout.js') }}';
        // import {ConfirmDialog} from '{{ asset('/js/KienJs/confirmDialog.js') }}';

        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {
                const coupon = new CouponHandler({
                    url: '{{ Route('couponCheck') }}',
                    token: '{{ csrf_token() }}',
                    orderSummary: {},
                });
            }
        });
    </script><!-- End KienJs -->
@endsection
