@extends('fe.layout.layout')

@section('fetitle', '- Home')

@section('myCss')
    <style>
        .col-lg-4 .single-banner img {
            max-height: 562px;

        }

        .col-lg-4 {
            padding-bottom: 10px !important;
        }

        .single-banner h4 {
            padding: 0% !important;
            background: none !important;

        }

        .single-banner .inner-text a {
            color: white;
        }

        .single-banner .inner-text a:hover {
            font-style: bold;
            transition: 0.2s;
            font-size: 150%;
        }

        .latest-blog {
            padding-top: 0;
        }

        .spad {
            padding-top: 0;
        }

        .pd-rating i {
            color: #fac451;
        }

        .product-item .pi-pic .sale {
            background-color: var(--violet);
        }
    </style>
@endsection

@section('content')
    <!-- BODY SECTION BEGIN-->
    <section class="hero-section">
        <div class="hero-items owl-carousel">
            <div class="single-hero-items set-bg" data-setbg="{{ asset('frontend/img/22.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span style="color: aliceblue">Laptop Gaming</span>
                            <h1 style="color: aliceblue">Valentine</h1>
                            <p style="color: aliceblue">Sản phẩm được trưng bày và bán trực tiếp tại showroom LapXuongStore
                                (Phong Vũ) 2A
                                Nguyễn Oanh, Phường 7, Gò Vấp, Thành phố Hồ Chí Minh</p>
                            <a href="{{ Route('fe.shop.index') }}" class="primary-btn">Shop now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div>
                </div>
            </div>
            <div class="single-hero-items set-bg" data-setbg="{{ asset('frontend/img/23.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span style="color: aliceblue">Laptop Gaming</span>
                            <h1 style="color: aliceblue">Black friday</h1>
                            <p style="color: aliceblue">Sản phẩm được trưng bày và bán trực tiếp tại showroom LapXuongStore
                                (Phong Vũ) 2A
                                Nguyễn Oanh, Phường 7, Gò Vấp, Thành phố Hồ Chí Minh</p>
                            <a href="{{ Route('fe.shop.index') }}" class="primary-btn">Shop now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div>
                </div>
            </div>
            <div class="single-hero-items set-bg" data-setbg="{{ asset('frontend/img/24.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span>Laptop Gaming</span>
                            <h1 style="color: aliceblue">Black friday</h1>
                            <p style="color: aliceblue">Sản phẩm được trưng bày và bán trực tiếp tại showroom LapXuongStore
                                (Phong Vũ) 2A
                                Nguyễn Oanh, Phường 7, Gò Vấp, Thành phố Hồ Chí Minh</p>
                            <a href="{{ Route('fe.shop.index') }}" class="primary-btn">Shop now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Body SECTION END-->
    <!-- ---------------------------------------------------------------------------------0------------ -->

    <!-- Banner SECTION Begin-->
    <section class="banner-section sqad">
        <div class="container-fluid">
            <div class="row">
                @foreach ($demands as $item)
                    <div class="col-lg-4">
                        <div class="single-banner">
                            <img src="{{ isset($item->image) ? asset('frontend/img/' . $item->image) : '' }}"
                                alt="{{ $item->name }}">
                            <div class="inner-text">
                                <h4><a href="{{ Route('fe.shop.cate', $item->slug) }}">{{ $item->name }}</a></h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Banner SECTION end-->

    <!-- ----------------------------------------------------------------------------------------------- -->

    <!-- Special BAnner office BEGIN-->
    <section class="office-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="{{ asset('frontend/img/products/02.jpg') }}">
                        <h2>Office</h2>
                        <a href="{{ Route('fe.shop.cate', 'office') }}">Discover More</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <div class="filter-control">
                    </div>
                    <div class="product-slider owl-carousel">
                        @foreach ($officeProducts as $item)
                            <div class="product-item">
                                <div class="pi-pic">
                                    <img src="{{ isset($item->oldestImage->url) ? asset('images/' . $item->oldestImage->url) : '' }}"
                                        alt="{{ $item->name }}">
                                    @if ($item->latestDiscount() > 0)
                                        <div class="sale">Sale {{ $item->latestDiscount() * 100 }}%</div>
                                    @endif
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{ $item->manufacture->name }}</div>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Special banner end-->

    <!-- ----------------------------------------------------------------------------------------------- -->

    <!-- DEAL OF WEEK SECTION BEGIN-->
    <section class="deal-of-week set-bg spad" data-setbg="{{ asset('frontend/img/time1-bg.jpg') }}">
        <div class="container">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h2 style="color: aliceblue">Deal Of The Week</h2>
                    <p style="color: aliceblue">Nhấn theo dõi để có thông tin khuyến mãi mới nhất</p>
                    <div class="product-price">
                        $400.00
                        <span style="color: aliceblue">/ MSI Katana /</span>
                    </div>
                </div>
                <div class="countdown-timer" id="countdown">
                    <div class="cd-item">
                        <span>12</span>
                        <p>Days</p>
                    </div>
                    <div class="cd-item">
                        <span>11</span>
                        <p>Hrs</p>
                    </div>
                    <div class="cd-item">
                        <span>40</span>
                        <p>Mins</p>
                    </div>
                    <div class="cd-item">
                        <span>50</span>
                        <p>Secs</p>
                    </div>
                </div>
                <a href="#" class="primary-btn">Shop Now</a>
            </div>
        </div>
    </section>
    <!-- DEAL OF WEEK banner end-->

    <!-- ----------------------------------------------------------------------------------------------- -->
    <!-- Special BAnner Gaming BEGIN-->
    <section class="gaming-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 ">
                    <div class="filter-control">
                    </div>
                    <div class="product-slider owl-carousel">
                        @foreach ($gamingProducts as $item)
                            <div class="product-item">
                                <div class="pi-pic">
                                    <img src="{{ isset($item->oldestImage->url) ? asset('images/' . $item->oldestImage->url) : '' }}"
                                        alt="{{ $item->name }}">
                                    @if ($item->latestDiscount() > 0)
                                        <div class="sale">Sale {{ $item->latestDiscount() * 100 }}%</div>
                                    @endif
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{ $item->manufacture->name }}</div>
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
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="product-large set-bg" data-setbg="{{ asset('frontend/img/products/03-1.jpg') }}">
                        <h2>Gaming</h2>
                        <a href="{{ Route('fe.shop.cate', 'gaming') }}">Discover More</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Special banner end-->

    <!-- ----------------------------------------------------------------------------------------------- -->

    <!-- Top RateSECTION BEGIN-->
    <div class="latest-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Top of ratings</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-slider owl-carousel">
                        @foreach ($productsHighRate as $item)
                            <div class="product-item">
                                <div class="pi-pic">
                                    <img src="{{ isset($item->oldestImage->url) ? asset('images/' . $item->oldestImage->url) : '' }}"
                                        alt="{{ $item->name }}">
                                    @if ($item->latestDiscount() > 0)
                                        <div class="sale">Sale {{ $item->latestDiscount() * 100 }}%</div>
                                    @endif
                                </div>
                                <div class="pi-text">
                                    <div class="pd-rating">
                                        @if ($item->countRates() > 0)
                                            @for ($i = 0; $i < $item->avgRates(); $i++)
                                                <i class="fa fa-star"></i>
                                            @endfor
                                            @for ($i = 0; $i < 5 - $item->avgRates(); $i++)
                                                <i class="fa fa-star-o"></i>
                                            @endfor
                                        @endif
                                    </div>
                                    <div class="catagory-name">{{ $item->manufacture->name }}</div>
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
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="benefit-items">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="{{ asset('frontend/img/icon-1.png') }}" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>FREE SHIP</h6>
                                <p>For all orders online bought</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="{{ asset('frontend/img/icon-2.png') }}" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>DELIVERY ON TIME</h6>
                                <p>If goods have problem</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="{{ asset('frontend/img/icon-1.png') }}" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>SECURE PAYMENT</h6>
                                <p>100% secure payment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
    <!-- Top Rate SECTION END-->
@endsection
