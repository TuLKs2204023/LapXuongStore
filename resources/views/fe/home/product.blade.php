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
                <div class="col-lg-3 ">
                    <div class="filter-widget">
                        <h4 class="fw-title">Categories</h4>
                        <ul class="filter-catagories">
                            <li><a href="#">Office</a></li>
                            <li><a href="#">Gaming</a></li>
                            <li><a href="#">Build</a></li>
                        </ul>
                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">Brand</h4>
                        <div class="fw-brand-check">
                            <div class="bc-item">
                                <label for="bc-calvin">
                                    MSI
                                    <input type="checkbox" id="bc-calvin">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="bc-item">
                                <label for="bc-calvin">
                                    ASUS
                                    <input type="checkbox" id="bc-calvin">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="bc-item">
                                <label for="bc-calvin">
                                    APPLE
                                    <input type="checkbox" id="bc-calvin">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="bc-item">
                                <label for="bc-calvin">
                                    DELL
                                    <input type="checkbox" id="bc-calvin">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="bc-item">
                                <label for="bc-calvin">
                                    ANOTHER
                                    <input type="checkbox" id="bc-calvin">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
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
                        <a href="#" class="filter-btn">Filter</a>

                    </div>

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
                    </div>
                </div>
                <div class="col-lg-9">
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
                                    @if ($product->findWishlist())
                                        <a href="#" class="heart-icon"><i class="fas fa-heart"></i></a>
                                    @else
                                        <a href="#" class="heart-icon"><i class="far fa-heart"></i></a>
                                    @endif
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
                                <li><a class="active" href="#tab-1" data-toggle="tab" role="tab">DESCRIPTION</a>
                                </li>
                                <li><a href="#tab-2" data-toggle="tab" role="tab">SPECIFICATIONS</a></li>
                                <li><a id="review-tab" href="#tab-3" data-toggle="tab" role="tab">Customer Review
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
                                                            {{ $product->inStock() - $product->outStock() }} in Stock</div>
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
                                                        <div class="p-weight">{{ $product->description->weight }} kg</div>
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
                                                        <div class="p-weight">{{ $product->description->webcam }}</div>
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
                                                        <div class="p-weight">{{ $product->description->dimension }} cm
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
                                        @if (auth()->user())
                                            @auth
                                                <div class="leave-comment">
                                                    <h4>Leave A Comment</h4>
                                                    <!-- Message Section -->
                                                    @include('components.message')
                                                    <!-- / Message Section -->
                                                    <form class="comment-form">
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <div class="personal-rating">
                                                            <div class="form-group" id="rating-ability-wrapper">
                                                                <label class="control-label" for="rating">
                                                                    <span class="field-label-header">How do you feel about our
                                                                        services and products?</span><br>
                                                                    <span class="field-label-info"></span>
                                                                    <input type="hidden" id="selected_rating"
                                                                        name="selected_rating" value=""
                                                                        required="required">
                                                                </label>
                                                                <h2 class="bold rating-header" style="">
                                                                    <span class="selected-rating">0</span><small> / 5</small>
                                                                </h2>
                                                                <button type="button"
                                                                    class="btnrating btn btn-default btn-lg" data-attr="1"
                                                                    id="rating-star-1">
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btnrating btn btn-default btn-lg" data-attr="2"
                                                                    id="rating-star-2">
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btnrating btn btn-default btn-lg" data-attr="3"
                                                                    id="rating-star-3">
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btnrating btn btn-default btn-lg" data-attr="4"
                                                                    id="rating-star-4">
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btnrating btn btn-default btn-lg" data-attr="5"
                                                                    id="rating-star-5">
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <input disabled placeholder="Name"
                                                                    value="{{ auth()->user()->name }}">
                                                                <input type="hidden" type="text" name="name"
                                                                    value="{{ auth()->user()->name }}">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <input disabled type="text"
                                                                    value="{{ auth()->user()->email }}">
                                                                <input type="hidden" placeholder="Email" name="email"
                                                                    value="{{ auth()->user()->email }}">
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <textarea id="review" placeholder="Review" name="review" rows="8"></textarea>
                                                                <a href="#" class="site-btn review-lapxuong-btn">Send
                                                                    Review</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
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
                                <img src="{{ isset($item->oldestImage->url) ? asset('images/' . $item->oldestImage->url) :'' }}" alt="{{ $item->name }}">
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
                        $(cmtArea).val("");
                        $(".selected-rating").html(0);
                        $(starWrap).each(function(index, element) {
                            const hasFilled = $(element).hasClass("btn-warning");
                            $([document.documentElement, document.body]).animate({
                                scrollTop: $("#review-tab").offset().top
                            }, 100);
                            if (hasFilled) {
                                $(element).removeClass("btn-warning");
                                $(element).addClass("btn-default");
                            }
                        })
                        if(response.totalRate == 1){
                            const test = $(".comment-option.overflow-auto").get(0);
                            $(test).html(response.view);
                        }
                        else{
                            $(".comment-option.overflow-auto").children().first().before(response
                            .view);
                        }
                        const reviewDelBtn = $(".comment-option.overflow-auto").children()
                            .first().get(0);
                        reviewDelBtn.onclick =
                            function(e) {
                                e.preventDefault();
                                tuDeleteComment(reviewDelBtn);
                            };
                        $("#review-tab").html("Customer Review " +
                                    "(" + response.totalRate + ")");
                        $(".customer-review-option .tu-comment")
                                    .html(response.totalRate + " Comments");
                    }
                });
            })
            //end Send Review

            //Thầy Dự xóa Rating (Tú có fix lại)
            //hàm delete của tú
            function tuDeleteComment(element) {
                const rId = $("#deletecomment").attr("data-index");
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
                $(element).on("click", "#deletecomment", function(e) {
                    e.preventDefault();
                    tuDeleteComment(element);
                });
            })
            //end Thầy Dự

            //Rating Star
            $(".btnrating").on('click', (function(e) {

                var previous_value = $("#selected_rating").val();

                var selected_value = $(this).attr("data-attr");
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
