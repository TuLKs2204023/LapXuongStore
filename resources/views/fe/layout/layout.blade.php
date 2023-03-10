<!DOCTYPE html>
<html lang="eng">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="codelean Template">
    <meta name="keywords" content="codelean, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>LapXuongStore @yield('fetitle')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('fav-icon.ico') }}">

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

    <!-- Main Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <!-- KIEN Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/KienCss/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/KienCss/shop.css') }}">
    <link rel="stylesheet" href="{{ asset('css/KienCss/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/KienCss/confirmDialog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/KienCss/customSelect.css') }}">
    <link rel="stylesheet" href="{{ asset('css/KienCss/toast.css') }}">
    <link rel="stylesheet" href="{{ asset('css/KienCss/validator.css') }}">
    <!-- -------------------------------------------------------------------------------- -->
    @yield('myCss')

    <!--Toastr + SweetAlert-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/FeCss/toast.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

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
                <h6 class="dialog-title">Are you sure to DELETE this item?</h6>
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


<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <!--Toastr + Sweet Alert-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <!--Toastr -->
    <script type="module">
         @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
            }
        @endif
    </script>
    <!--Toastr -->

    <!-- KIEN Js -->
    <script type="module">
        import {MyToggle, MyStickyNav, HeaderCartHandler} from '{{ asset('/js/KienJs/main.js') }}';

        document.addEventListener("readystatechange", (e) => {
            if (e.target.readyState === "complete") {
                const myToggle = new MyToggle({});
                const myStickyNav = new MyStickyNav({});
                const headerCart = new HeaderCartHandler({
                    url: '{{ Route('emptyCart') }}',
                    token: '{{ csrf_token() }}',
                    selectors: {
                        headerCartSelector: ".cart-icon",
                    },
                });
            }
        });

        const navCateBtn = document.querySelector('.nav-item .cate-btn');
        const navFakeCateBtn = document.querySelector('.nav-fake-categories .cate-btn');
        navCateBtn.addEventListener('click', (e) =>{
            navFakeCateBtn.click();
            navCateBtn.classList.toggle('show');
        });
    </script>
    <!-- KIEN Js -->


     <!--Dropdown address -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        jQuery(document).ready(function ($) {

            /*------------------------------------------
            --------------------------------------------
            City Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#City-dropdown').on('change', function () {
                let idCity = this.value;
                $("#district-dropdown").html('');
                $.ajax({
                    url: "{{url('api/fetch-district')}}",
                    type: "POST",
                    data: {
                        id: idCity,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',

                    success: function (result) {

                        $('#district-dropdown').html('<option value="">-- Select District --</option>');
                        $.each(result.districts, function (key, value) {
                            $("#district-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#ward-dropdown').html('<option value="">-- Select Ward --</option>');
                    }
                });
            });

            /*------------------------------------------
            --------------------------------------------
            District Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#district-dropdown').on('change', function () {
                var idDistrict = this.value;
                console.log(idDistrict);
                $("#ward-dropdown").html('');
                $.ajax({
                    url: "{{url('api/fetch-ward')}}",
                    type: "POST",
                    data: {
                        district_id: idDistrict,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#ward-dropdown').html('<option value="">-- Select Ward --</option>');
                        $.each(res.wards, function (key, value) {
                            $("#ward-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });

        });
    </script>

    @yield('myJs')
</body>

</html>
