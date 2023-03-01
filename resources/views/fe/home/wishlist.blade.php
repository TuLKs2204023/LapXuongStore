@extends('fe.layout.layout')

@section('myCss')
    <style>
        .product-cart tr td .close-td.first-row a {
            color: black;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <!-- BREADCUMB SECTION BEGIN-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ Route('fe.home') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="{{ Route('fe.shop.index') }}">Shop</a>
                        <span>{{ auth()->user()->name }} Wishlist</span>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="products-cart">
                                @if ($wishlistItems)
                                    @foreach ($wishlistItems as $item)
                                        <tr class="pr-cart-item" data-index="{{ $item->product->id }}">
                                            <td class="cart-pic first-row"><a
                                                    href="{{ Route('product.details', $item->product->slug) }}"><img
                                                        src="{{ asset('images/' . $item->product->oldestImage->url) }}"
                                                        alt="{{ $item->product->name }}"></a></td>
                                            <td class="cart-title first-row">
                                                <h5>{{ $item->product->name }}</h5>
                                            </td>
                                            <td class="close-td first-row"><a
                                                    href="{{ Route('removeWishlist', $item->product->id) }}"><i
                                                        class="ti-close"></i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6"> {{ $errors }} </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row order-summary">
                        <div class="col-lg-4">
                            <div class="cart-buttons">
                                <a href="{{ Route('fe.shop.index') }}" class="primary-btn up-cart">Click me to shop</a>
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
