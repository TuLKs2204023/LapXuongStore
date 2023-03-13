@extends('fe.layout.layout')

@section('fetitle', '- Contacts')

@section('content')
    <!-- BREADCUMB SECTION BEGIN-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="index.html"><i class="fa fa-home"></i>Home</a>
                        <span>Contact</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCUMB SECTION END-->

    <!-- MAP SECTION BEGIN-->
    <div class="map spad">
        <div class="container">
            <div class="map-inner">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.752480107732!2d106.67612731474445!3d10.830244561159624!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529d5c459ba27%3A0xc82bf04d8e034311!2zUGhvbmcgVsWp!5e0!3m2!1sen!2s!4v1678424292960!5m2!1sen!2s"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="icon">
                    <i class="fa fa-map-marker"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- MAP SECTION END-->

    <!-- CONTACT SECTION BEGIN-->\
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="contact-title b">
                        <h4>Contact Us</h4>
                        <p>Buy PC Gaming, gaming laptop, video card, computer monitor,
                            gaming chair, gaming equipment like PS5 leading in Vietnam with
                            genuine warranty. Buy online and receive great deals with many special
                            programs such as Black Friday, G-Fest, Cyber Monday</p>
                    </div>
                    <div class="contact-widget">
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-location-pin"></i>
                            </div>
                            <div class="ci-text">
                                <span>Address:</span>
                                <p>2A Nguyen Oanh, Ward 7, Go Vap, Ho Chi Minh City</p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-mobile"></i>
                            </div>
                            <div class="ci-text">
                                <span>Phone:</span>
                                <p>03979-3979-3979</p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-email"></i>
                            </div>
                            <div class="ci-text">
                                <span>Email:</span>
                                <p>LapXuongShop@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="contact-form">
                        <div class="leave-comment">
                            <h4>Leave A Comment</h4>
                            <p>Our staff will call back later and answer your question.</p>
                            <form action="#" class="comment-form">
                                <div class="row">
                                    <div class="col-lg-6">
                                        @if (auth()->user())
                                            <input type="text" placeholder="Your Name" value="{{ auth()->user()->name }}" name="name">
                                        @else
                                            <input type="text" placeholder="Your Name" name="name">   
                                        @endif
                                    </div>
                                    <div class="col-lg-6">
                                        @if (auth()->user())
                                            <input type="text" placeholder="Your Email" value="{{ auth()->user()->email }}" name="email">
                                        @else
                                            <input type="text" placeholder="Your Email" name="email">   
                                        @endif
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea placeholder="Your Message"></textarea>
                                        <button type="submit" class="site-btn">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CONTACT SECTION END-->
@endsection
