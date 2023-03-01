@section('fetitle','- Cart')
@extends('fe.layout.layout')
@section('content')
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
                                                {{ number_format($item->product->price, 0, ',', '.') }}</td>
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
                                                {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
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
                                <a href="{{ Route('fe.shop.index') }}" class="primary-btn up-cart"> Continue Shopping</a>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-lg-4">
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="subtotal">Subtotal
                                        <span class="ajax-summary">{{ number_format($total['value'], 0, ',', '.') }}
                                            VND</span>
                                    </li>
                                    <li class="cart-total">Total <span>Total after discount</span></li>
                                </ul>
                                <a href="{{ Route('checkout') }}" class="proceed-btn">PROCEED TO CHECK OUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shoping-cart SECTION END-->
@endsection

@section('myJs')
    <script type="module">
        import {CartHandler} from '{{ asset('/js/KienJs/cart.js') }}';
        import {ConfirmDialog} from '{{ asset('/js/KienJs/confirmDialog.js') }}';

        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {
                const updateCart = new CartHandler({
                    url: '{{ Route('updateCart') }}',
                    token: '{{ csrf_token() }}',
                    isUpdate: true,
                    cartOrBtnSelector: ".products-cart",
                    cartItemSelector: ".pr-cart-item",
                    inputName: "product-quantity",
                    summaryContSelector: ".order-summary",
                    summariesSelector: ".ajax-summary",
                    headerCartSelector: ".cart-icon",
                });

                const confirmDialog = new ConfirmDialog({
                    processUrl: '{{ Route('removeCart') }}',
                    processToken: '{{ csrf_token() }}',
                    deleteBtn: "td.close-td.first-row",
                    headerCartSelector: ".cart-icon",
                });
            }
        });
    </script>
@endsection
