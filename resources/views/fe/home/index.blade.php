@extends('fe.layout.layout')

@section('fetitle', '- Home')

@section('myCss')
    <style>
        .col-lg-4 .single-banner img {
            max-height: 562px;
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
                            <p style="color: aliceblue">Sản phẩm được trưng bày và bán trực tiếp tại showroom GEARVN Hoàng
                                Hoa Thám. (78 - 80 - 82
                                Hoàng Hoa Thám, P.12, Q.Tân Bình, TP.HCM)</p>
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
                            <span>Laptop Gaming</span>
                            <h1 style="color: aliceblue">Black friday</h1>
                            <p style="color: aliceblue">Sản phẩm được trưng bày và bán trực tiếp tại showroom GEARVN Hoàng
                                Hoa Thám. (78 - 80 - 82
                                Hoàng Hoa Thám, P.12, Q.Tân Bình, TP.HCM)</p>
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
                            <p style="color: aliceblue">Sản phẩm được trưng bày và bán trực tiếp tại showroom GEARVN Hoàng
                                Hoa Thám. (78 - 80 - 82
                                Hoàng Hoa Thám, P.12, Q.Tân Bình, TP.HCM)</p>
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
                        <a href="#">Discover More</a>
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
                                    <div class="sale">Sale</div>
                                    <div class="icon">
                                        <i class="icon_heart_alt"></i>
                                    </div>
                                    <ul>
                                        <li class="w-icon active"><a href=""><i class="icon_bag_alt"></i></a></li>
                                        <li class="quick-view"><a href="{{ Route('product.details', $item->slug) }}">+ Quick View</a></li>
                                        <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{ $item->manufacture->name }}</div>
                                    <a href="">
                                        <h5>{{ $item->name }}</h5>
                                    </a>
                                    <div class="product-price">
                                        {{ number_format($item->salePrice(), 0, ',', '.') . ' VND' }}
                                        <span>{{ number_format($item->fakePrice(), 0, ',', '.') . ' VND' }}</span>
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
                    <h2>Deal Of The Week</h2>
                    <p>Nhấn theo dõi để có thông tin khuyến mãi mới nhất</p>
                    <div class="product-price">
                        $400.00
                        <span>/ MSI Katana /</span>
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
                                    <img src="{{ asset('images/' . $item->oldestImage->url) }}" alt="{{ $item->name }}">
                                    <div class="sale">Sale</div>
                                    <div class="icon">
                                        <i class="icon_heart_alt"></i>
                                    </div>
                                    <ul>
                                        <li class="w-icon active"><a href=""><i class="icon_bag_alt"></i></a></li>
                                        <li class="quick-view"><a href="product.html">+ Quick View</a></li>
                                        <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{ $item->manufacture->name }}</div>
                                    <a href="">
                                        <h5>{{ $item->name }}</h5>
                                    </a>
                                    <div class="product-price">
                                        {{ number_format($item->salePrice(), 0, ',', '.') . ' VND' }}
                                        <span>{{ number_format($item->fakePrice(), 0, ',', '.') . ' VND' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="product-large set-bg" data-setbg="{{ asset('frontend/img/products/03-1.jpg') }}">
                        <h2>Gaming</h2>
                        <a href="#">Discover More</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Special banner end-->

    <!-- ----------------------------------------------------------------------------------------------- -->

    <!-- INSTAGRAM SECTION BEGIN-->
    <div class="instagram-photo">
        <div class="insta-item set-bg" data-setbg="{{ asset('frontend/img/a/a1.jpg') }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">PC_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('frontend/img/a/a6.jpg') }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">PC_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('frontend/img/a/a3.jpg') }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">PC_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('frontend/img/a/a4.jpg') }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">PC_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('frontend/img/a/a5.jpg') }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">PC_Collection</a></h5>
            </div>
        </div>
    </div>

    <div class="latest-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>From the blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single-latest-blog">
                        <img src="{{ asset('frontend/img/b01.png') }}" alt="">
                        <div class="latest-text">
                            <div class="tag-list">
                                <div class="tag-item">
                                    <i class="fa fa-calendar-o"></i>
                                    February 6,2023
                                </div>
                                <div class="tag-item">
                                    <i class="fa fa-comment-o"></i>
                                    5
                                </div>
                            </div>
                            <a href="">
                                <h4>The Best sell of the years</h4>
                            </a>
                            <p>
                                If you are a gamer with the desire to own a laptop that
                                looks really gaming, muscular and powerful, then this Asus TUF
                                Gaming HN188W is a typical name worth referring to.</p>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-latest-blog">
                        <img src="{{ asset('frontend/img/b2.png') }}" alt="">
                        <div class="latest-text">
                            <div class="tag-list">
                                <div class="tag-item">
                                    <i class="fa fa-calendar-o"></i>
                                    February 6,2023
                                </div>
                                <div class="tag-item">
                                    <i class="fa fa-comment-o"></i>
                                    5
                                </div>
                            </div>
                            <a href="">
                                <h4>5 laptops for students</h4>
                            </a>
                            <p>
                                If you are a follower of eSport games with the desire to have an
                                "eye-catching and pleasing" experience,
                                you cannot ignore the name Nitro 5 Gaming AN515-45-R6EV from Acer.
                            </p>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-latest-blog">
                        <img src="{{ asset('frontend/img/b3.png') }}" alt="">
                        <div class="latest-text">
                            <div class="tag-list">
                                <div class="tag-item">
                                    <i class="fa fa-calendar-o"></i>
                                    February 6,2023
                                </div>
                                <div class="tag-item">
                                    <i class="fa fa-comment-o"></i>
                                    5
                                </div>
                            </div>
                            <a href="">
                                <h4>Laptops for good office people</h4>
                            </a>
                            <p>
                                Laptop is a companion with office people to support quick office tasks. So don't hesitate,
                                let's immediately refer to the Top 10 good office laptops.</p>

                        </div>
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
                                <p>For all oder over 1000.00$</p>
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
    <!-- INSTAGRAM SECTION END-->
@endsection
