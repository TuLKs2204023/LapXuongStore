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
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.161425545649!2d106.64525215056754!3d10.798945661692306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175294a0c97a181%3A0x6aece518177f9a92!2sGEARVN%20Ho%C3%A0ng%20Hoa%20Th%C3%A1m!5e0!3m2!1sen!2s!4v1675936609207!5m2!1sen!2s"
                    height="610" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
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
                                <p>78-80-82 Hoàng Hoa Thám, Phường 12, Quận Tân Bình.</p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-mobile"></i>
                            </div>
                            <div class="ci-text">
                                <span>Phone:</span>
                                <p>+84 052 276 5313</p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-email"></i>
                            </div>
                            <div class="ci-text">
                                <span>Email:</span>
                                <p>daoducbinh62@gamil.com</p>
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
                                        <input type="text" placeholder="Your Name">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" placeholder="Your Email">
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
