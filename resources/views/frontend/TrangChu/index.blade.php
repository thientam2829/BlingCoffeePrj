@extends('layouts.frontend_layout')
@section('active_trangchu')
    class="nav-item active"
@endsection
@section('content')
    {{-- Thông báo thêm thành công --}}
    @if (session('success'))
        <input type="text" class="Successful_message" id="Successful_message" value="{{ session('success') }}" hidden>
    @endif
    {{-- Slider --}}
    <section class="home-slider owl-carousel">
        <div class="slider-item" style="background-image: url({{ asset('frontend/images/bg_1.jpg') }});">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
                    <div class="col-md-8 col-sm-12 text-center ftco-animate">
                        <span class="subheading">Khám phá</span>
                        <h1 class="mb-4">Cùng Bling Coffee</h1>
                        <p class="mb-4 mb-md-5">Nơi bạn có thể tận hưởng được mọi thứ về cà phê theo một cách hoàn hảo nhất.
                        </p>
                        <p><a href="{{ route('SanPham.index') }}" class="btn btn-primary p-3 px-xl-4 py-xl-3">Mua ngay</a>
                            <a href="{{ route('VeChungToi.index') }}" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">Về Chúng Tôi</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="slider-item" style="background-image: url({{ asset('frontend/images/bg_2.jpg') }});">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
                    <div class="col-md-8 col-sm-12 text-center ftco-animate">
                        <span class="subheading">Khám phá</span>
                        <h1 class="mb-4">Hương vị cà phê tuyệt vời &amp; Không gian yên tĩnh</h1>
                        <p class="mb-4 mb-md-5">Uống cà phê chúng ta nên uống không đường, có như vậy mới thưởng thức trọn
                            vẹn những tinh hoa của cà phê chính gốc.</p>
                        <p><a href="{{ route('SanPham.index') }}" class="btn btn-primary p-3 px-xl-4 py-xl-3">Mua ngay</a>
                            <a href="{{ route('VeChungToi.index') }}" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">Về Chúng Tôi</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="slider-item" style="background-image: url({{ asset('frontend/images/bg_3.jpg') }});">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
                    <div class="col-md-8 col-sm-12 text-center ftco-animate">
                        <span class="subheading">Khám phá</span>
                        <h1 class="mb-4">Dịch vụ tốt nhất</h1>
                        <p class="mb-4 mb-md-5">Chuỗi cửa hàng của Bling Coffee luôn chào đón và phục vụ theo cách tốt nhất để
                            khách hàng luôn cảm thấy thoải mái.</p>
                        <p><a href="{{ route('SanPham.index') }}" class="btn btn-primary p-3 px-xl-4 py-xl-3">Mua ngay</a>
                            <a href="{{ route('VeChungToi.index') }}" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">Về Chúng Tôi</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>
    {{-- cho nó dài đến hết --}}
    <section class="ftco-intro">
        <div class="container-wrap">
            <div class="wrap d-md-flex align-items-xl-end">
                <div class="info">
                    <div class="row no-gutters">
                        <div class="col-md-4 d-flex ftco-animate">
                            <div class="icon"><span class="icon-phone"></span></div>
                            <div class="text">
                                <h3>+343344659</h3>
                                <p>Bling Coffee - Mang lại hương vị cà phê Việt.</p>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex ftco-animate">
                            <div class="icon"><span class="icon-my_location"></span></div>
                            <div class="text">
                                <h3>Địa chỉ</h3>
                                <p> TP Hồ Chí Minh</p>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex ftco-animate">
                            <div class="icon"><span class="icon-clock-o"></span></div>
                            <div class="text">
                                <h3>Mở cửa từ Thứ 2 - Chủ Nhật</h3>
                                <p>7:00 - 22:00</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- giới thiêu rồi chuyêmr đến menu --}}
    <section class="ftco-about d-md-flex">
        <div class="one-half img" style="background-image: url({{ asset('frontend/images/about.jpg') }});"></div>
        <div class="one-half ftco-animate">
            <div class="overlap">
                <div class="heading-section ftco-animate ">
                    <span class="subheading">Khám phá</span>
                    <h2 class="mb-4">Cùng Bling Coffee</h2>
                </div>
                <div>
                    <p class="justify">
                        Việc uống cà phê sáng đã trở thành một văn hoá của người Việt Nam.
                        Hương vị cà phê đậm đà mỗi sáng dường như đã trở thành một phần không thể thiếu trong cuộc sống hàng ngày.
                        Người Việt Nam không xem cà phê là một thức uống giải khát, thức uống để “tỉnh ngủ" như ở một số nước phương Tây, mà thưởng thức cà phê như một thú vui mỗi sáng, nhâm nhi & suy ngẫm.
                        Mỗi buổi sáng ngồi bên tách cà phê thơm vừa đọc báo, vừa nghe nhạc, vừa uống cà phê vừa ăn sáng… hoặc đâu đó bạn sẽ rất hay bắt gặp cảnh những chú lớn tuổi ngồi tán gẫu với nhau về những tin tức thời sự, hay những người lao động ở các quán cà phê cóc cùng nhau uống cà phê sáng, tán gẫu như một thú vui để khởi đầu một ngày làm việc bằng niềm vui và tràn đầy năng lượng.
                        Thật vậy, không phân biệt tầng lớp, già hay trẻ, giàu hay nghèo, cà phê luôn là một phần không thể thiếu của người dân Việt Nam.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-3">
                <div class="col-md-7 heading-section ftco-animate text-center">
                    <span class="subheading">Khám phá</span>
                    <h2 class="mb-4">Cà phê bán chạy nhất hiện nay</h2>
                    <p>Cà phê là thức uống quen thuộc mỗi buổi sáng giúp chúng ta có thể cảm nhận được cả thế giới chuyển động
                        trong cơ thể.</p>
                </div>
            </div>
            {{--  --}}
            <div class="productnew-slider owl-carousel">
                @isset($CaPheHatBanChayNhat)
                    @foreach ($CaPheHatBanChayNhat as $item)
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


    {{-- 1 vài sản phẩm --}}
    <section class="ftco-section ftco-section-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 pr-md-5">
                    <div class="heading-section text-md-right ftco-animate">
                        <span class="subheading">Khám phá</span>
                        <h2 class="mb-4">Cà phê của chúng tôi</h2>
                        <p class="mb-4" style="text-align: justify;">Để có một tách cà phê ngon, trước hết phải có từng hạt cà phê chất lượng. Nhưng chỉ mỗi hạt cà phê hoàn hảo thôi thì cũng chưa đủ. Để mang đến cho bạn một ly cà phê ngon đúng vị là cả một hành trình “ Farm to Cup”.
                            Từ lúc cây lớn lên, đơm hoa, kết quả rồi bắt đầu chọn lọc cho đến quy trình rang xay và cuối cũng nhưng không kém phần quan trọng là sự khéo tay của người Barista.
                            Đến với cà phê, bạn sẽ như lạc vào một thế giới nhiều màu sắc và đầy thú vị bởi mỗi loại hạt cà phê sẽ mang đến cho bạn một hương vị đặc trưng rất khác nhau và với mỗi loại hạt đó, bạn cũng sẽ phải chọn phương thức rang cho phù hợp. Hạt rang xong chưa phải là hết, cà phê phải được xay cho đúng vì nếu xay quá thô, vị cà phê sẽ nhạt , không gậy hết hương thơm của hạt còn nếu xay quá mịn thì vị cà phê sẽ đắng và có nhiều bột theo nước vào ly cà phê làm mất vị.
                            Để cho ra ly cà phê ngon đúng chất rất cần đến sự khéo léo và sự quan sát tinh tế của người Barista lành nghề.</p>
                        <p><a href="{{ route('SanPham.index') }}" class="btn btn-primary btn-outline-primary px-4 py-3">Xem sản phẩm</a></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="menu-entry">
                                <a href="#" class="img" style="background-image: url({{ asset('frontend/images/menu-1.jpg') }});"></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="menu-entry mt-lg-4">
                                <a href="#" class="img" style="background-image: url({{ asset('frontend/images/menu-2.jpg') }});"></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="menu-entry">
                                <a href="#" class="img" style="background-image: url({{ asset('frontend/images/menu-3.jpg') }});"></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="menu-entry mt-lg-4">
                                <a href="#" class="img" style="background-image: url({{ asset('frontend/images/menu-4.jpg') }});"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('modal')
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button style="outline: none" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="dataxemsanpham">
                    <div class="billing-form ftco-bg-dark ftco-bg-dark-info p-3 p-md-5">
                        <h3 class="mb-4 billing-heading billing-heading-center"> Bạn Đã Đặt Hàng Thành Công</h3>
                        <h4 class="mb-4 billing-heading billing-heading-center">Chúng Tôi Sẽ Xác Nhận Đơn Hàng Của Bạn</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/css.css') }}" />
@endsection
@section('script')
    <script type="text/javascript">
        window.onload = function() {
            if ($('#Successful_message').hasClass('Successful_message')) {
                $('#exampleModal').modal('show');
            }
        };
    </script>
@endsection
