<footer class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="footer-left">
                    <a href="{{ Route('fe.home') }}">
                        <div style="font-size: 150%; font-weight: 800">LapXuongStore</div>
                    </a>
                </div>
                <ul>
                    <li style="color: #b2b2b2">Cach Mang T8, District 3,Tan Binh</li>
                    <li style="color: #b2b2b2">Phone: 03979-3979-3979</li>
                    <li style="color: #b2b2b2">Email: LapXuongShop@gmail.com</li>
                </ul>
                <div class="footer-social">
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-instagram"></i></a>
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-pinterest"></i></a>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-1">
                <div class="footer-widget">
                    <h5>Information</h5>
                    <ul>
                        <li><a href="">About Us</a></li>
                        <li><a href="">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="footer-widget">
                    <h5>My Account</h5>
                    <ul>
                        @if (auth()->user())
                            <li><a href="{{ Route('userProfile') }}">My Account</a></li>
                        @else
                            <li><a href="{{ Route('login') }}">My Account</a></li>   
                        @endif
                        <li><a href="{{ Route('viewCart') }}">Shopping Cart</a></li>
                        <li><a href="{{ Route('fe.shop.index') }}">Shop</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="newslatter-item">
                    <h5>Join Our New Letter Now</h5>
                    <p>Get E-mail updates about our Lastest shop and special offers</p>
                    <form action="#" class="subscribe-form">
                        <input type="text" placeholder="Enter E-mail">
                        <button type="button">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-reserved">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-text">
                        Copyright
                        <script>
                            document.write(new Date().getFullYear());
                        </script> All right reserved | This temple is made with <i class="fa fa-heart-o"
                            aria-hidden="true"></i> by <a href="#" target="_blank">Group-01</a>
                    </div>
                    <div class="payment-pic">
                        <img src="{{ asset('frontend/img/payment-method.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
