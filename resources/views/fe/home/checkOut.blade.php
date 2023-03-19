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
            <form action="{{ Route('processCheckout') }}" class="checkout-form myForm" method="post" id="createCheckout">
                @csrf
                <div class="row">
                    <div class="col-lg-5">
                        {{-- <div class="checkout-content">
                            <a href="{{ Route('login') }}" class="content-btn">Click Here To Login</a>
                        </div> --}}
                        <h4>Biling Details</h4>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label for="name" class="form-label">
                                    <div>Name<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message heighter"></span>
                                </label>
                                <input type="text" id="name" name="name" class="form-control"
                                    rules="required" placeholder="Your name" value="{{ auth()->user()->name ?? '' }}">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="email" class="form-label">
                                    <div>Email<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message heighter"></span>
                                </label>
                                <input type="text" id="email" name="email" class="form-control"
                                    rules="required|email" placeholder="Your email address" value="{{ auth()->user()->email ?? '' }}">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="phone" class="form-label">
                                    <div>Phone<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message heighter"></span>
                                </label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    rules="required" placeholder="Your phone number" value="{{ auth()->user()->phone ?? '' }}">
                            </div>
                            <div class="col-lg-12 form-group">
                                <label for="city" class="form-label">
                                    <div>City<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message heighter"></span>
                                </label>
                                <select rules="required" id="City-dropdown" class="form-control" name="city">
                                    <option value="{{ auth()->user()->city_id ?? '' }}">
                                        {{ isset(auth()->user()->city->name) ? auth()->user()->city->name : 'Select your city' }}
                                    </option>
                                    @foreach ($res['cities'] as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->name }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" id="city" name="city" class="form-control"
                                    rules="required" placeholder="Shipping city name" value="{{ auth()->user()->city->name ?? '' }}"> --}}
                            </div>
                            <div class="col-lg-12 form-group">
                                <label for="district" class="form-label">
                                    <div>District<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message heighter"></span>
                                </label>
                                <select rules="required" id="district-dropdown" class="form-control" name="district">
                                    <option value="{{ auth()->user()->district_id ?? '' }}">
                                        {{ isset(auth()->user()->district->name) ? auth()->user()->district->name : 'Select your district' }}
                                    </option>
                                </select>
                                {{-- <input type="text" id="district" name="district" class="form-control"
                                    rules="required" placeholder="Shipping district name" value="{{ auth()->user()->district->name ?? '' }}"> --}}
                            </div>
                            <div class="col-lg-12 form-group">
                                <label for="ward" class="form-label">
                                    <div>Ward<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message heighter"></span>
                                </label>
                                <select rules="required" id="ward-dropdown" class="form-control" name="ward" value="">
                                    <option value="{{ auth()->user()->ward_id ?? '' }}">
                                        {{ isset(auth()->user()->ward->name) ? auth()->user()->ward->name : 'Select your ward' }}
                                    </option>
                                </select>
                                {{-- <input type="text" id="ward" name="ward" class="form-control"
                                    rules="required" placeholder="Shipping ward name" value="{{ auth()->user()->ward->name ?? '' }}"> --}}
                            </div>
                            <div class="col-lg-12 form-group">
                                <label for="address" class="form-label">
                                    <div>Address<span class="form-required">&nbsp;*</span></div>
                                    <span class="form-message heighter"></span>
                                </label>
                                <input type="text" id="address" name="address" class="form-control"
                                    rules="required" placeholder="Shipping address" value="{{ auth()->user()->address ?? '' }}">
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
        import {Validator} from '{{ asset('/js/KienJs/validator.js') }}';
        import {CheckoutHandler, CouponHandler} from '{{ asset('/js/KienJs/checkout.js') }}';
        // import {ConfirmDialog} from '{{ asset('/js/KienJs/confirmDialog.js') }}';

        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {
                const coupon = new CouponHandler({
                    url: '{{ Route('couponCheck') }}',
                    token: '{{ csrf_token() }}',
                    orderSummary: {},
                });
                // Input validation
                const productForm = new Validator('#createCheckout');
            }
        });
    </script><!-- End KienJs -->
@endsection
