@extends('fe.layout.layout')

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
                                {{ $cate->cate_group->name . ': ' }}
                            @endif
                            @if (isset($cate->name))
                                {{ $cate->name }}
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
                <div class="col-lg-3 col-sm-8 col-md-6 order-2 order-lg-1 produts-sidebar-filter">
                    <!-- Price Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">Price</h4>
                        <div class="filter-range-wrap">
                            <div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minamount">
                                    <input type="text" id="maxamount">
                                </div>
                            </div>
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="33" data-max="98">
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
                        <ul class="filter-catagories">
                            <li><a href="#">Office</a></li>
                            <li><a href="#">Gaming</a></li>
                            <li><a href="#">Build</a></li>
                        </ul>
                    </div> <!-- // Usage Filter -->

                    <!-- Manufacture Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">Manufacture</h4>
                        <div class="fw-brand-check">
                            @foreach ($cateGroups->find(1)->cates as $cate)
                                <div class="bc-item">
                                    <label for="bc-calvin">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="bc-calvin">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // Manufacture Filter -->

                    <!-- CPU Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">CPU</h4>
                        <div class="fw-brand-check">
                            @foreach ($cateGroups->find(3)->cates as $cate)
                                <div class="bc-item">
                                    <label for="bc-calvin">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="bc-calvin">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // CPU Filter -->

                    <!-- RAM Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">RAM</h4>
                        <div class="fw-brand-check">
                            @foreach ($cateGroups->find(5)->cates as $cate)
                                @if ($cate->cateable->value === null)
                                    @continue
                                @endif
                                <div class="bc-item">
                                    <label for="bc-calvin">
                                        {{ $cate->name }}
                                        <input type="checkbox" id="bc-calvin">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div> <!-- // RAM Filter -->

                    <!-- Screen Size Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">Size</h4>
                        <div class="fw-size-choose">
                            <div class="sc-item">
                                <input type="radio" id="s-size">
                                <label for="s-size">15.6"</label>
                            </div>
                            <div class="sc-item">
                                <input type="radio" id="m-size">
                                <label for="m-size">16"</label>
                            </div>
                            <div class="sc-item">
                                <input type="radio" id="l-size">
                                <label for="l-size">21"</label>
                            </div>
                            <div class="sc-item">
                                <input type="radio" id="xs-size">
                                <label for="xs-size">24"</label>
                            </div>
                        </div>
                    </div> <!-- // Screen Size Filter -->

                    <!-- Accessories Filter -->
                    <div class="filter-widget">
                        <h4 class="fw-title">LINH KIỆN</h4>
                        <div class="fw-color-choose">
                            <div class="cs-item">
                                <input type="radio" id="cs-black">
                                <label for="cs-black" class="cs-black">BÀN PHÍM</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-violet">
                                <label for="cs-violet" class="cs-violet">CHUỘT</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-yellow">
                                <label for="cs-yellow" class="cs-yellow">LOA</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-blue">
                                <label for="cs-blue" class="cs-blue">WEBCAM</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-red">
                                <label for="cs-red" class="cs-red">TAY CẦM</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-green">
                                <label for="cs-green" class="cs-green">APPLE</label>
                            </div>
                        </div>
                    </div> <!-- // Accessories Filter -->

                </div>

                <!-- Main Content -->
                <div class="col-lg-9 order-1 order-lg-2">
                    <!-- Main content Header -->
                    <div class="product-show-option">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <div class="select-option">
                                    <select class="sorting">
                                        <option value="">Default Sorting</option>
                                    </select>
                                    <select class="p-show">
                                        <option value="">Show:</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 text-right">
                                <p>Show 01- 09 Of 36 Product</p>
                            </div>
                        </div>
                    </div> <!-- // Main content Header -->

                    <!-- Main content Body -->
                    <div class="product-list">
                        <div class="row">
                            @if ($products)
                                @foreach ($products as $item)
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="product-item">
                                            <div class="pi-pic">
                                                <img src="{{ asset('images/' . $item->oldestImage->url) }}"
                                                    alt="{{ $item->name }}">
                                                <div class="sale pp-sale">Sale</div>
                                                <div class="icon">
                                                    <i class="icon_heart_alt"></i>
                                                </div>
                                                <ul>
                                                    <li class="w-icon active"><a href="{{ Route('addCart') }}"><i
                                                                class="icon_bag_alt"></i></a></li>
                                                    <li class="quick-view"><a
                                                            href="{{ Route('product.details', $item->slug) }}">+ Quick
                                                            View</a></li>
                                                    <li class="w-icon"><a href=""><i class="fa fa-random"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="pi-text">
                                                <div class="catagory-name">Coat</div>
                                                <a href="">
                                                    <h5>{{ $item->name }}</h5>
                                                </a>
                                                <div class="product-price">
                                                    {{ number_format($item->price, 0, ',', '.') . ' VND' }}
                                                    <span>discount price</span>
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
                        <i class="icon_loading"></i>
                        <a href="">Loading More</a>
                    </div> <!-- // Main content Footer -->

                </div> <!-- // Main Content -->
            </div>
        </div>
    </section>
    <!-- PRODUCT-SHOP SECTION END-->
@endsection
