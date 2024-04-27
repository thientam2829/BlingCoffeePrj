<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Bling Coffee</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Ensures optimal rendering on mobile devices. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="icon" href="{{ asset('uploads/Logo/logo_bling_coffee.png') }}" type="image/png">

    <link rel="stylesheet" href="{{ asset('frontend/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    @yield('css')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('Trangchu.index') }}">BLING<small>COFFEE</small></a>
            {{-- ? --}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>
            {{-- /? --}}
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li @yield('active_trangchu') class="nav-item"><a href="{{ route('Trangchu.index') }}" class="nav-link">Trang Chủ</a></li>
                    <li @yield('active_sanpham') class="nav-item"><a href="{{ route('SanPham.index') }}" class="nav-link">Sản Phẩm</a></li>
                    <li @yield('active_menu') class="nav-item"><a href="{{ route('Menu.index') }}" class="nav-link">Thực Đơn</a></li>
                    <li @yield('active_vechungtoi') class="nav-item"><a href="{{ route('VeChungToi.index') }}" class="nav-link">Về Chúng Tôi</a></li>
                    <li @yield('active_lienlac') class="nav-item"><a href="{{ route('LienLac.index') }}" class="nav-link">Liên Lạc</a></li>
                    <li class="nav-item cart">
                        <a href="{{ route('GioHang.index') }}" class="nav-link">
                            <span class="icon icon-shopping_cart"></span>
                            <span class="bag d-flex justify-content-center align-items-center">
                                <small id="cart-quantity">
                                    @if (Session::has('GioHangOnline') != null)
                                        {{ Session::get('GioHangOnline')->totalQuanty }}
                                    @else
                                        0
                                    @endif
                                </small>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="ftco-footer ftco-section img">
        <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col-lg-3 col-md-6">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2"><a class="large_logo" href="{{ route('Trangchu.index') }}"><img src="{{ asset('uploads/Logo/logo.png') }}" alt=""></a></h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2"><a class="text-white" href="{{ route('VeChungToi.index') }}">Về chúng tôi</a></h2>
                        <a class="mtop-5" href="{{ route('VeChungToi.index') }}">Bling Coffee là chuỗi cà phê
                            được thành lập vào năm 2020 nhưng với tư duy sáng tạo và phong cách mới mẻ đã đem đến
                            những hương vị mới về cà phê.</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2"><a class="text-white" href="{{ route('VeChungToi.index') }}">Dịch vụ</a> </h2>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('VeChungToi.index') }}">Mua hàng dễ dàng</a></li>
                            <li><a href="{{ route('VeChungToi.index') }}">Dịch vụ chu đáo, nhanh chóng</a></li>
                            <li><a href="{{ route('VeChungToi.index') }}">Chất lượng cà phê thượng hạng</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2"><a class="text-white" href="{{ route('LienLac.index') }}">Liên
                                hệ với chúng tôi</a> </h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon icon2 icon-map-marker"></span><span class="text"><a href="{{ route('LienLac.index') }}">TP Hồ Chí Minh</a></span></li>
                                <li><span class="icon icon2 icon-phone"></span><span class="text"><a href="tel://0916 105 406">+84343344659</a> </span></li>
                                <li><span class="icon icon2 icon-envelope"></span><span class="text"><a href="mailto:SunCoffee137@gmail.com">admin@gmail.com</a> </span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">

                    <p>
                        <script>
                        </script> Bling Coffee được thành lập bởi
                        <a href="{{ route('Trangchu.index') }}" target="_blank">THIENTAM-BINHHOANH
                            </a>
                    </p>
                </div>
            </div>
        </div>



    </footer>

    {{-- Nút quay về đầu trang --}}
    <button style="width: fit-content;height: fit-content;" id="myBtn" title="Lên đầu trang"><i style="font-size: 45px " class="icon-arrow-circle-up"></i></button>


    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
        </svg>
    </div>
    @yield('modal')
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/aos.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('frontend/js/scrollax.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    @yield('script')
    {{-- Zalo chat --}}




    {{-- Button back to top --}}
    <script>
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {

            if (document.body.scrollTop > 600 || document.documentElement.scrollTop > 600) {
                document.getElementById("myBtn").style.display = "block";
            } else {
                document.getElementById("myBtn").style.display = "none";
            }
        }

        document.getElementById('myBtn').addEventListener("click", function() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        });
    </script>

</body>

</html>
