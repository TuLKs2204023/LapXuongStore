    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Email</title>
        <!-- Css Styles -->
        <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('frontend/css/themify-icons.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('frontend/css/elegant-icons.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('frontend/css/jquery-ui.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('frontend/css/slicknav.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" type="text/css">

        <!-- Main Css Styles -->
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">

        <style>
            @media (min-width: 1025px) {
                .h-custom {
                    height: 100vh !important;
                }
            }

            .horizontal-timeline .items {
                border-top: 2px solid #ddd;
            }

            .horizontal-timeline .items .items-list {
                position: relative;
                margin-right: 0;
            }

            .horizontal-timeline .items .items-list:before {
                content: "";
                position: absolute;
                height: 8px;
                width: 8px;
                border-radius: 50%;
                background-color: #ddd;
                top: 0;
                margin-top: -5px;
            }

            .horizontal-timeline .items .items-list {
                padding-top: 15px;
            }
        </style>
    </head>

    <body>
        <section class="h-100 h-custom" style="background-color: #eee;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-8 col-xl-6">
                        <div class="card border-top border-bottom border-3" style="border-color: #4154f1 !important;">
                            <div class="card-body p-5">

                                <p class="lead fw-bold mb-5" style="color: #4154f1;">Purchase Reciept</p>

                                <div class="row">
                                    <div class="col mb-3">
                                        <p class="small text-muted mb-1">Date</p>
                                        <p>{{ $order->created_at }}</p>
                                    </div>
                                    <div class="col mb-3">
                                        <p class="small text-muted mb-1">Order No.</p>
                                        <p>(LXS-{{ $order->id }})</p>
                                    </div>
                                </div>
                                @foreach ($order->details as $item)
                                    <div class="mx-n5 px-5 py-4" style="background-color: #f2f2f2;">
                                        <div class="row">
                                            <div class="col-md-8 col-lg-9">
                                                <p>{{ $item->product->name }}</p>
                                            </div>
                                            <div class="col-md-4 col-lg-3">
                                                <p>{{ number_format($item->stock->price->sale, 0, ',', '.') . ' VND' }}
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                                <div class="row">
                                    <div class="col-md-8 col-lg-9">
                                        <p class="mb-0">Shipping</p>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <p class="mb-0">FREE</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-lg-9">
                                        <p class="mb-0">Discount</p>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <p>{{ number_format($order->discountAmount(), 0, ',', '.') . ' VND' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-md-4 offset-md-8 col-lg-3 offset-lg-9">
                                        <p class="lead fw-bold mb-0" style="color: #4154f1;">
                                            {{ number_format($order->totalAfterDiscount(), 0, ',', '.') . ' VND' }}</p>
                                    </div>
                                </div>

                                <p class="lead fw-bold mb-4 pb-2" style="color: #4154f1;">Tracking Order</p>

                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="horizontal-timeline">

                                            <ul class="list-inline items d-flex justify-content-between">
                                                <li class="list-inline-item items-list">
                                                    <p class="py-1 px-2 rounded text-white"
                                                        style="background-color: #4154f1;">Ordered</p
                                                        class="py-1 px-2 rounded text-white"
                                                        style="background-color: #4154f1;">
                                                </li>
                                                <li class="list-inline-item items-list text-end"
                                                    style="margin-right: 8px;">
                                                    <p style="margin-right: -8px;">Shipped</p>
                                                </li>
                                                <li class="list-inline-item items-list text-end"
                                                    style="margin-right: 8px;">
                                                    <p style="margin-right: -8px;">On the way</p>
                                                </li>
                                                <li class="list-inline-item items-list text-end"
                                                    style="margin-right: 8px;">
                                                    <p style="margin-right: -8px;">Delivered</p>
                                                </li>
                                            </ul>

                                        </div>

                                    </div>
                                </div>

                                <p class="mt-4 pt-2 mb-0">Want any help? <a href="#!"
                                        style="color: #4154f1;">Please
                                        contact
                                        us</a></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>

    </html>
