@extends('layouts.frontend_layout')
@section('active_menu')
    class="nav-item active"
@endsection
@section('content')
    {{-- Thông báo thêm thành công --}}
    @if (session('success'))
        <input type="text" class="success-addCartOnline" id="success-addCartOnline" value="{{ session('success') }}" hidden>
    @endif
    @if (session('error'))
        <input type="text" class="error-addCartOnline" id="error-addCartOnline" value="{{ session('errors') }}" hidden>
    @endif
    @if (session('warning'))
        <input type="text" class="warning-addCartOnline" id="warning-addCartOnline" value="{{ session('warning') }}" hidden>
    @endif
    @if (session('message'))
        <input type="text" class="message-addCartOnline" id="message-addCartOnline" value="{{ session('message') }}" hidden>
    @endif
    <section class="home-slider owl-carousel">

        <div class="slider-item" style="background-image: url({{ asset('frontend/images/bg_3.jpg') }});" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center">

                    <div class="col-md-7 col-sm-12 text-center ftco-animate">
                        <h1 class="mb-3 mt-5 bread">Menu của chúng tôi</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('Trangchu.index') }}">Trang
                                    chủ</a></span> <span>Menu</span></p>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                @if (isset($LoaiSP))
                    @foreach ($LoaiSP as $LSP)
                        <div class="col-md-12 mb-5 pb-3">
                            <h3 class="mb-5 heading-pricing ftco-animate">{{ $LSP->tenloaisanpham }}</h3>
                            @if (isset($SanPham))
                                @foreach ($SanPham as $SP)
                                    @if ($LSP->id == $SP->id_loaisanpham)
                                        <div class="pricing-entry d-flex ftco-animate">
                                            <a href="{{ route('SanPham.show', $SP->id) }}">
                                                <div class="img" style="background-image: url({{ asset('uploads/SanPham/' . $SP->hinhanh) }});">
                                                </div>
                                            </a>
                                            <div class="desc pl-3">
                                                <div class="d-flex text align-items-center">
                                                    <h3><span><a href="{{ route('SanPham.show', $SP->id) }}">{{ $SP->tensanpham }}</a></span>
                                                    </h3>
                                                    {{-- <span class="price">$20.00</span> --}}
                                                    @if (isset($SPQC))
                                                        @foreach ($SPQC as $QC)
                                                            @if ($QC->id_sanpham == $SP->id)
                                                                <a href="{{ route('SanPham.show', $SP->id) }}" style="margin: 0 2% ">
                                                                    <span class="price">{{ $QC->tenquycach }}</span>
                                                                    <span class="price">{{ number_format($QC->giasanpham, 0, ',', '.') }}VNĐ</span>
                                                                </a>

                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="d-block">
                                                    <p>{{ $SP->mota }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                @endif


            </div>
        </div>
    </section>

@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/css.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/themes/default.min.css') }}">
@endsection
@section('script')
    <script src="{{ asset('frontend/alertifyjs/alertify.min.js') }}"></script>
    <script type="text/javascript">
        window.onload = function() {
            if ($('#success-addCartOnline').hasClass('success-addCartOnline')) {
                alertify.success($('#success-addCartOnline').val());
            }
            if ($('#error-addCartOnline').hasClass('error-addCartOnline')) {
                alertify.error($('#error-addCartOnline').val());
            }
            if ($('#warning-addCartOnline').hasClass('warning-addCartOnline')) {
                alertify.warning($('#warning-addCartOnline').val());
            }
            if ($('#message-addCartOnline').hasClass('message-addCartOnline')) {
                alertify.message($('#message-addCartOnline').val());
            }
        };
    </script>
@endsection
