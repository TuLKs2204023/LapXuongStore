@extends('fe.layout.layout')

@section('fetitle', '- Shop')

@section('myCss')
    <style>
        .product-item .fa-heart {
            color: var(--red-dark-tu);
            -webkit-text-stroke-width: 2px;
            -webkit-text-stroke-color: var(--red-dark-tu);
        }

        .product-item .fa-heart-o {
            color: #ffffff;
            -webkit-text-stroke-width: 2px;
            -webkit-text-stroke-color: var(--red-dark-tu);
        }
    </style>
@endsection

@section('breader')
    <!-- BREADCUMB SECTION BEGIN-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ Route('fe.home') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="{{ Route('fe.shop.index') }}">Shop</a>
                        {{-- <span>{{ ($cate->cate_group->name ?? '') . ($cate->name ?? 'All') }}</span> --}}
                        <span>
                            @if (isset($cate->cate_group->name))
                                <span class="breader-cateGroup-id"
                                    data-value="{{ $cate->cate_group->id }}">{{ $cate->cate_group->name }}</span>:
                            @endif
                            @if (isset($cate->name))
                                <span class="breader-cate-id" data-value="{{ $cate->id }}">
                                    {{ $cate->name }}</span>
                            @else
                                {{ 'All' }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCUMB SECTION END-->
@endsection

@section('content')
    <!-- PRODUCT-SHOP SECTION BEGIN-->
    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                {{-- <div class="col-lg-3 col-sm-8 col-md-6 order-2 order-lg-1 produts-sidebar-filter"> --}}
                <div class="col-lg-3 order-2 order-lg-1 produts-sidebar-filter">
                    <!-- Price Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">Price</h4>
                        <div class="filter-range-wrap">
                            <div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minamount" class="price-min" readonly>
                                    <div class="range-slider-divider"></div>
                                    <input type="text" id="maxamount" class="price-max" readonly>
                                </div>
                            </div>
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="0" data-max="100000000">
                                <div class="ui-slider ui-corner-all ui-widget-header">
                                    <span tabindex="0" class="ui-corner-all ui-slider-handle ui-state-default"></span>
                                    <span tabindex="0" class="ui-corner-all ui-slider-handle ui-state-default"></span>
                                </div>
                            </div>
                        </div>
                        {{-- <a href="#" class="filter-btn">Filter</a> --}}
                    </div> <!-- // Price Filter -->

                    <!-- Usage Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">Usage</h4>
                        <div class="fw-check filter-demand">
                            @foreach ($cateGroups->find(10)->cates()->where('showOnSearch', '>', 0)->get()->sortBy('name') as $cate)
                                <div class="bc-item">
                                    <label for="demand-{{ $cate->cateable->id }}">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="demand-{{ $cate->cateable->id }}"
                                            data-value="demand-{{ $cate->cateable->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // Usage Filter -->

                    <!-- Manufacture Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">Manufacture</h4>
                        <div class="fw-check filter-manufacture">
                            @foreach ($cateGroups->find(1)->cates()->where('showOnSearch', '>', 0)->get()->sortBy('name') as $cate)
                                <div class="bc-item">
                                    <label for="manufacture-{{ $cate->cateable->id }}">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="manufacture-{{ $cate->cateable->id }}"
                                            data-value="manufacture-{{ $cate->cateable->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // Manufacture Filter -->

                    <!-- Series Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">Series</h4>
                        <div class="fw-check filter-series">
                            @foreach ($cateGroups->find(2)->cates()->where('showOnSearch', '>', 0)->get()->sortBy('name') as $cate)
                                <div class="bc-item">
                                    <label for="series-{{ $cate->cateable->id }}">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="series-{{ $cate->cateable->id }}"
                                            data-value="series-{{ $cate->cateable->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // Manufacture Filter -->

                    <!-- CPU Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">CPU</h4>
                        <div class="fw-check filter-cpu">
                            @foreach ($cateGroups->find(3)->cates()->where('showOnSearch', '>', 0)->get()->sortBy('name') as $cate)
                                <div class="bc-item">
                                    <label for="cpu-{{ $cate->cateable->id }}">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="cpu-{{ $cate->cateable->id }}"
                                            data-value="cpu-{{ $cate->cateable->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // CPU Filter -->

                    <!-- GPU Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">GPU</h4>
                        <div class="fw-check filter-gpu">
                            @foreach ($cateGroups->find(4)->cates()->where('showOnSearch', '>', 0)->get()->sortBy('name') as $cate)
                                <div class="bc-item">
                                    <label for="gpu-{{ $cate->cateable->id }}">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="gpu-{{ $cate->cateable->id }}"
                                            data-value="gpu-{{ $cate->cateable->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // GPU Filter -->

                    <!-- Color Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">Color</h4>
                        <div class="fw-check filter-color">
                            @foreach ($cateGroups->find(9)->cates()->where('showOnSearch', '>', 0)->get()->sortBy('name') as $cate)
                                <div class="bc-item">
                                    <label for="color-{{ $cate->cateable->id }}">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="color-{{ $cate->cateable->id }}"
                                            data-value="color-{{ $cate->cateable->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // Color Filter -->

                    <!-- RAM Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">RAM</h4>
                        <div class="fw-check filter-ram">
                            @foreach ($cateGroups->find(5)->cates()->where('showOnSearch', '>', 0)->get()->sortBy(function ($query) {
                return $query->cateable->value;
            }) as $cate)
                                @if ($cate->cateable->value === null)
                                    @continue
                                @endif
                                <div class="bc-item">
                                    <label for="ram-{{ $cate->cateable->id }}">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="ram-{{ $cate->cateable->id }}"
                                            data-value="ram-{{ $cate->cateable->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // RAM Filter -->

                    <!-- RAM Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">Screen Size</h4>
                        <div class="fw-check filter-screen">
                            @foreach ($cateGroups->find(6)->cates()->where('showOnSearch', '>', 0)->get()->sortBy(function ($query) {
                return $query->cateable->value;
            }) as $cate)
                                @if ($cate->cateable->value === null)
                                    @continue
                                @endif
                                <div class="bc-item">
                                    <label for="screen-{{ $cate->cateable->id }}">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="screen-{{ $cate->cateable->id }}"
                                            data-value="screen-{{ $cate->cateable->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // RAM Filter -->

                    <!-- Resolution Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">Resolution</h4>
                        <div class="fw-check filter-resolution">
                            @foreach ($cateGroups->find(11)->cates()->where('showOnSearch', '>', 0)->get()->sortBy(function ($query) {
                return $query->cateable->value;
            }) as $cate)
                                <div class="bc-item">
                                    <label for="resolution-{{ $cate->cateable->id }}">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="resolution-{{ $cate->cateable->id }}"
                                            data-value="resolution-{{ $cate->cateable->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // Resolution Filter -->

                    <!-- HDD Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">HDD</h4>
                        <div class="fw-check filter-hdd">
                            @foreach ($cateGroups->find(7)->cates()->where('showOnSearch', '>', 0)->get()->sortBy(function ($query) {
                return $query->cateable->value;
            }) as $cate)
                                @if ($cate->cateable->value === null)
                                    @continue
                                @endif
                                <div class="bc-item">
                                    <label for="hdd-{{ $cate->cateable->id }}">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="hdd-{{ $cate->cateable->id }}"
                                            data-value="hdd-{{ $cate->cateable->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // HDD Filter -->

                    <!-- SSD Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">SSD</h4>
                        <div class="fw-check filter-ssd">
                            @foreach ($cateGroups->find(8)->cates()->where('showOnSearch', '>', 0)->get()->sortBy(function ($query) {
                return $query->cateable->value;
            }) as $cate)
                                @if ($cate->cateable->value === null)
                                    @continue
                                @endif
                                <div class="bc-item">
                                    <label for="ssd-{{ $cate->cateable->id }}">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="ssd-{{ $cate->cateable->id }}"
                                            data-value="ssd-{{ $cate->cateable->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // SSD Filter -->

                </div>

                <!-- Main Content -->
                <div class="col-lg-9 order-1 order-lg-2">
                    <!-- Main content Header -->
                    <div class="product-show-option">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <div class="select-option">
                                    <select class="sorting">
                                        <option value="">Sorting by: </option>
                                        <option value="1">Name (A &rarr; Z)</option>
                                        <option value="2">Name (Z &rarr; A)</option>
                                        <option value="3">Price (High &rarr; Low)</option>
                                        <option value="4">Price (Low &rarr; High)</option>
                                    </select>
                                    <select class="p-show">
                                        <option value="0">Show: </option>
                                        <option value="12">12 items</option>
                                        <option value="16">16 items</option>
                                        <option value="20">20 items</option>
                                        <option value="24">24 items</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-lg-5 col-md-5 text-right">
                                <p>Show 01- 09 Of {{ $products->total() }} Product</p>
                            </div> --}}
                        </div>
                    </div> <!-- // Main content Header -->

                    <div class="product-search">
                        @include('fe.home.shopSearch')
                    </div>
                </div> <!-- // Main Content -->
            </div>
        </div>
    </section>
    <!-- PRODUCT-SHOP SECTION END-->
