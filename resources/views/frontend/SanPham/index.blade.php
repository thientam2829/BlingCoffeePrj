@extends('layouts.frontend_layout')
@section('active_sanpham')
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
    {{-- lấy dữ liệu --}}
    <div id="dataproduct"></div>
    {{--  --}}
    <section class="home-slider owl-carousel">
        <div class="slider-item" style="background-image: url({{ asset('frontend/images/bg_3.jpg') }});" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center">

                    <div class="col-md-7 col-sm-12 text-center ftco-animate">
                        <h1 class="mb-3 mt-5 bread">SẢN PHẨM</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('Trangchu.index') }}">Trang Chủ</a></span>
                            <span>sản phẩm</span>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>
    {{--  --}}
    <section class="ftco-menu mb-5 pb-5">
        <div class="container">
            <div class="row d-md-flex">
                <div class="col-lg-12">
                    <div class="row">
                        {{-- tìm kiếm và lọc --}}
                        <div class="col-md-4 col-lg-3 ">
                            <div class="border-search category">
                                <div class="">
                                    <form action="{{ route('SanPham.search') }}" class="search-form" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="icon">
                                                <button style="outline: none" type="submit"><span class="icon-search"></span></button>
                                            </div>
                                            <input autocomplete="off" type="text" name="keyword" id="keyword" class="form-control" placeholder="Tìm Kiếm...">
                                        </div>
                                    </form>
                                </div>
                                <div class="">{{-- gắng cứng --}}
                                    <a href="{{ route('SanPham.tag', 'MỚI') }}"><button class="btn btn-primary btn-outline-primary btn-search">Mới</button></a>
                                </div>
                                <div class="">{{-- gắng cứng --}}
                                    <a href="{{ route('SanPham.tag', 'BÁN CHẠY NHẤT') }}"> <button class="btn btn-primary btn-outline-primary btn-search">Bán Chạy Nhất</button></a>
                                </div>
                                @if (isset($KhuyenMai))
                                    @if (count($KhuyenMai) > 0)
                                        <div class="">{{-- cần kiểm tra xem có khuyến mãi không --}}
                                            <a href="{{ route('SanPham.sale') }}"><button class="btn btn-primary btn-outline-primary btn-search">Khuyến Mãi</button></a>
                                        </div>
                                    @endif
                                @endif
                                @if (isset($LoaiSanPham))
                                    @if (count($LoaiSanPham) > 0)
                                        @foreach ($LoaiSanPham as $LSP)
                                            <div class="">{{-- vòng lập loại sản phẩm --}}
                                                <a href="{{ route('SanPham.filter', $LSP->id) }}"><button
                                                        class="btn btn-primary btn-outline-primary btn-search">{{ $LSP->tenloaisanpham }}</button></a>
                                            </div>
                                        @endforeach
                                    @endif
                                @endif
                                <div class="">{{-- thêm 1 đoạn cho nó khớp với khung hình --}}
                                    <h4 class="subheading-search">Cà Phê Nhé</h4>
                                    <p class="p-subheading-search">Một lời hẹn rất riêng của người Việt. Một lời ngỏ mộc mạc để mình ngồi
                                        lại bên nhau và sẻ chia câu chuyện của riêng mình.</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-md-8 col-lg-9"> {{-- thêm 1 cái id để khi tìm kiếm sẽ thay đổi nó --}}
                            @if (isset($Search))
                                <div class="row">{{-- phần của loại sản phẩm --}}
                                    @isset($keyword)
                                        <div class="col-md-12 heading-section ftco-animate text-center">
                                            <span class="subheading mb-4">Kết quả tìm kiếm cho "<b>{{ $keyword }}</b>"</span>{{-- tên khuyến mãi --}}
                                        </div>
                                    @endisset
                                    @foreach ($Search as $item)
                                        <div class="menu-t menu-t-2">
                                            <div class="menu-entry menu-entry-2">
                                                @isset($SanPhamKhuyenMai)
                                                    @foreach ($SanPhamKhuyenMai as $itemSPKM)
                                                        @if ($item->id == $itemSPKM->id)
                                                            <samp class="tag_khuyen_mai">KHUYẾN MÃI</samp>
                                                        @endif
                                                    @endforeach
                                                @endisset
                                                @if ($item->the == 'BÁN CHẠY NHẤT')
                                                    <samp class="tag_ban_chay_nhat">{{ $item->the }}</samp>
                                                @elseif($item->the == 'MỚI')
                                                    <samp class="tag_moi">{{ $item->the }}</samp>
                                                @endif
                                                <a href="{{ route('SanPham.show', $item->id) }}" class="img"
                                                    style="background-image: url({{ asset('uploads/SanPham/' . $item->hinhanh) }});"></a>
                                                <div class="text text-center pt-2">
                                                    <h3 class="a-name"><a href="{{ route('SanPham.show', $item->id) }}">{{ $item->tensanpham }}</a></h3>
                                                    <p class="price">
                                                        <span>{{ number_format($item->giasanpham, 0, ',', '.') . ' VNĐ' }}</span>
                                                    </p>
                                                    <div class="star">{{ $item->sosao }}
                                                        @for ($i = 0; $i < 5; $i++)
                                                            @if ($item->sosao - $i >= 1) <i class="fas fa-star"></i>
                                                            @elseif (($item->sosao - $i) >= 0.5)<i class="fas fa-star-half-alt"></i>
                                                            @else <i class="far fa-star"></i> @endif
                                                        @endfor
                                                    </div>
                                                    <p><a id="showProduct" data-id="{{ $item->id }}" href="javascript:(0)" class="btn btn-primary btn-outline-primary">Thêm Vào Giỏ Hàng</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif(isset($Filter))
                                <div class="row">{{-- phần của loại sản phẩm --}}
                                    @isset($keyword)
                                        <div class="col-md-12 heading-section ftco-animate text-center">
                                            <span class="subheading mb-4">Kết quả lọc cho "<b>{{ $keyword }}</b>"</span>{{-- tên khuyến mãi --}}
                                        </div>
                                    @endisset
                                    @foreach ($Filter as $item)
                                        <div class="menu-t menu-t-2">
                                            <div class="menu-entry menu-entry-2">
                                                @isset($SanPhamKhuyenMai)
                                                    @foreach ($SanPhamKhuyenMai as $itemSPKM)
                                                        @if ($item->id == $itemSPKM->id)
                                                            <samp class="tag_khuyen_mai">KHUYẾN MÃI</samp>
                                                        @endif
                                                    @endforeach
                                                @endisset
                                                @if ($item->the == 'BÁN CHẠY NHẤT')
                                                    <samp class="tag_ban_chay_nhat">{{ $item->the }}</samp>
                                                @elseif($item->the == 'MỚI')
                                                    <samp class="tag_moi">{{ $item->the }}</samp>
                                                @endif
                                                <a href="{{ route('SanPham.show', $item->id) }}" class="img"
                                                    style="background-image: url({{ asset('uploads/SanPham/' . $item->hinhanh) }});"></a>
                                                <div class="text text-center pt-2">
                                                    <h3 class="a-name"><a href="{{ route('SanPham.show', $item->id) }}">{{ $item->tensanpham }}</a></h3>
                                                    <p class="price">
                                                        <span>{{ number_format($item->giasanpham, 0, ',', '.') . ' VNĐ' }}</span>
                                                    </p>
                                                    <div class="star">{{ $item->sosao }}
                                                        @for ($i = 0; $i < 5; $i++)
                                                            @if ($item->sosao - $i >= 1) <i class="fas fa-star"></i>
                                                            @elseif (($item->sosao - $i) >= 0.5)<i class="fas fa-star-half-alt"></i>
                                                            @else <i class="far fa-star"></i> @endif
                                                        @endfor
                                                    </div>
                                                    <p><a id="showProduct" data-id="{{ $item->id }}" href="javascript:(0)" class="btn btn-primary btn-outline-primary">Thêm Vào Giỏ Hàng</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif(isset($Sale))
                                @foreach ($KhuyenMai as $item)
                                    <div class="row">{{-- phần của khuyến mãi --}}
                                        <div class="col-md-12 heading-section ftco-animate text-center">
                                            <span class="subheading mb-4">{{ $item->tenkhuyenmai }}</span>{{-- tên khuyến mãi --}}
                                            @if ($item->thoigianbatdau == $item->thoigianketthuc)
                                                <h3>Thời gian trong hôm nay {{ Date_format(Date_create($item->thoigianbatdau), 'd/m/Y') }}</h3>
                                            @else
                                                <h3>Thời gian từ ngày {{ Date_format(Date_create($item->thoigianbatdau), 'd/m/Y') }} đến ngày
                                                    {{ Date_format(Date_create($item->thoigianketthuc), 'd/m/Y') }}</h3>
                                            @endif
                                            <p class="mb-5">{{ $item->mota }}</p>
                                            {{-- nội dung --}}
                                        </div>
                                        @isset($Sale)
                                            @foreach ($Sale as $itemS)
                                                @if ($item->id == $itemS->id_khuyenmai)
                                                    <div class="menu-t menu-t-2">
                                                        <div class="menu-entry menu-entry-2">
                                                            <samp class="tag_khuyen_mai">KHUYẾN MÃI</samp>
                                                            @if ($itemS->the == 'BÁN CHẠY NHẤT')
                                                                <samp class="tag_ban_chay_nhat">{{ $itemS->the }}</samp>
                                                            @elseif($itemS->the == 'MỚI')
                                                                <samp class="tag_moi">{{ $itemS->the }}</samp>
                                                            @endif
                                                            <a href="{{ route('SanPham.show', $itemS->id) }}" class="img"
                                                                style="background-image: url({{ asset('uploads/SanPham/' . $itemS->hinhanh) }});"></a>
                                                            <div class="text text-center pt-2">
                                                                <h3 class="a-name"><a href="{{ route('SanPham.show', $itemS->id) }}">{{ $itemS->tensanpham }}</a></h3>
                                                                <p class="price">
                                                                    @isset($GiaSP)
                                                                        @foreach ($GiaSP as $itemGiaSP)
                                                                            @if ($itemS->id == $itemGiaSP->id)
                                                                                <span>{{ number_format($itemGiaSP->giasanpham, 0, ',', '.') . ' VNĐ' }}</span>
                                                                            @endif
                                                                        @endforeach
                                                                    @endisset
                                                                </p>
                                                                <div class="star">{{ $itemS->sosao }}
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        @if ($itemS->sosao - $i >= 1) <i class="fas fa-star"></i>
                                                                        @elseif (($itemS->sosao - $i) >= 0.5)<i class="fas fa-star-half-alt"></i>
                                                                        @else <i class="far fa-star"></i> @endif
                                                                    @endfor
                                                                </div>
                                                                <p><a id="showProduct" data-id="{{ $itemS->id }}" href="javascript:(0)" class="btn btn-primary btn-outline-primary">Thêm Vào Giỏ Hàng</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endisset
                                    </div>
                                @endforeach
                            @else
                                @isset($LoaiSanPham)
                                    @foreach ($LoaiSanPham as $item)
                                        <div class="row">{{-- phần của loại sản phẩm --}}
                                            <div class="col-md-12 heading-section ftco-animate text-center">
                                                <span class="subheading mb-4">{{ $item->tenloaisanpham }}</span>{{-- tên khuyến mãi --}}
                                            </div>
                                            @isset($SanPham)
                                                @foreach ($SanPham as $itemSP)
                                                    @if ($item->id == $itemSP->id_loaisanpham)
                                                        <div class="menu-t menu-t-2">
                                                            <div class="menu-entry menu-entry-2">
                                                                @isset($SanPhamKhuyenMai)
                                                                    @foreach ($SanPhamKhuyenMai as $itemSPKM)
                                                                        @if ($itemSP->id == $itemSPKM->id)
                                                                            <samp class="tag_khuyen_mai">KHUYẾN MÃI</samp>
                                                                        @endif
                                                                    @endforeach
                                                                @endisset
                                                                @if ($itemSP->the == 'BÁN CHẠY NHẤT')
                                                                    <samp class="tag_ban_chay_nhat">{{ $itemSP->the }}</samp>
                                                                @elseif($itemSP->the == 'MỚI')
                                                                    <samp class="tag_moi">{{ $itemSP->the }}</samp>
                                                                @endif
                                                                <a href="{{ route('SanPham.show', $itemSP->id) }}" class="img"
                                                                    style="background-image: url({{ asset('uploads/SanPham/' . $itemSP->hinhanh) }});"></a>
                                                                <div class="text text-center pt-2">
                                                                    <h3 class="a-name"><a href="{{ route('SanPham.show', $itemSP->id) }}">{{ $itemSP->tensanpham }}</a></h3>
                                                                    <p class="price">
                                                                        <span>{{ number_format($itemSP->giasanpham, 0, ',', '.') . ' VNĐ' }}</span>
                                                                    </p>
                                                                    <div class="star">{{ $itemSP->sosao }}
                                                                        @for ($i = 0; $i < 5; $i++)
                                                                            @if ($itemSP->sosao - $i >= 1) <i class="fas fa-star"></i>
                                                                            @elseif (($itemSP->sosao - $i) >= 0.5)<i class="fas fa-star-half-alt"></i>
                                                                            @else <i class="far fa-star"></i> @endif
                                                                        @endfor
                                                                    </div>
                                                                    <p><a id="showProduct" data-id="{{ $itemSP->id }}" href="javascript:(0)" class="btn btn-primary btn-outline-primary">Thêm Vào Giỏ Hàng</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endisset
                                        </div>
                                    @endforeach
                                @endisset
                            @endif
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
                <div class="modal-body" id="datasanpham">
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

        function showProduct(id) {
            $.ajax({
                url: "/hien-san-pham/" + id,
                method: "GET",
                success: function(data) {
                    $('#datasanpham').html(data);
                    $('#exampleModal').modal('show');
                    ChangeCTSP();
                    addCart();
                },
                errors: function(data) {
                    alertify.error("Lỗi Tải Trang");
                }
            })
        }
        $(document).on('click', '#showProduct', function() { // gọi edit.
            showProduct($(this).data('id'));
        });

        function ChangeCTSP() { // thay đổi chi tiết sản phẩm
            $('.optradio').on('change', function() {
                var checkbox = document.getElementsByName("optradio");
                for (var i = 0; i < checkbox.length; i++) {
                    if (checkbox[i].checked === true) {
                        $('#id_product_details').val(checkbox[i].value);
                    }
                }

            });
        }

        function addCart() { // thêm vào giỏ hàng và thông báo.
            $('#themvao').on('click', function(e) {
                $("#exampleModal").modal('hide');
                e.preventDefault(); // dừng  sự kiện submit.
                var quantity = $("input[name='quantity']").val();
                if (quantity < 1) {
                    alertify.error("Số lượng không được nhỏ hơn 1");
                };
                if (quantity > 0) {
                    $.ajax({
                        url: '/them-vao-gio',
                        method: 'POST',
                        data: {
                            _token: $("input[name='_token']").val(),
                            quantity: $("input[name='quantity']").val(),
                            id_product_details: $("input[name='id_product_details']").val(),
                        },
                        // cart-quantity
                        success: function(response) {
                            $("#dataproduct").html(response);
                            $('#cart-quantity').text($('#soluongsanpham').val());
                            alertify.message($('#noidungthongbao').val());
                        },
                        error: function(response) {
                            alertify.error("Lỗi Thêm Vào Giỏ Hàng");
                        }
                    });
                };
            });
        }
    </script>
@endsection
