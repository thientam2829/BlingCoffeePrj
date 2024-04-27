@extends('layouts.frontend_layout')
@section('content')
    {{-- Thông báo thêm thành công --}}
    @if (session('success'))
        <input type="text" class="Successful_message" id="Successful_message" value="{{ session('success') }}" hidden>
    @endif
    <section class="home-slider owl-carousel">
        <div class="slider-item" style="background-image: url({{ asset('frontend/images/bg_3.jpg') }});" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center">
                    <div class="col-md-7 col-sm-12 text-center ftco-animate">
                        <h1 class="mb-3 mt-5 bread">đánh giá sản phẩm</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('Trangchu.index') }}">Trang chủ</a></span> <span>đánh giá sản phẩm</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section">
        <div class="container">
            <div class="col-lg-12">
                <div class="border-product-reviews">
                    <h3 class="mb-4 billing-heading billing-heading-center">đánh giá sản phẩm</h3>
                    <div class="row">
                        @isset($SanPham)
                            <div class="col-lg-3 ftco-animate">
                                <a href="{{ asset('uploads/SanPham/' . $SanPham->hinhanh) }}" class="image-popup">
                                    <img src="{{ asset('uploads/SanPham/' . $SanPham->hinhanh) }}" class="img-fluid" alt="Colorlib Template"></a>
                            </div>
                            <div class="col-lg-9 product-details product-details-2 pl-md-4 ftco-animate">
                                <h3><a href="{{ route('SanPham.show', $SanPham->id) }}">{{ $SanPham->tensanpham }}</a></h3>
                                @isset($ChiTietSanPham)
                                    @foreach ($ChiTietSanPham as $stt => $item)
                                        <p class="price">
                                            <a href="{{ route('SanPham.show', $SanPham->id) }}">
                                                @if ($item->muckhuyenmai != null)
                                                    {{ number_format($item->giasanpham * (1 - $item->muckhuyenmai / 100), 0, ',', '.') . ' VNĐ - ' . $item->tenquycach . ' (-' . $item->muckhuyenmai . '%)' }}
                                                @else
                                                    {{ number_format($item->giasanpham, 0, ',', '.') . ' VNĐ - ' . $item->tenquycach }}
                                                @endif
                                            </a>
                                        </p>
                                    @endforeach
                                @endisset
                                <p><a href="{{ route('SanPham.show', $SanPham->id) }}">{{ $SanPham->mota }}</a> </p>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-section-bottom">
        <div class="container">
            <div class="col-lg-8">
                <div class="row">
                    {{-- Số sao Đánh Giá --}}
                    <div class="col-lg-6">
                        <div class="top-reviews">
                            @isset($SanPham)
                                @if ($SanPham->sosao == null)
                                    <div class="point">0</div>
                                @else
                                    <div class="point">{{ $SanPham->sosao }}</div>
                                @endif
                                <div class="list-star">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($SanPham->sosao - $i >= 1) <i class="fas fa-star"></i>
                                        @elseif (($SanPham->sosao - $i) >= 0.5)<i class="fas fa-star-half-alt"></i>
                                        @else <i class="far fa-star"></i> @endif
                                    @endfor
                                </div>
                            @endisset
                            @isset($CountDanhGia)
                                @if ($CountDanhGia == null)
                                    <div class="rating-total">0 đánh giá</div>
                                @else
                                    <div class="rating-total">{{ $CountDanhGia }} đánh giá</div>
                                @endif
                            @endisset
                        </div>
                    </div>
                    {{-- nút đánh giá --}}
                    <div class="col-lg-6">
                        <div class="btn-review"><button onclick="formReview()" class="btn btn-primary review-submit">Viết đánh giá</button></div>
                    </div>
                </div>
                <div class="row">
                    {{-- phần trăm đánh giá --}}
                    <div class="col-lg-6">
                        <div class="rating-right">
                            @isset($ArraySoSao)
                                @if ($ArraySoSao != 'nulls')
                                    @foreach ($ArraySoSao as $key => $item)
                                        <div class="rating-list">
                                            <div class="number-star">
                                                {{ $key + 1 }} <i class="fas fa-star"></i>
                                            </div>
                                            <div class="timeline-star">
                                                <p class="timing" style="width: {{ $item }}%;"></p>
                                            </div>
                                            <div class="number-percent">{{ $item }}%</div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="rating-list">
                                        <div class="number-star">
                                            1 <i class="fas fa-star"></i>
                                        </div>
                                        <div class="timeline-star">
                                            <p class="timing" style="width: 0%;"></p>
                                        </div>
                                        <div class="number-percent">0%</div>
                                    </div>
                                    <div class="rating-list">
                                        <div class="number-star">
                                            2 <i class="fas fa-star"></i>
                                        </div>
                                        <div class="timeline-star">
                                            <p class="timing" style="width: 0%;"></p>
                                        </div>
                                        <div class="number-percent">0%</div>
                                    </div>
                                    <div class="rating-list">
                                        <div class="number-star">
                                            3 <i class="fas fa-star"></i>
                                        </div>
                                        <div class="timeline-star">
                                            <p class="timing" style="width: 0%;"></p>
                                        </div>
                                        <div class="number-percent">0%</div>
                                    </div>
                                    <div class="rating-list">
                                        <div class="number-star">
                                            4 <i class="fas fa-star"></i>
                                        </div>
                                        <div class="timeline-star">
                                            <p class="timing" style="width: 0%;"></p>
                                        </div>
                                        <div class="number-percent">0%</div>
                                    </div>
                                    <div class="rating-list">
                                        <div class="number-star">
                                            5 <i class="fas fa-star"></i>
                                        </div>
                                        <div class="timeline-star">
                                            <p class="timing" style="width: 0%;"></p>
                                        </div>
                                        <div class="number-percent">0%</div>
                                    </div>
                                @endif

                            @endisset
                        </div>
                    </div>
                    {{-- các chức năng tìm kiếm và lọc --}}
                    <div class="col-lg-6">
                        <div class="d-flex">
                            <form class="search-form">
                                @csrf
                                <div class="icon">
                                    <button style="outline: none" type="submit" id="form-search" data-url="{{ route('danh-gia.userSearch') }}"><span class="icon-search"></span></button>
                                </div>
                                @isset($SanPham)
                                    <input autocomplete="off" value="{{ $SanPham->id }}" name="id" type="text" hidden>
                                @endisset
                                <input autocomplete="off" value="0" name="filter" id="filter" type="text" hidden>
                                <input autocomplete="off" type="text" name="keyword" class="cmtKeyReview form-control" placeholder="Tìm theo nội dung...">
                            </form>
                        </div>
                        <div class="">
                            <p style="margin: 10px 0px;">Lọc Theo:</p>
                            <a href="javascript:(0)" onclick="filter('0')" class="rating-filter 0sao active">Tất cả</a>
                            <a href="javascript:(0)" onclick="filter('1')" class="rating-filter 1sao">1 sao</a>
                            <a href="javascript:(0)" onclick="filter('2')" class="rating-filter 2sao">2 sao</a>
                            <a href="javascript:(0)" onclick="filter('3')" class="rating-filter 3sao">3 sao</a>
                            <a href="javascript:(0)" onclick="filter('4')" class="rating-filter 4sao">4 sao</a>
                            <a href="javascript:(0)" onclick="filter('5')" class="rating-filter 5sao">5 sao</a>
                        </div>
                    </div>
                </div>
                {{-- danh sách dánh giá --}}
                <div class="ratingLst">
                    <hr style="border-top: 1px solid #c49b63;">
                    @isset($DanhGia)
                        <div id="review">
                            @foreach ($DanhGia as $item)
                                <div class="rating">
                                    <div class="review-name">{{ $item->hoten }}</div>
                                    <div class="review-star">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($item->sosao - $i >= 1) <i class="fas fa-star"></i>
                                            @else <i class="far fa-star"></i> @endif
                                        @endfor
                                        <samp class="review-time">{{ date_format(date_create($item->thoigian), 'd/m/Y H:i:s') }}</samp>
                                    </div>
                                    <div class="review-comment">
                                        {{ $item->noidung }}
                                    </div>
                                </div>
                                <hr style="border-top: 1px solid #c49b63;">
                            @endforeach
                        </div>
                        <div class='col-12 d-flex justify-content-center' style='padding: 15px'>
                            {{ $DanhGia->links() }}
                        </div>
                    @endisset
                </div>
            </div>
    </section>
    <section class="ftco-section ftco-section-bottom">
        <div class="container">
            <div class="row justify-content-center pb-3">
                <div class="col-md-7 heading-section ftco-animate text-center">
                    <span class="subheading">Khám Phá</span>
                    <h2 class="mb-4">Những sản phẩm liên quan</h2>
                    <p>Cà phê là thức uống quen thuộc mỗi buổi sáng giúp tôi có thể cảm nhận được cả thế giới chuyển động trong cơ thể.</p>
                </div>
            </div>
            <div class="productnew-slider owl-carousel">
                @isset($SanPhamLienQuang)
                    @foreach ($SanPhamLienQuang as $item)
                        <div class="menu-entry menu-entry-slider">
                            <a href="{{ route('SanPham.show', $item->id) }}" class="img" style="background-image: url({{ asset('uploads/SanPham/' . $item->hinhanh) }});"></a>
                            <div class="text text-center pt-4">
                                <h3><a href="{{ route('SanPham.show', $item->id) }}">{{ $item->tensanpham }}</a></h3>
                                <p class="price"><span>{{ number_format($item->giasanpham, 0, ',', '.') . ' VNĐ' }}</span></p>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </section>