@endsection

@section('myJs')
    <!-- Start TuJs -->
    <script src="{{ asset('/js/TuJs/wishList.js') }}"></script>
    <!-- End TuJs -->

    <script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>

    <!-- KienJs -->
    <script src="{{ asset('/js/KienJs/searchProduct.js') }}"></script>
    <script>
        /*--- Range Slider --- */
        jQuery(document).ready(function($) {
            const rangeSlider = $(".price-range"),
                minamount = $("#minamount"),
                maxamount = $("#maxamount"),
                minPrice = rangeSlider.data("min"),
                maxPrice = rangeSlider.data("max");

            const wishList = new WishListHandler({
                url: '{{ Route('updateWishlist') }}',
                token: '{{ csrf_token() }}',
                loginUrl: '{{ Route('login') }}',
            });
            const productSearch = new SearchHandler({
                price: {
                    priceMin: minPrice,
                    priceMax: maxPrice,
                },
                paginateConfigs: {},
                selectors: {},
                wishList,
            });



            productSearch.initSearch();

            rangeSlider.slider({
                range: true,
                min: minPrice,
                max: maxPrice,
                step: 500000,
                values: [minPrice, maxPrice],
                start: function(event, ui) {
                    event.stopPropagation();
                },
                slide: function(event, ui) {
                    minamount.val(new Intl.NumberFormat("vi-VN").format(ui.values[0]) + " đ");
                    maxamount.val(new Intl.NumberFormat("vi-VN").format(ui.values[1]) + " đ");

                },
                stop: function(event, ui) {
                    productSearch.updatePrice(ui.values[0], ui.values[1]);
                }
            });
            minamount.val(new Intl.NumberFormat("vi-VN").format(rangeSlider.slider("values", 0)) + " đ");
            maxamount.val(new Intl.NumberFormat("vi-VN").format(rangeSlider.slider("values", 1)) + " đ");
        });
    </script><!-- End KienJs -->
@endsection
