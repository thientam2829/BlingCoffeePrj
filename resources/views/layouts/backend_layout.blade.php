<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Bling Coffee - Quản Lý Bán Hàng</title>

    <link rel="icon" href="{{ asset('uploads/Logo/logo_bling_coffee.png') }}" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}" /> {{-- bootstrap --}}
    <link rel="stylesheet" href="{{ asset('backend/vendors/font_awesome/css/all.min.css') }}" /> {{-- icon --}}
    <!-- style CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/css/css.css') }}" />
    @yield('css')
</head>

<body class="crm_body_bg">
    @include('backend.layout.menu')
    <section class="main_content dashboard_part large_header_bg">
        @include('backend.layout.top-menu')
        @yield('content')
    </section>

    <div id="back-top" style="display: none;">
        <a title="Go to Top" href="#">
            <i class="ti-angle-up"></i>
        </a>
    </div>
    @yield('modal')
    <!-- footer  -->
    <script src="{{ asset('backend/js/jquery-3.4.1.min.js') }}"></script>
    <!-- bootstarp js -->
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    @yield('script')
    @yield('countHoaDonCanXuLy')
    @yield('countSanPhamCanXuLy')
    @yield('countBinhLuanCanXuLy')
    @yield('countDanhGiaCanXuLy')
</body>

</html>
