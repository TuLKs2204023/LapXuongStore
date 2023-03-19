<!-- Main content Header -->
<div class="displaying-products">
    {{ $products->withQueryString()->links('vendor.pagination.header') }}
</div> <!-- // Main content Header -->

<!-- Main content Body -->
<div class="product-list">
    <div class="row">
        @if (count($products) > 0)
            @foreach ($products as $item)
                <div class="col-lg-3 col-sm-6">
                    <div class="product-item" data-index="{{ $item->id }}">
                        <div class="pi-pic">
                            <a href="{{ Route('product.details', $item->slug) }}">
                                <img src="{{ isset($item->oldestImage->url) ? asset('images/' . $item->oldestImage->url) : '' }}"
                                    alt="{{ $item->name }}">
                            </a>

                            @if ($item->latestDiscount() > 0)
                                <div class="sale pp-sale">Sale {{ $item->latestDiscount() * 100 }}%
                                </div>
                            @endif
                            @auth
                                @if (auth()->user()->role == 'Customer')
                                <div class="icon product-list-icon">
                                    @if ($item->findWishlist())
                                        <i class="fas fa-heart"></i>
                                    @else
                                        <i class="fas fa-heart-o"></i>
                                    @endif
                                </div>
                                @endif
                            @endauth

                            {{-- <ul>
                                <li class="quick-view">
                                    <a href="{{ Route('product.details', $item->slug) }}">+ Quick
                                        View</a>
                                </li>
                            </ul> --}}
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">{{ $item->series->name }}</div>
                            <a href="{{ Route('product.details', $item->slug) }}">
                                <h6>{{ $item->name }}</h6>
                            </a>
                            <div class="product-price">
                                {{ number_format($item->fakePrice(), 0, ',', '.') . ' VND' }}
                                @if ($item->latestDiscount() > 0)
                                    <span>{{ number_format($item->salePrice(), 0, ',', '.') . ' VND' }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-lg-4 col-sm-6">No Product</div>
        @endif
    </div>
</div> <!-- // Main content Body -->

<!-- Main content Footer -->
<div class="loading-more">
    {{ $products->withQueryString()->links('vendor.pagination.footer') }}
</div> <!-- // Main content Footer -->