@endsection
@section('modal')
    {{-- thông báo --}}
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button style="outline: none" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="dataxemsanpham">
                    <div class="billing-form ftco-bg-dark ftco-bg-dark-info p-3 p-md-5">
                        <h3 class="mb-4 billing-heading billing-heading-center">Đã Gửi Thành Công</h3>
                        <h4 class="mb-4 billing-heading billing-heading-center" id="notification">Chúng Tôi Sẽ Xác Nhận Đơn Hàng Của Bạn</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- gửi đánh giá --}}
    <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button style="outline: none" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="datasanpham">
                    <div class="billing-form ftco-bg-dark p-3">
                        <form action="{{ route('danh-gia.create') }}" method="POST">
                            @csrf
                            <div class="col-lg-12">
                                <h3 class="mb-4 billing-heading billing-heading-center">Đánh Giá Sản Phẩm</h3>
                                <div class="form-group">
                                    <textarea name="noidungReview" id="noidungReview" cols="30" rows="3" class="form-control" placeholder="Mời bạn chia sẽ thêm một số cảm nhận..."></textarea>
                                </div>
                                <div class="form-group">
                                    Bạn cảm thấy sản phẩm này như thế nào?
                                    <div class="list-star-comment">
                                        <div class="star1" data-val="1">
                                            <i class="fas fa-star" id="starReview1"></i>
                                            <p id="textStarReview1">Rất tệ</p>
                                        </div>
                                        <div class="star1" data-val="2">
                                            <i class="fas fa-star" id="starReview2"></i>
                                            <p id="textStarReview2">Tệ</p>
                                        </div>
                                        <div class="star1" data-val="3">
                                            <i class="fas fa-star" id="starReview3"></i>
                                            <p id="textStarReview3">Bình thường</p>
                                        </div>
                                        <div class="star1" data-val="4">
                                            <i class="fas fa-star" id="starReview4"></i>
                                            <p id="textStarReview4">Tốt</p>
                                        </div>
                                        <div class="star1" data-val="5">
                                            <i class="fas fa-star" id="starReview5"></i>
                                            <p id="textStarReview5">Rất tốt</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="hotenReview" class="form-control cfmInformationForm" placeholder="Họ tên (bắt buộc)" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input name="emailReview" type="email" class="form-control cfmInformationForm" placeholder="Email (để nhận phản hồi )" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input value="0" name="sosaoReview" id="sosaoReview" type="text" hidden>
                                    <input value="review" name="pagreview" id="pagreview" type="text" hidden>
                                    @isset($SanPham)
                                        <input value="{{ $SanPham->id }}" name="id_sanphamReview" type="text" required hidden>
                                    @endisset
                                </div>
                                <input type="submit" id="submitReview" value="Gửi Đánh Giá" class="btn btn-primary py-3 px-5" style="width: 100%;">
                                <div><span class="MsgCmt"></span></div>
                            </div>
                        </form><!-- END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/css.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/themes/default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/font_awesome/css/all.min.css') }}" />
