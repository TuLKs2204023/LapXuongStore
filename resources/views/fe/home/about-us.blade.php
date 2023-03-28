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
                <div class="col-lg-6" style="text-align:center">
                    <h1 class="display-4" style="color: #6c757d">About us page</h1>
                    <br>
                    <p class="lead text-muted mb-0" style="color: #6c757d">Many thanks for your attention. </p>
                </div>
                <div class="col-lg-6 d-none d-lg-block"></div>
            </div>
        </div>
    </div>
    <div class="bg-light py-5">
        <div class="container py-5">
            <div class="row mb-4">
                <div class="col-lg-5">
                    <h2 class="display-4 font-weight-light" style="color: #6c757d">Our team</h2>
                    <p class="font-italic text-muted" style="color: aliceblue">E-Project: LAPXUONG STORE</p>
                </div>
            </div>

            <div class="row text-center ">
                <!-- Team item-->
                <div class="col-xl-4 col-sm-6 mb-5 set-bg" data-setbg="{{ asset('images/anh12.jpg') }}">
                    <div class="rounded shadow-sm py-5 px-4"><img
                            src="https://bootstrapious.com/i/snippets/sn-about/avatar-1.png" alt="" width="100"
                            class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                        <h5 class="mb-0" style="color: aliceblue">Tu Le</h5>
                        <span class="small text-uppercase text-muted">Student 1376124</span>

                    </div>
                </div>
                <!-- End-->

                <!-- Team item-->
                <div class="col-xl-4 col-sm-6 mb-5 set-bg" data-setbg="{{ asset('images/anh8.jpg') }}">
                    <div class=" rounded shadow-sm py-5 px-4"><img
                            src="https://bootstrapious.com/i/snippets/sn-about/avatar-3.png" alt="" width="100"
                            class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                        <h5 class="mb-0" style="color: aliceblue">Kien Tran</h5>
                        <span class="small text-uppercase text-muted" style="color: aliceblue">Student 1371444</span>

                    </div>
                </div>
                <!-- End-->

                <!-- Team item-->
                <div class="col-xl-4 col-sm-6 mb-5 set-bg" data-setbg="{{ asset('images/anh7.jpg') }}">
                    <div class=" rounded shadow-sm py-5 px-4"><img
                            src="data:image/jpeg;base64,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"
                            alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                        <h5 class="mb-0" style="color: aliceblue">Le Du</h5>
                        <span class="small text-uppercase text-muted" style="color: aliceblue">Student 1377157</span>

                    </div>
                </div>
                <!-- End-->

            </div>
        </div>
    </div>






@endsection
