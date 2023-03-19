<li class="cart-icon">
    <a href="{{ Route('viewCart') }}">
        <div>Your Cart</div>
        <i class="icon_bag_alt"></i>
        <span class="index">{{ $headerCart['qty'] }}</span>
    </a>
    <div class="cart-hover shadowed">
        <div class="select-items">
            <ul class="cart-header-list">
                @if (session('cart'))
                    @foreach (session('cart') as $item)
                        <li data-index={{ $item->product->id }} class="cart-section">
                            <div class="product-selected-left">
                                <div class="si-pic">
                                    <img src="{{ isset($item->product->oldestImage->url) ? asset('images/' . $item->product->oldestImage->url) : '' }}"
                                        alt="{{ $item->product->name }}">
                                </div>
                            </div>
                            <div class="product-selected-right">
                                <div class="si-text">
                                    <div class="product-selected">{{ $item->product->shortName }}</div>
                                </div>
                                <div class="si-price-qty">
                                    <span class="product-selected-price">
                                        {{ number_format($item->product->fakePrice(), 0, ',', '.') }} VND
                                    </span>
                                    <span class="product-selected-qtyX">
                                        x&nbsp;
                                        <span
                                            class="product-selected-qty">{{ number_format($item->quantity, 0, ',', '.') }}</span>
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li>CART IS EMPTY</li>
                @endif
            </ul>
        </div>
        <div class="select-button">
            <a href="{{ Route('viewCart') }}" class="site-btn-alt view-card">VIEW CART</a>
            <a href="{{ Route('checkout') }}" class="site-btn-main checkout-btn">CHECK
                OUT</a>
        </div>
    </div>
</li>
