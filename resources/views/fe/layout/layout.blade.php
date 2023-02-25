<!DOCTYPE html>
<html lang="eng">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="codelean Template">
    <meta name="keywords" content="codelean, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LapShop</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" />

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

    <link rel="stylesheet" href="{{ asset('css/KienCss/toast.css') }}">
    <link rel="stylesheet" href="{{ asset('css/KienCss/confirmDialog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/KienCss/customSelect.css') }}">
    <!-- -------------------------------------------------------------------------------- -->
    @yield('myCss')
</head>

<body>

    @include('fe.layout.header')
    <!-- ----------------------------------------HEADER-------------------------------------------------------- -->
    @yield('breader')
    @yield('category')
    <!-- -------------------------------------CATEGORY--------------------------------------------------------- -->
    @yield('content')

    <div id="myToast"></div>

    <div class="dialog-container">
        <div class="dialog-content">
            <div class="dialog-header">
                <div><span class="close-btn cancel-btn"><i class="fa-solid fa-xmark"></i></span></div>
            </div>
            <div class="dialog-body">
                <h4 class="dialog-title">Are you sure to DELETE this item?</h4>
            </div>
            <div class="dialog-footer">
                <button class="form-submit standard warning proceed-btn">Proceed</button>
                <button class="form-submit standard cancel-btn">Cancel</button>
            </div>
        </div>
    </div>
    <!-- -------------------------------------CONTENT BODY------------------------------------------------------- -->

    <!-- Footer SECTION BEGIN-->
    @include('fe.layout.footer')

    <!-- Footer SECTION END-->
    <!-- -------------------------------------------------------------------------------- -->

    <!-- Js Plugins -->
    <script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.dd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    @yield('myJs')
</body>

</html>
