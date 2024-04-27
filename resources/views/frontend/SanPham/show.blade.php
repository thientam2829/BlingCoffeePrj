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
                        <h1 class="mb-3 mt-5 bread">Chi tiết sản phẩm</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('Trangchu.index') }}">Trang chủ</a></span> <span>Chi tiết sản phẩm</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                @isset($SanPham)
                    <div class="col-lg-6 mb-5 ftco-animate">
                        <a href="{{ asset('uploads/SanPham/' . $SanPham->hinhanh) }}" class="image-popup">
                            <img src="{{ asset('uploads/SanPham/' . $SanPham->hinhanh) }}" class="img-fluid" alt="Colorlib Template"></a>
                    </div>
                    <div class="col-lg-6 product-details product-details-2 pl-md-5 ftco-animate">
                        <h3>{{ $SanPham->tensanpham }}</h3>
                        @if ($ChiTietSanPham[0] == null)
                            <p>{{ $SanPham->mota }}</p>
                            <h2 style="color: red">Sản phẩm này đã bán hết</h2>
                        @else
                            <p class="price"><span>
                                    @isset($ChiTietSanPham)
                                        @if ($ChiTietSanPham[0]->muckhuyenmai != null)
                                            <span
                                                style="text-decoration: line-through;">{{ number_format($ChiTietSanPham[0]->giasanpham, 0, ',', '.') . ' VNĐ' }}</span>{{ ' - ' . $ChiTietSanPham[0]->tenquycach }}<br>
                                            {{ number_format($ChiTietSanPham[0]->giasanpham * (1 - $ChiTietSanPham[0]->muckhuyenmai / 100), 0, ',', '.') . ' VNĐ  (-' . $ChiTietSanPham[0]->muckhuyenmai . '%)' }}
                                        @else
                                            {{ number_format($ChiTietSanPham[0]->giasanpham, 0, ',', '.') . ' VNĐ - ' . $ChiTietSanPham[0]->tenquycach }}
                                        @endif
                                    @endisset
                                </span></p>
                            <p>{{ $SanPham->mota }}</p>
                            <div class="row mt-4">
                                <div class="row row-left">
                                    @isset($ChiTietSanPham)
                                        @foreach ($ChiTietSanPham as $stt => $item)
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="radio">
                                                        <label><input type="radio" class="optradio" name="optradio" class="mr-2" {{ $stt == 0 ? 'checked' : '' }} value="{{ $item->id }}">
                                                            {{-- {{ number_format($item->giasanpham, 0, ',', '.') . ' VNĐ  (' . $item->tenquycach . ')' }} --}}
                                                            @if ($item->muckhuyenmai != null)
                                                                {{ number_format($item->giasanpham * (1 - $item->muckhuyenmai / 100), 0, ',', '.') . ' VNĐ - ' . $item->tenquycach . ' (-' . $item->muckhuyenmai . '%)' }}
                                                            @else
                                                                {{ number_format($item->giasanpham, 0, ',', '.') . ' VNĐ - ' . $item->tenquycach }}
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                                {{--  --}}
                                <div class="w-100"></div>
                                <form method="POST" action="{{ route('GioHang.addCartOnline') }}">
                                    @csrf
                                    <div class="col-md-6 d-flex mb-3">
                                        <input type="number" id="quantity" name="quantity" class="form-control input-number input240w " value="1" min="1">
                                    </div>
                                    <div class="col-md-6 d-flex mb-3">
                                        @isset($ChiTietSanPham)
                                            <input type="text" name="id_product_details" id="id_product_details" value="{{ $ChiTietSanPham[0]->id }}" hidden>
                                            <input type="submit" value="Thêm Vào Giỏ Hàng" class="btn btn-primary py-3 px-5">
                                        @endisset
                                    </div>
                                </form>
                            </div>
                        @endif

                    </div>
                @endisset
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-section-bottom">
        <div class="container">
            <div class="col-lg-8">
                <div class="border-product-reviews">
                    <h3 class="mb-4 billing-heading billing-heading-center">Đánh giá sản phẩm</h3>
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
                        @isset($DanhGia)
                            @if (Count($DanhGia) == null)
                                <div class="rating-total">0 đánh giá</div>
                            @else
                                <div class="rating-total">{{ Count($DanhGia) }} đánh giá</div>
                            @endif
                        @endisset
                    </div>
                    <hr style="border-top: 1px solid #c49b63;">
                    <div class="ratingLst">
                        @isset($DanhGia)
                            @if (Count($DanhGia) >= 1)
                                <div class="rating">
                                    <div class="review-name">{{ $DanhGia[0]->hoten }}</div>
                                    <div class="review-star">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($DanhGia[0]->sosao - $i >= 1) <i class="fas fa-star"></i>
                                            @else <i class="far fa-star"></i> @endif
                                        @endfor
                                        <samp class="review-time">{{ date_format(date_create($DanhGia[0]->thoigian), 'd/m/Y H:i:s') }}</samp>
                                    </div>
                                    <div class="review-comment">
                                        {{ $DanhGia[0]->noidung }}
                                    </div>
                                </div>
                                <hr style="border-top: 1px solid #c49b63;">
                            @endif
                            @if (Count($DanhGia) >= 2)
                                <div class="rating">
                                    <div class="review-name">{{ $DanhGia[1]->hoten }}</div>
                                    <div class="review-star">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($DanhGia[1]->sosao - $i >= 1) <i class="fas fa-star"></i>
                                            @else <i class="far fa-star"></i> @endif
                                        @endfor
                                        <samp class="review-time">{{ date_format(date_create($DanhGia[1]->thoigian), 'd/m/Y H:i:s') }}</samp>
                                    </div>
                                    <div class="review-comment">
                                        {{ $DanhGia[1]->noidung }}
                                    </div>
                                </div>
                                <hr style="border-top: 1px solid #c49b63;">
                            @endif
                        @endisset
                        <div class="review-button">
                            <div><a href="{{ route('SanPham.review', $SanPham->id) }}" class="btn btn-primary btn-outline-primary review-submit">Xem tất cả đánh giá</a></div>
                            <div><button onclick="formReview()" class="btn btn-primary review-submit">Viết đánh giá</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-section-bottom-2">
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
    <section class="ftco-section ftco-section-bottom">
        <div class="container">
            <div class="col-lg-8">
                <h3 class="mb-4 billing-heading billing-heading-center">Bình Luận</h3>
                <div class="form-comment">
                    <textarea name="" id="comment" cols="30" rows="3" class="form-control" placeholder="Mời bạn để lại bình luận..."></textarea>
                    <div class="d-flex justify-content-between motionsend">
                        <div class=""><a id="regulation" href="javascript:(0)">Quy định đăng bình luận</a></div>
                        <div class="">
                            <button onclick="informationForm()" class="btn btn-primary px-4">Gửi</button>
                        </div>
                    </div>
                </div>
                <div id="null-comment"><span class="lbMsgCmt"></span></div>
                <div class="d-flex justify-content-between midcmt">
                    <div class=""><samp>
                            @isset($CountBinhLuan)
                                {{ $CountBinhLuan }} Bình Luận
                            @endisset
                        </samp>
                    </div>
                    <div class="">
                        <form class="search-form">
                            @csrf
                            <div class="icon">
                                <button style="outline: none" type="submit" id="form-search" data-url="{{ route('binh-luan.userSearch') }}"><span class="icon-search"></span></button>
                            </div>
                            @isset($SanPham)
                                <input autocomplete="off" value="{{ $SanPham->id }}" name="id" type="text" hidden>
                            @endisset
                            <input autocomplete="off" type="text" name="keyword" class="cmtKey form-control" placeholder="Tìm theo nội dung, người gửi...">
                        </form>
                    </div>
                </div>
                <div class="comment">
                    @isset($BinhLuan)
                        @foreach ($BinhLuan as $item)
                            <hr style="border-top: 1px solid #c49b63;">
                            {{-- bình luận --}}
                            <div class="rowuser">
                                <img src="{{ asset('uploads/NhanVien/NOIMAGE.png') }}" alt="" style="width: 30px"> {{ $item->hoten }} -
                                {{ date_format(date_create($item->thoigian), 'd/m/Y H:i:s') }}
                            </div>
                            <div class="question">
                                {{ $item->noidung }}
                            </div>
                            <div class="actionuser">
                                <a class="reply" data-name="{{ $item->hoten }}" data-id="{{ $item->id }}" href="javascript:(0)">Trả lời</a>
                            </div>
                            {{-- danh sách trả lời --}}
                            <div class="listreply">
                                @isset($TraLoi)
                                    @foreach ($TraLoi as $itemreply)
                                        @if ($item->id == $itemreply->matraloi)
                                            {{-- <hr style="border-top: 1px solid #c49b63;"> --}}
                                            <div class="rowuserreply">
                                                @if ($itemreply->trangthai == 2)
                                                    <img src="{{ asset('uploads/Logo/logo_bling_coffee.png') }}" alt="" style="width: 30px">
                                                @else
                                                    <img src="{{ asset('uploads/NhanVien/NOIMAGE.png') }}" alt="" style="width: 30px">
                                                @endif {{ $itemreply->hoten }} -
                                                {{ date_format(date_create($itemreply->thoigian), 'd/m/Y H:i:s') }}
                                            </div>
                                            <div class="question">
                                                {{ $itemreply->noidung }}
                                            </div>
                                            <div class="actionuser">
                                                <a class="reply" data-name="{{ $itemreply->hoten }}" data-id="{{ $item->id }}" href="javascript:(0)">Trả lời</a>
                                            </div>
                                        @endif
                                    @endforeach
                                @endisset
                            </div>
                            {{-- form trả lời --}}
                            <div class="inputreply">
                                <div class="form-comment form-comment-reply" id="form-comment-{{ $item->id }}" style="display: none;">
                                    <textarea name="" id="comment-{{ $item->id }}" cols="30" rows="3" class="form-control" placeholder="Mời bạn để lại bình luận..."></textarea>
                                    <div class="d-flex justify-content-between motionsend">
                                        <div class=""><a href="javascript:(0)">Quy định đăng bình luận</a></div>
                                        <div class="">
                                            <button class="btn btn-primary px-4 form-reply" data-id="{{ $item->id }}">Gửi</button>
                                        </div>
                                    </div>
                                </div>
                                <div><span class="lbMsgCmtReply"></span></div>
                            </div>
                        @endforeach
                    @endisset
                </div>
                <hr style="border-top: 1px solid #c49b63;">
                @isset($SanPham)
                    <div><a href="{{ route('SanPham.comment', $SanPham->id) }}" class="btn btn-primary btn-outline-primary review-submit">Xem tất cả bình luận</a></div>
                @endisset
            </div>
        </div>
    </section>