@endsection
@section('script')
    <script src="{{ asset('frontend/alertifyjs/alertify.min.js') }}"></script>
    <script type="text/javascript">
        ///////////////////////////////////////// hiển thị Thông báo.
        window.onload = function() {
            if ($('#Successful_message').hasClass('Successful_message')) {
                var text = $('#Successful_message').val();
                $('#notification').text(text);
                $('#exampleModal2').modal('show');
            }
        };
        ///////////////////////////////////////// serach
        $('#form-search').on('click', function(e) {
            e.preventDefault(); // dừng  sự kiện submit.
            if ($("input[name='keyword']").val().length > 0) {
                $.ajax({
                    url: $(this).data('url'),
                    method: 'POST',
                    data: {
                        _token: $("input[name='_token']").val(),
                        keyword: $("input[name='keyword']").val(),
                        filter: $("input[name='filter']").val(),
                        id: $("input[name='id']").val(),
                    },
                    success: function(response) {
                        $('.pagination').hide();
                        $("input[name='keyword']").val("");
                        $('#review').html(response);
                        alertify.success("Đã Tìm");
                    },
                    error: function(response) {
                        alertify.error("Lỗi Tìm Kiếm");
                    }
                })
            }
        });
        ///////////////////////////////////////// Mở form gửi đánh giá.
        function formReview() {
            $('#exampleModal4').modal('show');
        };
        ///////////////////////////////////////// kiểm tra form gửi đánh giá.
        $('#submitReview').on('click', function(e) {
            if ($('#noidungReview').val() == '') {
                $('.MsgCmt').text('Vui lòng nhập nội dung đánh giá về sản phẩm.');
                return false;
            }
            if ($('#sosaoReview').val() == '0') {
                $('.MsgCmt').text('Bạn chưa đánh giá điểm sao, vui lòng đánh giá.');
                return false;
            }
            return true;
        });
        ///////////////////////////////////////// chọn sao.
        $('.star1').on('click', function() {
            $('#sosaoReview').val($(this).data('val'));
            if ($(this).data('val') == 1) {
                $('#starReview1').addClass('active');
                $('#starReview2').removeClass('active');
                $('#starReview3').removeClass('active');
                $('#starReview4').removeClass('active');
                $('#starReview5').removeClass('active');
                $('#textStarReview1').addClass('active');
                $('#textStarReview2').removeClass('active');
                $('#textStarReview3').removeClass('active');
                $('#textStarReview4').removeClass('active');
                $('#textStarReview5').removeClass('active');
            }
            if ($(this).data('val') == 2) {
                $('#starReview1').addClass('active');
                $('#starReview2').addClass('active');
                $('#starReview3').removeClass('active');
                $('#starReview4').removeClass('active');
                $('#starReview5').removeClass('active');
                $('#textStarReview1').removeClass('active');
                $('#textStarReview2').addClass('active');
                $('#textStarReview3').removeClass('active');
                $('#textStarReview4').removeClass('active');
                $('#textStarReview5').removeClass('active');
            }
            if ($(this).data('val') == 3) {
                $('#starReview1').addClass('active');
                $('#starReview2').addClass('active');
                $('#starReview3').addClass('active');
                $('#starReview4').removeClass('active');
                $('#starReview5').removeClass('active');
                $('#textStarReview1').removeClass('active');
                $('#textStarReview2').removeClass('active');
                $('#textStarReview3').addClass('active');
                $('#textStarReview4').removeClass('active');
                $('#textStarReview5').removeClass('active');
            }
            if ($(this).data('val') == 4) {
                $('#starReview1').addClass('active');
                $('#starReview2').addClass('active');
                $('#starReview3').addClass('active');
                $('#starReview4').addClass('active');
                $('#starReview5').removeClass('active');
                $('#textStarReview1').removeClass('active');
                $('#textStarReview2').removeClass('active');
                $('#textStarReview3').removeClass('active');
                $('#textStarReview4').addClass('active');
                $('#textStarReview5').removeClass('active');
            }
            if ($(this).data('val') == 5) {
                $('#starReview1').addClass('active');
                $('#starReview2').addClass('active');
                $('#starReview3').addClass('active');
                $('#starReview4').addClass('active');
                $('#starReview5').addClass('active');
                $('#textStarReview1').removeClass('active');
                $('#textStarReview2').removeClass('active');
                $('#textStarReview3').removeClass('active');
                $('#textStarReview4').removeClass('active');
                $('#textStarReview5').addClass('active');
            }
        });
        ///////////////////////////////////////// filter.
        function filter(a) {
            $.ajax({
                url: '/danh-gia/loc',
                method: 'GET',
                data: {
                    filter: a,
                    id: $("input[name='id']").val(),
                },
                success: function(response) {
                    $('.pagination').hide();
                    $('#review').html(response);
                    $('.rating-filter').removeClass('active');
                    $('.' + a + 'sao').addClass('active');
                    $('#filter').val(a);
                    alertify.success("Đã Lọc");
                },
                error: function(response) {
                    alertify.error("Lỗi Lọc");
                }
            })
        };
    </script>
@endsection
