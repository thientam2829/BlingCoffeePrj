@extends('layouts.frontend_layout')
@section('active_vechungtoi')
    class="nav-item active"
@endsection
@section('content')
    <section class="home-slider owl-carousel mb-5">
        <div class="slider-item" style="background-image: url({{ asset('frontend/images/bg_3.jpg') }});" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center">

                    <div class="col-md-7 col-sm-12 text-center ftco-animate">
                        <h1 class="mb-3 mt-5 bread">VỀ CHÚNG TÔI</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('Trangchu.index') }}">TRANG CHỦ</a></span> <span>VỀ CHÚNG TÔI</span>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>
    {{--  --}}
    <section class="ftco-about d-md-flex mb-5">
        <div class="one-half ftco-animate fadeInUp ftco-animated">
            <div class="overlap2">
                <div class="heading-section ftco-animate fadeInUp ftco-animated">
                    <span class="subheading">Khám phá</span>
                    <h2 class="mb-4">Câu chuyện của chúng tôi</h2>
                </div>
                <div>
                    <p class="justify">“Cà phê nhé" - Một lời hẹn rất riêng của người Việt. Một lời ngỏ mộc mạc để mình ngồi lại bên nhau và
                        sẻ chia câu chuyện của riêng mình.</p>
                    <p class="justify">
                        Tại Bling Coffee, chúng tôi luôn trân trọng những câu chuyện và đề cao giá trị Kết nối con người.
                        Chúng tôi mong muốn Bling Coffee sẽ trở thành “Nhà Cà Phê", nơi mọi người xích lại gần nhau và tìm
                        thấy niềm vui, sự sẻ chia thân tình bên những tách cà phê đượm hương, chất lượng.</p>
                </div>
            </div>
        </div>
        <div class="one-half img" style="background-image: url({{ asset('frontend/images/cauchuyencaphe.jpg') }});"></div>
    </section>
    {{--  --}}
    <section class="ftco-section img " id="ftco-testimony" style="background-image: url(&quot;{{ asset('frontend/images/lichsucaphe.jpg') }}&quot;); background-position: 50% -65.025px;"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 heading-section text-center ftco-animate fadeInUp ftco-animated">
                    <span class="subheading">Quá trình hình thành</span>
                    <h2 class="mb-4">01/2020 - Ra mắt Bling Coffee</h2>
                    <p>Bling Coffee bắt đầu quá trình hình thành của mình.</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 heading-section text-center ftco-animate fadeInUp ftco-animated">
                    {{-- <span class="subheading">Testimony</span> --}}
                    <h2 class="mb-4">04/2020 - Sau 3 tháng phát triển</h2>
                    <p>Bling Coffee được đón nhận và có thêm nhiều người thưởng thức cà phê chất lượng biết đến.</p>
                </div>
            </div>
            <div class="row justify-content-center mb-5 pb-5">
                <div class="col-md-8 heading-section text-center ftco-animate fadeInUp ftco-animated">
                    <h2 class="mb-4">10/2020 - Mở rộng quy mô trang trại</h2>
                    <p>Sau khi bộ phận Cà Phê của Cầu Đất Farm được sáp nhập vào Bling Coffee, dải
                        sơn nguyên 1,650m trên cao sẽ là nơi chúng tôi gieo nên ước mơ đem hạt cà phê
                        Việt ra ngoài thế giới</p>
                </div>
            </div>
        </div>

    </section>




    <section class="ftco-section ftco-services">
        <div class="container">
            <div class="row">
                <div class="col-md-4 ftco-animate">
                    <div class="media d-block text-center block-6 services">
                        <div class="icon d-flex justify-content-center align-items-center mb-5">
                            <span class="flaticon-choices"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">Mua hàng dễ dàng</h3>
                            <p>Giao diện dễ thao tác và đội ngũ nhân viên phụ vụ nhiệt tình.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ftco-animate">
                    <div class="media d-block text-center block-6 services">
                        <div class="icon d-flex justify-content-center align-items-center mb-5">
                            <span class="flaticon-delivery-truck"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">Dịch vụ chu đáo, nhanh chóng</h3>
                            <p>Bling Coffee luôn hỗ trợ khách hàng một cách nhanh nhất.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ftco-animate">
                    <div class="media d-block text-center block-6 services">
                        <div class="icon d-flex justify-content-center align-items-center mb-5">
                            <span class="flaticon-coffee-bean"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">Chất lượng cà phê thượng hạng</h3>
                            <p>Hạt cà phê được chọn lọc kĩ lưỡng để luôn mang đến hương vị đậm đà nhất.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="ftco-about d-md-flex">
        <div class="one-half img" style="background-image: url({{ asset('frontend/images/dedangmuahang.jpg') }});"></div>
        <div class="one-half ftco-animate">
            <div class="overlap">
                <div class="heading-section ftco-animate ">
                    <h2 class="mb-4">Mua hàng dễ dàng</h2>
                </div>
                <div>
                    <p class="justify">Khách hàng dễ dàng mua hàng thông qua website bán hàng của Bling Coffee. Cho dù bạn có ở đâu thì chỉ với
                        một cú click chuột bạn đã sở hữu ngay sản phẩm mà mình yêu thích trong một thời gian cực kì ngắn.
                    </p>

                </div>
            </div>
        </div>
    </section>

    <section class="ftco-about d-md-flex">
        <div class="one-half ftco-animate fadeInUp ftco-animated">
            <div class="overlap2">
                <div class="heading-section ftco-animate fadeInUp ftco-animated">
                    <h2 class="mb-4">Dịch vụ chu đáo, nhanh chóng</h2>
                </div>
                <div>
                    <p class="justify">
                        Tại Bling Coffee, chúng tôi luôn trân trọng những câu chuyện và đề cao giá trị kết nối con người.Do đó
                        nhân viên luôn hỗ trợ nhiệt tình thông qua nhiều phương tiện liên lạc khác nhau để hỗ trợ, giải đáp
                        thắc mắc của khách hàng một cách nhanh và tốt nhất có thể.</p>
                </div>
            </div>
        </div>
        <div class="one-half img" style="background-image: url({{ asset('frontend/images/hotronhiettinh.jpg') }});"></div>
    </section>

    <section class="ftco-about d-md-flex">
        <div class="one-half img" style="background-image: url({{ asset('frontend/images/minhhoacaphe.jpg') }});"></div>
        <div class="one-half ftco-animate">
            <div class="overlap">
                <div class="heading-section ftco-animate ">
                    <h2 class="mb-4">Chất lượng cà phê thượng hạng</h2>
                </div>
                <div>
                    <p class="justify">Có bao giờ bạn tự hỏi, ly cà phê thơm ngát trên tay mình đã trải qua những chặng đường nào? Khi
                        nhân viên phục vụ mang đến cho bạn một ly cà phê, đó chỉ là hành động cuối cùng của một hành
                        trình dài và kỳ diệu: từ việc chọn vùng đất hợp thổ nhưỡng, sàng lọc giống, tới trồng cây, chăm
                        bón và thu hái.
                    </p>
                    <p class="justify">Từ những cửa hàng đầu tiên, chúng tôi đã bắt đầu hợp tác với Cầu Đất Farm để trồng cà phê theo
                        tiêu chuẩn riêng. Vùng đất phủ sương nằm ở độ cao 1.650m so với mặt nước biển này là nơi tốt
                        nhất để trồng giống cà phê Arabica ở Việt Nam. Chính “độ cao vàng” ấy đã cho ra hạt cà phê
                        Arabica thơm nhẹ, chua thanh tuyệt hảo.</p>
                </div>
            </div>
        </div>
    </section>

    {{--  --}}
    <section class="ftco-counter ftco-bg-dark img" id="section-counter" style="background-image: url(&quot;{{ asset('frontend/images/bg_2.jpg') }}&quot;); background-position: 50% -111.225px;"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate fadeInUp ftco-animated">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <div class="icon"><span class="flaticon-coffee-cup"></span></div>
                                    <strong class="number" data-number=" {{ number_format(count($KhuyenMai), 0, ',', '.') }}"> {{ number_format(count($KhuyenMai), 0, ',', '.') }}</strong>
                                    <span>Khuyến mãi</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate fadeInUp ftco-animated">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <div class="icon"><span class="flaticon-coffee-cup"></span></div>
                                    <strong class="number" data-number="{{ number_format(count($HoaDon), 0, ',', '.') }}">{{ number_format(count($HoaDon), 0, ',', '.') }}</strong>
                                    <span>Hóa đơn đã đặt</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate fadeInUp ftco-animated">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <div class="icon"><span class="flaticon-coffee-cup"></span></div>
                                    <strong class="number" data-number="{{ number_format(count($KhachHang) - 1, 0, ',', '.') }}">{{ number_format(count($KhachHang) - 1, 0, ',', '.') }}</strong>
                                    <span>Khách Hàng Thành Viên</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate fadeInUp ftco-animated">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <div class="icon"><span class="flaticon-coffee-cup"></span></div>
                                    <strong class="number" data-number="{{ number_format(count($NhanVien) - 2, 0, ',', '.') }}">{{ number_format(count($NhanVien) - 2, 0, ',', '.') }}</strong>
                                    <span>Nhân Viên</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/css.css') }}" />
@endsection
