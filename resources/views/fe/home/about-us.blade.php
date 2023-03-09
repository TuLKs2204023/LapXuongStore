@extends('fe.layout.layout')
@section('fetitle', '- About Us')

@section('Css')
    <style>
       .social-link {
  width: 30px;
  height: 30px;
  border: 1px solid #ddd;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #666;
  border-radius: 50%;
  transition: all 0.3s;
  font-size: 0.9rem;
}

.social-link:hover,
.social-link:focus {
  background: #ddd;
  text-decoration: none;
  color: #555;
}


    </style>
@endsection
@section('content')
  <div class="bg-light py-5 set-bg" data-setbg="{{ asset('images/anh4.jpg') }}">
    <div class="container py-5">
      <div class="row h-100 align-items-center py-5">
        <div class="col-lg-6">
          <h1 class="display-4">About us page</h1>
          <p class="lead text-muted mb-0">Many thanks for your attention.  </p>



        </div>
        <div class="col-lg-6 d-none d-lg-block"></div>
      </div>
    </div>
  </div>

  <div class="bg-white py-5">
    <div class="container py-5">
      <div class="row align-items-center mb-5">
        <div class="col-lg-6 order-2 order-lg-1">
          <h2 class="font-weight-light">Lorem ipsum dolor sit amet</h2>
          <p class="font-italic text-muted mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
        <div class="col-lg-5 px-5 mx-auto order-1 order-lg-2"><img src="https://bootstrapious.com/i/snippets/sn-about/img-1.jpg" alt="" class="img-fluid mb-4 mb-lg-0"></div>
      </div>
      <div class="row align-items-center">
        <div class="col-lg-5 px-5 mx-auto"><img src="https://bootstrapious.com/i/snippets/sn-about/img-2.jpg" alt="" class="img-fluid mb-4 mb-lg-0"></div>
        <div class="col-lg-6">
          <h2 class="font-weight-light">Lorem ipsum dolor sit amet</h2>
          <p class="font-italic text-muted mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-light py-5 set-bg"data-setbg="{{ asset('images/anh6.jpg') }}">
    <div class="container py-5">
      <div class="row mb-4">
        <div class="col-lg-5">
          <h2 class="display-4 font-weight-light" style="color: aliceblue">Our team</h2>
          <p class="font-italic text-muted" style="color: aliceblue">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </div>
      </div>

      <div class="row text-center ">
        <!-- Team item-->
        <div class="col-xl-3 col-sm-6 mb-5 set-bg" data-setbg="{{ asset('images/anh9.jpg') }}">
          <div class="rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-4.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
            <h5 class="mb-0" style="color: aliceblue">Manuella Nevoresky</h5>
            <span class="small text-uppercase text-muted" style="color: aliceblue">CEO - Founder</span>

          </div>
        </div>
        <!-- End-->

        <!-- Team item-->
        <div class="col-xl-3 col-sm-6 mb-5 set-bg" data-setbg="{{ asset('images/anh8.jpg') }}">
          <div class=" rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-3.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
            <h5 class="mb-0" style="color: aliceblue">Samuel Hardy</h5>
            <span class="small text-uppercase text-muted" style="color: aliceblue">CEO - Founder</span>

          </div>
        </div>
        <!-- End-->

        <!-- Team item-->
        <div class="col-xl-3 col-sm-6 mb-5 set-bg" data-setbg="{{ asset('images/anh4.jpg') }}">
          <div class=" rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-2.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
            <h5 class="mb-0" style="color: aliceblue">Tom Sunderland</h5>
            <span class="small text-uppercase text-muted" style="color: aliceblue">CEO - Founder</span>

          </div>
        </div>
        <!-- End-->

        <!-- Team item-->
        <div class="col-xl-3 col-sm-6 mb-5 set-bg" data-setbg="{{ asset('images/anh7.jpg') }}">
          <div class=" rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-1.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
            <h5 class="mb-0" style="color: aliceblue">John Tarly</h5>
            <span class="small text-uppercase text-muted" style="color: aliceblue">CEO - Founder</span>

          </div>
        </div>
        <!-- End-->

      </div>
    </div>
  </div>
@endsection
