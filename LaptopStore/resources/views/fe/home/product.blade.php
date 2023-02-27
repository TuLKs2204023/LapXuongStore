@extends('fe.layout.layout')


@section('breader')
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="index.html"><i class="fa fa-home"></i>Home</a>
                        <a href="shop.html">Shop</a>
                        <span>Detail</span>
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
                                <img src="{{ asset('/front/img/product-single/' . $product->productImages[0]->url) }}" alt="" class="product-big-img">
                                <div class="zoom-icon">
                                    <i class="fa fa-search-plus"></i>
                                </div>
                            </div>
                            <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
                                @foreach($product->productImages as $productImage)
                                            
                                        <div class="pt active" data-imgbigurl="{{ asset('/front/img/product-single/' . $productImage->url) }}">
                                        <img src="{{ asset('/front/img/product-single/' . $productImage->url) }}" alt=""
                                            >

                                        </div>
                                @endforeach
                                    
                                
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details">
                                <div class="pd-title">
                                    <span>{{$product->specification->tag}}</span>
                                    <h3>{{ $product->name }}</h3>
                                    <a href="#" class="heart-icon"><i class="icon_heart_alt"></i></a>
                                </div>
                                <div class="pd-rating">
                                @for($i=1;$i<=5;$i++)
                                    @if($i<=$product->avgRating)
                                    <i class="fa fa-star"></i>
                                    @else
                                    <i class="fa fa-star-o"></i>
                                    @endif
                                @endfor
                                <span>({{ count($product->productComments) }})</span>
                            </div>
                                <div class="pd-desc">
                                    <p>Thương hiệu : <a href="#">{{ $product->manufacture->name }}</a></p>
                                    <p>Bảo hành 24 tháng chính hãng.</p>
                                    @if($product->price!=null)
                                        <h4>${{$product->price}} <span>${{$product->price}}</span></h4>
                                    @else
                                        <h4>${{$product->price}} 
                                    @endif

                                </div>
                                <div class="quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input name="product-quantity" type="text"
                                                value="{{ session('cart')[$product->id]->quantity ?? 1 }}">
                                        </div>
                                        <a href="#" class="primary-btn pd-cart" data-id="{{ $product->id }}">Add
                                            To Cart</a>
                                    </div>
                                </div>
                                <ul class="pd-tags">
                                    <li><span>Categories</span>: {{ $product->manufacture->name }}</li>
                                    <li><span>TAGS</span>: {{$product->specification->tag}}</li>
                                </ul>
                                <div class="pd-share">
                                    <div class="p-code">fa506</div>
                                    <div class="pd-social">
                                        <a href=""><i class="ti-facebook"></i></a>
                                        <a href=""><i class="ti-twitter-alt"></i></a>
                                        <a href=""><i class="ti-linkedin"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-tab">
                        <div class="tab-item">
                            <ul class="nav" role="tablist">
                                <li><a class="active" href="#tab-1" data-toggle="tab" role="tab">DESCRIPTION</a>
                                </li>
                                <li><a href="#tab-2" data-toggle="tab" role="tab">SPECIFICATIONS</a></li>
                                <li><a href="#tab-3" data-toggle="tab" role="tab">Customer Review ({{ count($product->productComments) }})</a></li>
                            </ul>
                        </div>
                        <div class="tab-item-content">
                            <div class="tab-content">
                                <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                    <div class="product-content">
                                    {!! $product->description !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                    <div class="specification-table">
                                        <table>
                                            <tr>
                                                <td class="p-catagory">Customer Rating</td>
                                                <td>
                                            <div class="pd-rating">
                                                @for($i=1;$i<=5;$i++)
                                                @if($i<=$product->avgRating)
                                                <i class="fa fa-star"></i>
                                                @else
                                                <i class="fa fa-star-o"></i>
                                                @endif
                                                @endfor
                                                <span>({{ count($product->productComments) }})</span>
                                                </div>
                                        </td>

                                            </tr>
                                            <tr>
                                        <td class="p-catagory">Price</td>
                                        <td>
                                            <div class="p-price">
                                                ${{$product->specification->price}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-catagory">Add To Cart</td>
                                        <td>
                                            <div class="cart-add">+add to cart</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-catagory">Availability</td>
                                        <td>
                                            <div class="p-stock">{{$product->specification->availability}} in stock</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-catagory">Weight</td>
                                        <td>
                                            <div class="p-weight">{{$product->specification->weight}} kg</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-catagory">Display</td>
                                        <td>
                                            <div class="p-weight">{{$product->specification->display}}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-catagory">Webcam</td>
                                        <td>
                                            <div class="p-weight">{{ $product->specification->webcam }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-catagory">Graphics</td>
                                        <td>
                                            <div class="p-weight">{{$product->specification->graphics}}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-catagory">Processor</td>
                                        <td>
                                            <div class="p-weight">{{$product->specification->processor}}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-catagory">Dimension</td>
                                        <td>
                                            <div class="p-weight">{{$product->specification->dimension}}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-catagory">Color</td>
                                        <td>
                                            <div class="p-weight">{{$product->specification->color}}</div>
                                        </td>
                                    </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                <div class="customer-review-option">
                                    <h4>{{ count($product->productComments) }} Comments</h4>
                                    <div class="comment-option">
                                        @foreach($product->productComments as $productComment)
                                            <div class="co-item">
                                            <div class="avatar-pic">
                                            <img src="front/img/product-single/{{ $productComment->user->avatar ?? ''}}" alt="">
                                        </div>
                                        <div class="avatar-text">
                                            <div class="at-rating">
                                                @for($i=1;$i<=5;$i++)
                                                @if($i<=$productComment->rating)
                                                <i class="fa fa-star"></i>
                                                @else
                                                <i class="fa fa-star-o"></i>
                                                @endif
                                                @endfor
                                            </div>
                                            <h5>{{$productComment->name}} <span>{{date('M,d,Y', strtotime($productComment->create_at))}}</span></h5>
                                            <div class="at-reply">{{$productComment->messages}}</div>
                                        </div>
                                        
                                    </div>
                                    @endforeach
                                </div>
                                
                                <div class="leave-comment">
                                    <h4>Leave A Comment</h4>
                                    <form action="" method="post" class="comment-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <input type="hidden" name="user_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id ?? null }}">
                                       
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input type="text" placeholder="Name" name="name">
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" placeholder="Email" name="email">
                                            </div>
                                            <div class="col-lg-12">
                                                <textarea placeholder="Messages" name="messages"></textarea>
                                                <div class="personal-rating">
    
                                                <div class="personal-rating">
                                                    <h6>Your Rating</h6>
                                                    <div class="rate">
                                                        <input type="radio" id="star5" name="rating" value="5" />
                                                        <label for="star5" title="text">5 stars</label>
                                                        <input type="radio" id="star4" name="rating" value="4" />
                                                        <label for="star4" title="text">4 stars</label>
                                                        <input type="radio" id="star3" name="rating" value="3" />
                                                        <label for="star3" title="text">3 stars</label>
                                                        <input type="radio" id="star2" name="rating" value="2" />
                                                     <label for="star2" title="text">2 stars</label>
                                                        <input type="radio" id="star1" name="rating" value="1" />
                                                     <label for="star1" title="text">1 star</label>
                                                    </div>
                                                    </div>

                                </div>
                                <button type="submit" class="site-btn">Send message</button>
                                            </div>
                                        </div>
                                        
                                            </form>
                                        </div>
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
<div class="related-products spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Related Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($relatedProduct as $product)
                <div class="col-lg-3 col-sm-6">
                <div class="product-item">
                    <div class="pi-pic">
                        <img src="{{ asset('/front/img/products/' . $product->productImages[0]->url) }}" alt="">

                        @if($product->discount != null)
                        <div class="sale pp-sale">Sale</div>
                        @endif
                        <div class="icon">
                            <i class="icon_heart_alt"></i>
                        </div>
                        <ul>
                            <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                            <li class="quick-view"><a href="{{ Route('product', $product->id)}}">+ Quick View</a></li>
                            
                            <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
                        </ul>
                    </div>
                        <div class="pi-text">
                            <div class="catagory-name">{{$product->slug}}</div>
                                <a href="{{ Route('product', $product->id)}}">
                                <h5>{{$product->name}}</h5>
                                </a>
                            <div class="product-price">
                               @if($product->discount != null)
                                    ${{$product->discount}}
                                    <span>${{$product->price}}</span>
                                @else
                                    ${{$product->price}}
                                @endif
                            </div>
                            </div>
                </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection




<!-- @section('myJs')
    <script type="module">
    import {CartHandler} from '{{ asset('/js/KienJs/cart.js') }}';
    document.addEventListener("readystatechange", (e) => {
        if (e.target.readyState === "complete") {
            const addCart = new CartHandler({
                url: '{{ Route('addCart') }}',
                token: '{{ csrf_token() }}',
                isUpdate: false,
                cartOrBtnSelector: ".pd-cart",
                inputName: "product-quantity",
                headerCartSelector: ".cart-icon",
            });
        }
    });
</script>

@endsection -->
