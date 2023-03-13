<!-- Main content Body -->
<div class="product-list">
    <div class="row">
        @if (count($products) > 0)
            @foreach ($products as $item)
                <div class="col-lg-4 col-sm-6">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="{{ isset($item->oldestImage->url) ? asset('images/' . $item->oldestImage->url) : '' }}"
                                alt="{{ $item->name }}">
                            @if ($item->latestDiscount() > 0)
                                <div class="sale pp-sale">Sale {{ $item->latestDiscount() * 100 }}%
                                </div>
                            @endif
                            <div class="icon">
                                @if ($item->findWishlist())
                                    <a href="{{ Route('removeWishlist', $item->id) }}"><i class="fas fa-heart"></i></a>
                                @else
                                    <a href="{{ Route('addWishlist', $item->id) }}"><i class="far fa-heart"></i></a>
                                @endif
                            </div>
                            <ul>
                                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                <li class="quick-view">
                                    <a href="{{ Route('product.details', $item->slug) }}">+ Quick
                                        View</a>
                                </li>
                                <li class="w-icon"><a href=""><i class="fa fa-random"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">{{ $item->series->name }}</div>
                            <a href="{{ Route('product.details', $item->slug) }}">
                                <h5>{{ $item->name }}</h5>
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
    {{ $products->withQueryString()->links('vendor.pagination.custom') }}
</div> <!-- // Main content Footer -->
