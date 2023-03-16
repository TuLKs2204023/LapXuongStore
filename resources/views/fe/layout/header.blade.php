<header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="ht-left">
                <div class="mail-service">
                    <i class="fa fa-envelope"></i>
                    <a href="mailto:LapXuongShop@gmail.com"
                        style="
                    color: black;
                    text-decoration: none;
                    background-color: white;">LapXuongShop@gmail.com</a>
                </div>
                <div class="phone-service">
                    <i class="fa fa-phone"></i>
                    <a href="tel:03979-3979-3979"
                        style="
                    color: black;
                    text-decoration: none;
                    background-color: white;
                    ">03979-3979-3979</a>

                </div>
            </div>
            <div class="ht-right">
                @if (Route::has('login'))
                    @auth
                        @if (auth()->user()->role == 'Customer')
                            <a class="login-panel dd ddcommon borderRadius" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a href="{{ url('customer') }}" class="login-panel dd ddcommon borderRadius"
                                style="padding-top:10px;padding-bottom: 7px;" style="width:80px "
                                type="submit">{{ auth()->user()->name }}
                                <img src="{{ isset(auth()->user()->image)
                                    ? asset('images/' . auth()->user()->image)
                                    : 'https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/626fd8140423801.6241b91e24d9c.png' }}"
                                    alt="Profile Picture" class="rounded-circle"
                                    style="height: 40px ;width:40px; margin-left:20px; margin-right:10px ">
                            </a>
                        @endif
                        @if (auth()->user()->role !== 'Customer')
                            <a href="{{ url('admin') }}" class="login-panel" style="padding-top:10px;padding-bottom: 7px;">
                                Hello {{ auth()->user()->name }}
                                <img src="{{ isset(auth()->user()->image)
                                    ? asset('images/' . auth()->user()->image)
                                    : 'https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/626fd8140423801.6241b91e24d9c.png' }}"
                                    alt="Profile Picture" class="rounded-circle"
                                    style="height: 40px ;width:40px; margin-left:20px;">
                            </a>
                            <a href="{{ url('profile') }}" class="login-panel dd ddcommon borderRadius" style="width:90px "
                                type="submit">Setting</a>
                        @endif
                    @else
                        <a href="{{ Route('login') }}" class="login-panel"><i class="fa fa-user"></i> Login</a>
                    @endauth
                @endif

                <div class="lan-selector">
                    <select name="countries" id="countries" class="language_drop" style="width:150px">
                        <option value="yt" data-image="{{ asset('frontend/img/flag-1.jpg') }}"
                            data-imagecss="flag yt" data-title="English">ENG</option>
                        <option value="yu" data-image="{{ asset('frontend/img/flag-3.jpg') }}"
                            data-imagecss="flag yu" data-title="Vietnamese">VIE</option>
                    </select>
                </div>

                <div class="top-social">
                    <a href="#"><i class="ti-facebook"></i></a>
                    <a href="#"><i class="ti-twitter-alt"></i></a>
                    <a href="#"><i class="ti-linkedin"></i></a>
                    <a href="#"><i class="ti-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="inner-header">
            <div class="row">
                <div class="col-lg-1 col-md-1">
                    <div class="logo">
                        <a href="{{ Route('fe.home') }}">
                            <img src="{{ asset('images/asd-removebg-preview.png') }}" height="30" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <form action="{{ Route('fe.header.search') }}" method="GET">
                        <div class="advanced-search">
                            <button type="button" class="category-btn">All Categories</button>
                            <div class="input-group">
                                <input type="text" placeholder="Type something to search ... " name="headerSearch">
                                <button type="submit"><i class="ti-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-md-4 text-right">
                    <ul class="nav-right">
                        <li class="heart-icon">
                            <a href="{{ Route('wishlist') }}">
                                <i class="icon_heart_alt"></i>
                                @if (auth()->user())
                                    <span>{{ count(auth()->user()->wishlistItems) }}</span>
                                @else
                                    <span>0</span>
                                @endif

                            </a>
                        </li>
                        <li class="cart-icon">
                            <a href="{{ Route('viewCart') }}">
                                <i class="icon_bag_alt"></i>
                                <span class="index">{{ $headerCart['qty'] }}</span>
                            </a>
                            <div class="cart-hover shadowed">
                                <div class="select-items">
                                    <table>
                                        <tbody>
                                            @if (session('cart'))
                                                @foreach (session('cart') as $item)
                                                    <tr>
                                                        <td class="si-pic"><img
                                                                src="{{ asset('images/' . $item->product->oldestImage->url) }}"
                                                                alt=""></td>
                                                        <td class="si-text">
                                                            <div class="product-selected">
                                                                <p>{{ number_format($item->product->fakePrice(), 0, ',', '.') }}
                                                                </p>
                                                                <h6>{{ $item->product->name }}</h6>
                                                            </div>
                                                        </td>
                                                        <td class="si-close">
                                                            <i class="ti-close"></i>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" style="text-align: center">CART IS EMPTY</td>
                                                </tr>
                                            @endif


                                        </tbody>
                                    </table>
                                </div>
                                <div class="select-button">
                                    <a href="{{ Route('viewCart') }}" class="site-btn-alt view-card">VIEW CART</a>
                                    <a href="{{ Route('checkout') }}" class="site-btn-main checkout-btn">CHECK
                                        OUT</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-item">
        <div class="container">
            <div class="nav-categories">
                <div class="cate-btn">
                    <i class="ti-menu"></i>
                    <span>Categories</span>
                </div>
            </div>

            <nav class="nav-menu mobile-menu">
                <ul>
                    <li><a href="{{ Route('fe.home') }}">Home</a></li>
                    <li><a href="{{ Route('fe.shop.index') }}">Shop</a></li>
                    {{-- <li><a href="">Product</a>
                        <ul class="dropdown">
                            <li><a href="">Thương Hiệu</a></li>
                            <li><a href="">Giá Bán</a></li>
                            <li><a href="">Mục Đích</a></li>
                        </ul>
                    </li> --}}
                    <li><a href="{{ Route('aboutUs') }}">About Us</a></li>
                    <li><a href="{{ Route('fe.contact') }}">Contact Us</a></li>
                    {{-- <li><a href="">Pages</a>
                        <ul class="dropdown">
                            <li><a href="blog-detail.html">Blog Detail</a></li>
                            <li><a href="">Shopping Cart</a></li>
                            <li><a href="{{ Route('checkout') }}">Check Out</a></li>
                    <li><a href="faq.html">Faq</a></li>
                    <li><a href="{{ Route('register') }}">Register</a></li>
                    <li><a href="{{ Route('login') }}">Login</a></li>
                </ul>
                </li> --}}
                </ul>
            </nav>
        </div>
    </div>
    <div class="nav-fake-categories">
        <div class="cate-btn my-toggle"></div>
        <ul class="category-list my-toggle-content myScrollbar">
            @foreach ($cateGroups as $cateGroup)
                <li>
                    <div class="category-list-header">{{ $cateGroup->name }}</div>
                    <ul>
                        @foreach ($cateGroup->cates()->where('showOnNav', '>', 0)->get() as $cate)
                            <li><a href="{{ Route('fe.shop.cate', $cate->slug) }}">{{ $cate->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</header>
