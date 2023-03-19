@extends('fe.layout.layout')

@section('fetitle', '- Product')

@section('myCss')
    <style>
        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .fa-heart {
            color: red;
        }

        .comment-option.overflow-auto {
            max-height: 400px;
        }

        .personal-rating .btn-default,
        .personal-rating .btn-warning {
            transition: all 0.3s;
        }

        .personal-rating .btn-default:hover {
            color: #FAC451;
            border-color: white;
            background-color: white;
        }

        .personal-rating .btnrating.btn.btn-lg.btn-warning:focus,
        .personal-rating .btn-warning {
            color: #FAC451;
            border-color: white;
            background-color: white;
        }

        .personal-rating .btn-warning:hover,
        .personal-rating .btn-default {
            color: gray;
            border-color: white;
            background-color: white;
        }

        .customer-review-option h4 {
            margin-top: 20px;
        }

        .product-item .pi-pic .sale {
            background-color: var(--violet);
        }
    </style>
@endsection

@section('breader')
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ Route('fe.home') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="{{ Route('fe.shop.index') }}">Shop</a>
                        <span>Detail: {{ $product->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




@section('category')
    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                {{-- <div class="col-lg-3">
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
                </div> --}}
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-pic-zoom">
                                <img src="{{ isset($product->oldestImage->url) ? asset('images/' . $product->oldestImage->url) : '' }}"
                                    alt="" class="product-big-img">
                                <div class="zoom-icon">
                                    <i class="fa fa-search-plus"></i>
                                </div>
                            </div>
                            <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
                                    @if ($product->images->count() > 0)
                                        @foreach ($product->images as $image)
                                            <div class="pt" data-imgbigurl="{{ asset('images/' . $image->url) }}">
                                                <img src="{{ asset('images/' . $image->url) }}"
                                                    style="width: 80px; height: auto;" alt="{{ $product->name }}">
                                            </div>
                                            {{-- <img src="{{ asset('images/' . $image->url) }}" alt=""
                                                style="width: 80px; height: auto;"> --}}
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- -------------------------------------------------------------------------------Product Details---------------------------------------------------------------------------------------------------------------------------                         --}}
                        <div class="col-lg-6">
                            <div class="product-details" data-index="{{ $product->id }}">
                                <div class="pd-title">
                                    <span>{{ $product->series->name }}</span>
                                    <h3>{{ $product->name }}</h3>
                                    {{-- {{-- Đã sửa lại điều kiện hiện icon whishlist : only available for customer -- Dự}} --}}

                                    @auth
                                        @if (auth()->user()->role == 'Customer')
                                            @if ($product->findWishlist())
                                                <a href="#" class="heart-icon"><i class="fas fa-heart"></i></a>
                                            @else
                                                <a href="#" class="heart-icon"><i class="far fa-heart"></i></a>
                                            @endif
                                        @endif
                                    @endauth
                                    {{-- End fix --}}

                                </div>
                                <div class="pd-rating">
                                    @if ($product->countRates() > 0)
                                        @for ($i = 0; $i < $product->avgRates(); $i++)
                                            <i class="fa fa-star"></i>
                                        @endfor
                                        @for ($i = 0; $i < 5 - $product->avgRates(); $i++)
                                            <i class="fa fa-star-o"></i>
                                        @endfor
                                    @endif
                                </div>
                                <div class="pd-desc">
                                    <p>Manufacture : <a
                                            href="{{ Route('fe.shop.cate', $product->manufacture->slug) }}">{{ $product->manufacture->name }}</a>
                                    </p>
                                    @if (isset($product->description->warranty))
                                        <p>Genuine warranty : {{ $product->description->warranty }} months</p>
                                    @endif
                                    <h4>{{ number_format($product->fakePrice(), 0, ',', '.') . ' VND' }}
                                        @if ($product->latestDiscount() > 0)
                                            <span>{{ number_format($product->salePrice(), 0, ',', '.') . ' VND' }}</span>
                                        @endif
                                    </h4>
                                </div>

                                {{-- Đã fix điều kiện nút check out , chỉ available for guest and customer : Dự --}}
                                @if (!Auth::check())
                                    <div class="quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input name="product-quantity" type="text" value="1">
                                            </div>
                                            <a href="#" class="primary-btn site-btn-main pd-cart"
                                                data-id="{{ $product->id }}">Add
                                                To Cart</a>
                                        </div>
                                    </div>
                                @endif

                                @auth
                                    @if (auth()->user()->role == 'Customer')
                                        <div class="quantity">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input name="product-quantity" type="text" value="1">
                                                </div>
                                                <a href="#" class="primary-btn site-btn-main pd-cart"
                                                    data-id="{{ $product->id }}">Add
                                                    To Cart</a>
                                            </div>
                                        </div>
                                    @endif
                                @endauth
                                {{-- End check -- Dự}}


                                <ul class="pd-tags">
                                    <li><span>Categories</span>: Gaming, ASUS</li>
                                </ul>
                                <div class="pd-share">
                                    <div class="p-code">CODE: {{ $product->id }}</div>
                                    <div class="pd-social">
                                        <a href="#"><i class="ti-facebook"></i></a>
                                        <a href="#"><i class="ti-twitter-alt"></i></a>
                                        <a href="#"><i class="ti-linkedin"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- -------------------------------------------------------------------------------end Product Details---------------------------------------------------------------------------------------------------------------------------                         --}}

                            </div>
                            <div class="product-tab">
                                <div class="tab-item">
                                    <ul class="nav" role="tablist">
                                        <li><a class="active" href="#tab-1" data-toggle="tab"
                                                role="tab">DESCRIPTION</a>
                                        </li>
                                        <li><a href="#tab-2" data-toggle="tab" role="tab">SPECIFICATIONS</a></li>
                                        <li><a id="review-tab" href="#tab-3" data-toggle="tab" role="tab">Customer
                                                Review
                                                ({{ $product->countRates() }})</a></li>
                                    </ul>
                                </div>
                                <div class="tab-item-content">
                                    <div class="tab-content">
                                        <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                            <div class="product-content">
                                                <div class="row">
                                                    <div class="col-lg-10 b">
                                                        @if (isset($product->description->instruction))
                                                            <h5>Introduction</h5>
                                                            <p>{!! $product->description->instruction !!}</p>
                                                            <br>
                                                        @endif
                                                        @if (isset($product->description->feature))
                                                            <h5>Features</h5>
                                                            {!! $product->description->feature !!}
                                                            {{-- @foreach (preg_split('/\\n/', str_replace('\r', '', $product->description->feature)) as $subItm)
                                                        <p>{ !! $subItm !!}</p>
                                                    @endforeach --}}
                                                        @endif
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                            <div class="specification-table">
                                                <table>
                                                    <tr>
                                                        <td class="p-catagory">Customer Rating</td>
                                                        <td>
                                                            <div class="pd-rating">
                                                                @if ($product->countRates() > 0)
                                                                    @for ($i = 0; $i < $product->avgRates(); $i++)
                                                                        <i class="fa fa-star"></i>
                                                                    @endfor
                                                                    @for ($i = 0; $i < 5 - $product->avgRates(); $i++)
                                                                        <i class="fa fa-star-o"></i>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td class="p-catagory">Price</td>
                                                        <td>
                                                            <div class="p-price">
                                                                {{ number_format($product->salePrice(), 0, ',', '.') . ' VND' }}
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="p-catagory">Availability</td>
                                                        @if ($product->inStock() - $product->outStock() > 0)
                                                            <td>
                                                                <div class="p-stock" style="color: green">
                                                                    {{ $product->inStock() - $product->outStock() }} in
                                                                    Stock</div>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <div class="p-stock" style="color: red">Out of Stock</div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    @if (isset($product->description->weight))
                                                        <tr>
                                                            <td class="p-catagory">Weight</td>
                                                            <td>
                                                                <div class="p-weight">{{ $product->description->weight }}
                                                                    kg</div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td class="p-catagory">Display</td>
                                                        <td>
                                                            <div class="p-weight">{{ $product->screen->amount }} inch
                                                                ({{ $product->resolution->name }})
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @if (isset($product->description->webcam))
                                                        <tr>
                                                            <td class="p-catagory">Webcam</td>
                                                            <td>
                                                                <div class="p-weight">{{ $product->description->webcam }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <td class="p-catagory">Graphics</td>
                                                        <td>
                                                            <div class="p-weight">{{ $product->gpu->name }}</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-catagory">Processor</td>
                                                        <td>
                                                            <div class="p-weight">{{ $product->cpu->name }}</div>
                                                        </td>
                                                    </tr>

                                                    @if (isset($product->description->dimension))
                                                        <tr>
                                                            <td class="p-catagory">Dimensions</td>
                                                            <td>
                                                                <div class="p-weight">
                                                                    {{ $product->description->dimension }} cm
                                                                </div>
                                                                <div>(Height x Width x Depth)</div>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <td class="p-catagory">Color</td>
                                                        <td>
                                                            <div class="p-weight">{{ $product->color->name }}</div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- ---------------------------------Comment View------------------------------------------------ --}}
                                        <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                            <div class="customer-review-option">
                                                <h4 class="tu-comment">{{ $product->countRates() }} Comments</h4>
                                                <div class="comment-option overflow-auto">
                                                    @foreach ($ratings as $rating)
                                                        {{-- Ratings --}}
                                                        @include('fe.home.rating')
                                                        {{-- end Ratings --}}
                                                    @endforeach
                                                </div>
                                                {{-- ---------------------------------end Comment View------------------------------------------------ --}}

                                                {{-- ---------------------------------------------------Review Form--------------------------------------------------------------------------------- --}}
                                                {{-- fix điều kiện hiện khung review and rating : Dự --}}
                                                @if (Auth::check())
                                                    @auth
                                                        @if (auth()->user()->role == 'Customer')
                                                            <div class="leave-comment">
                                                                <h4>Leave A Comment</h4>
                                                                <div class="tu-send-review-message"></div>
                                                                <form class="comment-form">
                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $product->id }}">
                                                                    <div class="personal-rating">
                                                                        <div class="form-group" id="rating-ability-wrapper">
                                                                            <label class="control-label" for="rating">
                                                                                <span class="field-label-header">How do you
                                                                                    feel about
                                                                                    our
                                                                                    services and products?</span><br>
                                                                                <span class="field-label-info"></span>
                                                                                <input type="hidden" id="selected_rating"
                                                                                    name="selected_rating" value=""
                                                                                    required="required">
                                                                            </label>
                                                                            <h2 class="bold rating-header" style="">
                                                                                <span class="selected-rating">0</span><small> /
                                                                                    5</small>
                                                                            </h2>
                                                                            <button type="button"
                                                                                class="btnrating btn btn-default btn-lg"
                                                                                data-attr="1" id="rating-star-1">
                                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btnrating btn btn-default btn-lg"
                                                                                data-attr="2" id="rating-star-2">
                                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btnrating btn btn-default btn-lg"
                                                                                data-attr="3" id="rating-star-3">
                                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btnrating btn btn-default btn-lg"
                                                                                data-attr="4" id="rating-star-4">
                                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btnrating btn btn-default btn-lg"
                                                                                data-attr="5" id="rating-star-5">
                                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <input disabled placeholder="Name"
                                                                                value="{{ auth()->user()->name }}">
                                                                            <input type="hidden" type="text"
                                                                                name="name"
                                                                                value="{{ auth()->user()->name }}">
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <input disabled type="text"
                                                                                value="{{ auth()->user()->email }}">
                                                                            <input type="hidden" placeholder="Email"
                                                                                name="email"
                                                                                value="{{ auth()->user()->email }}">
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <textarea id="review" placeholder="Review" name="review" rows="8"></textarea>
                                                                            <a href="#"
                                                                                class="site-btn review-lapxuong-btn">Send
                                                                                Review</a>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    @endauth
                                                @else
                                                    <div class="leave-comment">
                                                        <h4>Please log-in to comment</h4>
                                                        <a href="{{ Route('login') }}"><button type="button"
                                                                style="background-color: var(--grey-dark);"
                                                                class="btn btn-secondary">Click
                                                                me to log-in</button></a>
                                                    </div>
                                                @endif

                                                {{-- ---------------------------------------------------end Review Form--------------------------------------------------------------------------------- --}}
                                            </div>
                                        </div>
                                        {{-- ==============================end of Comment View============================================================ --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection


@section('content')
    {{-- -------------------------------------------------------------------------------Relate Products---------------------------------------------------------------------------------------------------------------------------                         --}}

    <div class="related-products spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="filter-control">
                </div>
                <div class="product-slider owl-carousel">
                    @foreach ($product->relateProducts() as $item)
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
    {{-- -------------------------------------------------------------------------------end Relate Products---------------------------------------------------------------------------------------------------------------------------                         --}}

@endsection

@section('myJs')
    <!-- Start KienJs -->
    <script type="module">
        import {CartHandler} from '{{ asset('/js/KienJs/cart.js') }}';
        import { showSuccessToast, showErrorToast } from "{{ asset('/js/KienJs/toast.js') }}";
        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {
                const addCart = new CartHandler({
                    url: '{{ Route('addCart') }}',
                    token: '{{ csrf_token() }}',
                    isUpdate: false,
                    inputName: "product-quantity",
                    selectors: {
                        cartOrBtnSelector: ".pd-cart",
                        headerCartSelector: ".cart-icon",
                    }
                });
            }
        });
    </script><!-- End KienJs -->

    <script>
        jQuery(document).ready(function($) {
            //Tú wishlist
            const headerHeart = $(".heart-icon").get(0);
            const heart = $(".product-details");
            const childElement = $(heart).find(".fa-heart").first().get(0);
            const pId = $(heart).attr("data-index");
            $(childElement).on("click", function(e) {
                e.preventDefault();
                const redHeart = $(childElement).hasClass("fas");

                if (redHeart) {
                    $(childElement).removeClass("fas");
                    $(childElement).addClass("far");
                    url = "{{ Route('removeWishlist') }}";
                    type = "DELETE";
                } else {
                    $(childElement).addClass("fas");
                    $(childElement).removeClass("far");
                    url = "{{ Route('addWishlist') }}";
                    type = "POST";
                }
                $.ajax({
                    url: url,
                    type: type,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    data: {
                        id: pId,
                    },
                    success: function(response) {
                        $(headerHeart).find("span").html(response.totalWishlist);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            })
            //end Tú Wishlist

            //Send review
            const starWrap = $("#rating-ability-wrapper .btnrating");
            const cmtArea = $("#review").get(0);
            const sendReview = $(".site-btn.review-lapxuong-btn").get(0);
            const pdRating = $(".pd-rating");
            $(sendReview).on("click", function(e) {
                e.preventDefault();
                const formArray = $(".comment-form").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{ Route('admin.rating.store') }}",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    data: formArray,
                    success: function(response) {
                        // if (response.msg == "Comment add successfully") {
                        $(cmtArea).val("");
                        $(".selected-rating").html(0);
                        //set selected to be 0
                        $("#selected_rating").val(0);
                        // Move up to comment area
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#review-tab").offset().top
                        }, 100);
                        //remove filled stars
                        for (i = 1; i <= 5; i++) {
                            const hasFilled = $("#rating-star-" + i).hasClass(
                                "btn-warning");
                            if (hasFilled) {
                                $("#rating-star-" + i).removeClass("btn-warning");
                                $("#rating-star-" + i).addClass("btn-default");
                            }
                        }
                        //add new comment to view area
                        if (response.totalRate == 1) {
                            const test = $(".comment-option.overflow-auto").get(0);
                            $(test).html(response.view);
                        } else {
                            $(".comment-option.overflow-auto").children().first().before(
                                response
                                .view);
                        }
                        // const reviewItm = $(".comment-option.overflow-auto").children()
                        //     .first().get(0);
                        // const reviewDelBtn = $(reviewItm).find("#deletecomment").get(0);
                        // reviewDelBtn.onclick =
                        //     function(e) {
                        //         e.preventDefault();
                        //         tuDeleteComment(reviewItm);
                        //     };
                        $("#review-tab").html("Customer Review " +
                            "(" + response.totalRate + ")");
                        $(".customer-review-option .tu-comment")
                            .html(response.totalRate + " Comments");
                        if ($(".tu-send-review-message").hasClass("alert-danger")) {
                            $(".tu-send-review-message").removeClass("alert-danger");
                            $(".tu-send-review-message").addClass(
                                "alert alert-success main-success");
                        } else {
                            $(".tu-send-review-message").addClass(
                                "alert alert-success main-success");
                        }
                        $(".tu-send-review-message").html(response.msg);

                        //add avg stars
                        pdRating.each(function(index, element) {
                            let filled = '',
                                empty = '';
                            const starFil = '<i class="fa fa-star"></i> ';
                            const starEmp = '<i class="fa fa-star-o"></i> ';
                            for (i = 0; i < response.avgRates; i++) {
                                filled += starFil;
                            }
                            for (i = 0; i < 5 - response.avgRates; i++) {
                                empty += starEmp;
                            }
                            $(element).html(filled + empty);
                        })
                        // } else {
                        //     $(starWrap).each(function(index, element) {
                        //         $([document.documentElement, document.body]).animate({
                        //             scrollTop: $("#review-tab").offset().top
                        //         }, 100);
                        //     })
                        //     $(".tu-send-review-message").addClass("alert alert-danger");
                        //     $(".tu-send-review-message").html(response.msg);
                        // }
                    }
                });
            })
            //end Send Review

            //Thầy Dự xóa Rating (Tú có fix lại)
            //hàm delete của tú
            function tuDeleteComment(element) {
                const rId = $(element).attr("data-index");
                console.log(rId)
                const pId = $(heart).attr("data-index");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4154f1',
                    cancelButtonColor: 'crimson',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ Route('admin.rating.destroy') }}",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            data: {
                                rId: rId,
                                pId: pId,
                            },
                            success: function(response) {
                                $(element).remove();
                                $("#review-tab").html("Customer Review " +
                                    "(" + response.totalRate + ")");
                                $(".customer-review-option .tu-comment")
                                    .html(response.totalRate + " Comments");
                            }
                        })
                        Swal.fire(
                            'Deleted!',
                            'This comment has been deleted.',
                            'success'
                        )
                    }
                })
            }
            //end hàm delete rồi nha
            const ratingItem = $(".co-item");
            ratingItem.each(function(index, element) {
                const deleteBtn = $(element).find("#deletecomment").get(0);
                $(deleteBtn).on("click", function(e) {
                    console.log(deleteBtn)
                    e.preventDefault();
                    tuDeleteComment(element);
                });
            })
            //end Thầy Dự

            //Rating Star
            $(".btnrating").on('click', (function(e) {

                const previous_value = $("#selected_rating").val();
                const selected_value = $(this).attr("data-attr");
                $("#selected_rating").val(selected_value);

                $(".selected-rating").empty();
                $(".selected-rating").html(selected_value);

                for (i = 1; i <= selected_value; ++i) {
                    $("#rating-star-" + i).toggleClass('btn-warning');
                    $("#rating-star-" + i).toggleClass('btn-default');
                }

                for (ix = 1; ix <= previous_value; ++ix) {
                    $("#rating-star-" + ix).toggleClass('btn-warning');
                    $("#rating-star-" + ix).toggleClass('btn-default');
                }
            }));
            //end Rating Star
        });
    </script>
@endsection
