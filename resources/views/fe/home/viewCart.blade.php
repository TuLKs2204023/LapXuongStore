@extends('fe.layout.layout')

@section('fetitle', '- Cart')

@section('myCss')
    <style>
        .proceed-checkout a.proceed-checkout-btn span {
            text-transform: capitalize;
            font-size: 0.8rem;
            font-weight: lighter;
        }
    </style>
@endsection

@section('content')
    @if (!Auth::check())
        <!-- BREADCUMB SECTION BEGIN-->
        <div class="breadcrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-text">
                            <a href="{{ Route('fe.home') }}"><i class="fa fa-home"></i> Home</a>
                            <a href="{{ Route('fe.shop.index') }}">Shop</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BREADCUMB SECTION END-->

        <!-- Shoping-cart SECTION BEGIN-->
        <div class="shopping-cart spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cart-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Images</th>
                                        <th class="p-name">Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="products-cart">
                                    @if (session('cart'))
                                        @foreach (session('cart') as $item)
                                            <tr class="pr-cart-item" data-index="{{ $item->product->id }}">
                                                <td class="cart-pic first-row"><a
                                                        href="{{ Route('product.details', $item->product->slug) }}"><img
                                                            src="{{ asset('images/' . $item->product->oldestImage->url) }}"
                                                            alt="{{ $item->product->name }}"></a></td>
                                                <td class="cart-title first-row">
                                                    <h5>{{ $item->product->name }}</h5>
                                                </td>
                                                <td class="p-price first-row">
                                                    {{ number_format($item->product->fakePrice(), 0, ',', '.') }}</td>
                                                <td class="qua-col first-row">
                                                    <div class="quantity">
                                                        <div class="pro-qty">
                                                            <input type="text" value="{{ $item->quantity }}"
                                                                data-stock="{{ $item->product->inStock() - $item->product->outStock() - $item->quantity }}"
                                                                name="product-quantity">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="total-price first-row">
                                                    {{ number_format($item->product->fakePrice() * $item->quantity, 0, ',', '.') }}
                                                </td>
                                                <td class="close-td first-row"><i class="ti-close"></i></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"> &#128557; I'm hungry, feed me some laptops please &#128557;
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row order-summary">
                            <div class="col-lg-4">
                                <div class="cart-buttons">
                                    <a href="{{ Route('fe.shop.index') }}" class="primary-btn up-cart"> Continue
                                        Shopping</a>
                                </div>
                                {{-- <div class="discount-coupon">
                            <h6>Disscount Codes</h6>
                            <form action="#" class="coupon-form">
                                <input type="text" placeholder="Enter Your Codes">
                                <button type="submit" class="site-btn coupon-btn">Apply</button>
                            </form>
                        </div> --}}
                            </div>

                            <div class="col-lg-4 offset-lg-4">
                                <div class="proceed-checkout">
                                    <ul>
                                        <li class="subtotal">Subtotal
                                            <span class="ajax-summary">{{ number_format($total['value'], 0, ',', '.') }}
                                                VND</span>
                                        </li>
                                        <li class="cart-total">Total <span
                                                class="ajax-summary">{{ number_format($total['value'], 0, ',', '.') }}
                                                VND</span></li>
                                    </ul>
                                    <a href="{{ Route('checkout') }}" class="proceed-checkout-btn site-btn proceed-btn">
                                        PROCEED TO CHECK OUT
                                        @if (auth()->user())
                                        @else
                                            <span> (need login)</span>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shoping-cart SECTION END-->
    @endif
    @auth
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
                                <span>Shopping Cart</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BREADCUMB SECTION END-->

            <!-- Shoping-cart SECTION BEGIN-->
            <div class="shopping-cart spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Images</th>
                                            <th class="p-name">Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="products-cart">
                                        @if (session('cart'))
                                            @foreach (session('cart') as $item)
                                                <tr class="pr-cart-item" data-index="{{ $item->product->id }}">
                                                    <td class="cart-pic first-row"><a
                                                            href="{{ Route('product.details', $item->product->slug) }}"><img
                                                                src="{{ asset('images/' . $item->product->oldestImage->url) }}"
                                                                alt="{{ $item->product->name }}"></a></td>
                                                    <td class="cart-title first-row">
                                                        <h5>{{ $item->product->name }}</h5>
                                                    </td>
                                                    <td class="p-price first-row">
                                                        {{ number_format($item->product->fakePrice(), 0, ',', '.') }}</td>
                                                    <td class="qua-col first-row">
                                                        <div class="quantity">
                                                            <div class="pro-qty">
                                                                <input type="text" value="{{ $item->quantity }}"
                                                                    data-stock="{{ $item->product->inStock() - $item->product->outStock() - $item->quantity }}"
                                                                    name="product-quantity">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="total-price first-row">
                                                        {{ number_format($item->product->fakePrice() * $item->quantity, 0, ',', '.') }}
                                                    </td>
                                                    <td class="close-td first-row"><i class="ti-close"></i></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6"> &#128557; I'm hungry, feed me some laptops please &#128557;
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="row order-summary">
                                <div class="col-lg-4">
                                    <div class="cart-buttons">
                                        <a href="{{ Route('fe.shop.index') }}" class="primary-btn up-cart"> Continue
                                            Shopping</a>
                                    </div>
                                    {{-- <div class="discount-coupon">
                                <h6>Disscount Codes</h6>
                                <form action="#" class="coupon-form">
                                    <input type="text" placeholder="Enter Your Codes">
                                    <button type="submit" class="site-btn coupon-btn">Apply</button>
                                </form>
                            </div> --}}
                                </div>

                                <div class="col-lg-4 offset-lg-4">
                                    <div class="proceed-checkout">
                                        <ul>
                                            <li class="subtotal">Subtotal
                                                <span class="ajax-summary">{{ number_format($total['value'], 0, ',', '.') }}
                                                    VND</span>
                                            </li>
                                            <li class="cart-total">Total <span
                                                    class="ajax-summary">{{ number_format($total['value'], 0, ',', '.') }}
                                                    VND</span></li>
                                        </ul>
                                        <a href="{{ Route('checkout') }}" class="proceed-checkout-btn site-btn proceed-btn">
                                            PROCEED TO CHECK OUT
                                            @if (auth()->user())
                                            @else
                                                <span> (need login)</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Shoping-cart SECTION END-->
        @endif
    @endauth
@endsection

@section('myJs')
    <!-- Start KienJs -->
    <script type="module">
        import {CartHandler} from '{{ asset('/js/KienJs/cart.js') }}';
        import {DeleteDialog} from '{{ asset('/js/KienJs/confirmDialog.js') }}';

        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {
                const updateCart = new CartHandler({
                    url: '{{ Route('updateCart') }}',
                    token: '{{ csrf_token() }}',
                    isUpdate: true,
                    inputName: "product-quantity",
                    selectors: {
                        cartOrBtnSelector: ".products-cart",
                        cartItemSelector: ".pr-cart-item",
                        summaryContSelector: ".order-summary",
                        summariesSelector: ".ajax-summary",
                        headerCartSelector: ".cart-icon",
                        checkoutBtnSelector: ".proceed-checkout-btn",
                    }
                });

                const deleteDialog = new DeleteDialog({
                    processUrl: '{{ Route('removeCart') }}',
                    processToken: '{{ csrf_token() }}',
                    selectors: {
                        deleteBtn: "td.close-td.first-row",
                        headerCartSelector: ".cart-icon",
                        checkoutBtnSelector: ".proceed-checkout-btn",
                    }
                });
            }
        });
    </script><!-- End KienJs -->
@endsection