@endsection
@section('modal')
    {{-- gửi bình luận --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button style="outline: none" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="datasanpham">
                    <div class="billing-form ftco-bg-dark p-3">
                        <form action="{{ route('binh-luan.create') }}" method="POST">
                            @csrf
                            <div class="col-lg-12">
                                <h3 class="mb-4 billing-heading billing-heading-center">Thông Tin Người Gửi</h3>
                                <div class="form-group">
                                    <label class="mr-3"><input type="radio" name="gioitinh" value="1" class="mr-2" required>Nam</label>
                                    <label><input type="radio" name="gioitinh" value="0" class="mr-2">Nữ</label>
                                </div>
                                <div class="form-group">
                                    {{-- <input autocomplete="off" type="text" name="hoten" class="form-control cfmInformationForm" placeholder="Họ tên (bắt buộc)" required> --}}
                                    <input type="text" name="hoten" class="form-control cfmInformationForm" placeholder="Họ tên (bắt buộc)" required>
                                </div>
                                <div class="form-group">
                                    {{-- <input autocomplete="off" name="email" type="email" class="form-control cfmInformationForm" placeholder="Email (để nhận phản hồi qua )" required> --}}
                                    <input name="email" type="email" class="form-control cfmInformationForm" placeholder="Email (để nhận phản hồi )" required>
                                </div>
                                <div class="form-group">
                                    <input autocomplete="off" name="noidung" id="noidung" type="text" class="form-control cfmInformationForm" required hidden>
                                    <input autocomplete="off" value="" name="matraloi" id="matraloi" type="text" class="form-control cfmInformationForm" hidden>
                                    @isset($SanPham)
                                        <input autocomplete="off" value="{{ $SanPham->id }}" name="id_sanpham" id="id_sanpham" type="text" class="form-control cfmInformationForm" required hidden>
                                    @endisset
                                </div>
                                <input type="submit" value="Gửi Bình Luận" class="btn btn-primary py-3 px-5" style="width: 100%;">
                            </div>
                        </form><!-- END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    {{-- quy định đăng bình luận --}}
    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button style="outline: none" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="dataxemsanpham">
                    <div class="billing-form ftco-bg-dark ftco-bg-dark-info p-3 p-md-5">
                        <h3 class="mb-4 billing-heading billing-heading-center">quy định đăng bình luận</h3>
                        <p style="margin: 7px 0px 35px 0px;">Bình luận sẽ không được duyệt khi:</p>
                        <p style="margin: 7px 0px;">- Thông tin viết giống nhau lặp đi lặp lại.</p>
                        <p style="margin: 7px 0px;">- Thông tin không liên quan gì đến nội dung của sản phẩm, dịch vụ cần bình luận.</p>
                        <p style="margin: 7px 0px;">- Thông tin xâm hại đến quyền lợi hoặc đời tư của người khác.</p>
                        <p style="margin: 7px 0px;">- Thông tin mang tính bài xích, gây tổn thương đến người khác.</p>
                        <p style="margin: 7px 0px;">- Thông tin có liên quan đến các hành vi tội phạm.</p>
                        <p style="margin: 7px 0px;">- Nhưng thông tin vi phạm đạo đức, thuần phong mỹ tục của Việt Nam và các nước khác.</p>
                        <p style="margin: 7px 0px;">- Thông tin có liên quan đến những việc nguy hiểm.</p>
                        <p style="margin: 7px 0px;">- Thông tin mang tính trục lợi, thương mại cá nhân, tuyên truyền quảng cáo.</p>
                        <p style="margin: 7px 0px;">- Thông tin liên quan đến chính trị, tôn giáo</p>
                        <p style="margin: 7px 0px;">- Đặt tên hoặc bình luận không rõ nội dung.</p>
                        <p style="margin: 7px 0px;">- Thông tin ảnh hưởng đến công việc kinh doanh của Bling Coffee.</p>
                        <p style="margin: 7px 0px;">- Những thông tin khác mà công ty chúng tôi cho rằng không hợp lý khi đăng tải lên Bling Coffee.</p>

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
        ///////////////////////////////////////// thay đổi quy cách.
        $('.optradio').on('change', function() { // thay đổi chi tiết sản phẩm
            var checkbox = document.getElementsByName("optradio");
            for (var i = 0; i < checkbox.length; i++) {
                if (checkbox[i].checked === true) {
                    $('#id_product_details').val(checkbox[i].value);
                }
            }
        });
        ///////////////////////////////////////// nhập 10 số.
        $(document).ready(function() { // nhập 10 số.
            $("#SDT").keypress(function() {
                if (this.value.length == 10) {
                    return false;
                }
            })
        });
        ///////////////////////////////////////// gửi bình luận.
        function informationForm() {
            var comment = $('#comment').val();
            if (comment != '') {
                $('#exampleModal').modal('show');
                $('#noidung').val(comment);
            } else {
                $('.lbMsgCmt').text('Vui lòng nhập nội dung');
            }
        }
        ///////////////////////////////////////// gửi trả lời bình luận.
        $(document).on('click', '.form-reply', function() {
            var id = $(this).data('id');
            var comment = $('#comment-' + id).val();
            if (comment != '') {
                $('#exampleModal').modal('show');
                $('#noidung').val(comment);
                $('#matraloi').val(id);
            } else {
                $('.lbMsgCmtReply').text('Vui lòng nhập nội dung');
            }
        });
        ///////////////////////////////////////// mởi form trả lời bình luận.
        $(document).on('click', '.reply', function() {
            var id = $(this).data('id');
            $('.form-comment-reply').hide();
            $('#form-comment-' + id).show();
            $('#comment-' + id).val('@' + $(this).data('name') + ': ');
            $('#comment-' + id).focus();
        });
        ///////////////////////////////////////// serach
        $('#form-search').on('click', function(e) { //tìm
            e.preventDefault(); // dừng  sự kiện submit.
            if ($("input[name='keyword']").val().length > 0) {
                $.ajax({
                    url: $(this).data('url'),
                    method: 'POST',
                    data: {
                        _token: $("input[name='_token']").val(),
                        keyword: $("input[name='keyword']").val(),
                        id: $("input[name='id']").val(),
                    },
                    success: function(response) {
                        $('.pagination').hide();
                        $("input[name='keyword']").val("");
                        $('.comment').html(response);
                        alertify.success("Đã Tìm");
                    },
                    error: function(response) {
                        alertify.error("Lỗi Tìm Kiếm");
                    }
                })
            }
        });
        ///////////////////////////////////////// quy định đăng bình luận.
        $('#regulation').on('click', function() {
            $('#exampleModal3').modal('show');
        });
        ///////////////////////////////////////// Mở form gửi đánh giá.
        function formReview() {
            $('#exampleModal4').modal('show');
        }
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
        })
    </script>
@endsection
