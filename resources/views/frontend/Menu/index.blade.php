@extends('layouts.frontend_layout')
@section('active_menu')
    class="nav-item active"
@endsection
@section('content')
    <section class="home-slider owl-carousel">
        <div class="slider-item" style="background-image: url({{ asset('frontend/images/bg_3.jpg') }});" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center">
                    <div class="col-md-7 col-sm-12 text-center ftco-animate">
                        <h1 class="mb-3 mt-5 bread">Thực Đơn</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('Trangchu.index') }}">Trang chủ</a></span> <span>Thực Đơn</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section">
        <div class="container">
            @isset($LoaiSanPham)
                @foreach ($LoaiSanPham as $item)
                    <div class="heading-section ftco-animate fadeInUp ftco-animated">
                        <span class="subheading mb-5">{{ $item->tenloaisanpham }}</span>
                    </div>
                    <div class="row">
                        @isset($Menu)
                            @foreach ($Menu as $itemM)
                                @if ($item->id == $itemM->id_loaisanpham)
                                    <div class="col-md-6 mb-2">
                                        <div class="pricing-entry d-flex ftco-animate fadeInUp ftco-animated">
                                            <div class="img" style="background-image: url({{ asset('uploads/SanPham/' . $itemM->hinhanh) }});"></div>
                                            <div class="desc pl-3">
                                                <div class="d-flex text align-items-center">
                                                    <h3><span>{{ $itemM->tensanpham }}</span></h3>
                                                    <span class="price">{{ number_format($itemM->giasanpham, 0, ',', '.') . ' VNĐ' }}</span>
                                                </div>
                                                <div class="d-block">
                                                    {{-- <p>{{ $itemM->mota }}</p> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endisset
                    </div>
                @endforeach
            @endisset
        </div>
    </section>
    {{-- cho nó thành slider sản phẩm --}}
    <section class="ftco-section pt-0">
        <div class="container">
            <div class="row justify-content-center pb-3">
                <div class="col-md-7 heading-section ftco-animate text-center">
                    <span class="subheading">Khám phá</span>
                    <h2 class="mb-4">Cà phê hạt</h2>
                    <p>Cà phê là thức uống quen thuộc mỗi buổi sáng giúp chúng ta có thể cảm nhận được cả thế giới chuyển động trong cơ thể.</p>
                </div>
            </div>
            {{--  --}}
            <div class="productnew-slider owl-carousel">
                @isset($CaPheHat)
                    @foreach ($CaPheHat as $item)
                        <div class="menu-entry menu-entry-slider">
                            <a href="{{ route('SanPham.show', $item->id) }}" class="img" style="background-image: url({{ asset('uploads/SanPham/' . $item->hinhanh) }});"></a>
                            <div class="text text-center pt-4">
                                <h3><a href="{{ route('SanPham.show', $item->id) }}">{{ $item->tensanpham }}</a></h3>
                                <p class="price"><span>{{ number_format($item->giasanpham, 0, ',', '.') . ' VNĐ' }}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
            {{--  --}}
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

    </script>
@endsection
