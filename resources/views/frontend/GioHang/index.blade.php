@extends('layouts.frontend_layout')
@section('content')
    <section class="home-slider owl-carousel">
        <div class="slider-item" style="background-image: url({{ asset('frontend/images/bg_3.jpg') }});" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center">
                    <div class="col-md-7 col-sm-12 text-center ftco-animate">
                        <h1 class="mb-3 mt-5 bread">GIỎ HÀNG</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('Trangchu.index') }}">Trang chủ</a></span> <span>GIỎ HÀNG</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (Session::has('GioHangOnline') != null)
        <section class="ftco-section ftco-cart mb_5">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-12 ftco-animate">
                        <div class="cart-list" id="cart-value">
                            <table class="table">
                                <thead class="thead-primary">
                                    <tr class="text-center">
                                        <th><a class="removed_all" href="javascript:(0)"><span class="icon-close icon-close-all"></span></th>
                                        <th>&nbsp;</th>
                                        <th>Sản Phẩm</th>
                                        <th>Giá Bán</th>
                                        <th>Số Lượng</th>
                                        <th>Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Session::get('GioHangOnline')->products as $item) {{-- danh sách sản phẩm --}}
                                        <tr class="text-center" id="{{ $item['CTSP']->id }}">
                                            <td class="product-remove"><a href="javascript:(0)" class="removed" data-id="{{ $item['CTSP']->id }}"
                                                    data-name="{{ $item['SanPham']->tensanpham . ' (' . $item['CTSP']->tenquycach . ')' }}">
                                                    <span class="icon-close"></span></a></td>
                                            <td class="image-prod">
                                                <div class="img" style="background-image:url({{ asset('uploads/SanPham/' . $item['SanPham']->hinhanh) }});"></div>
                                            </td>
                                            <td class="product-name product-name-left">
                                                <h3>{{ $item['SanPham']->tensanpham }}</h3>
                                                <span>{{ $item['CTSP']->tenquycach }}</span>
                                            </td>
                                            <td class="price">
                                                @if ($item['GiamGia'] > 0)
                                                    <p>{{ number_format($item['CTSP']->giasanpham - $item['GiamGia'], 0, ',', '.') . ' VNĐ' }}</p>
                                                    <span class="discount">{{ number_format($item['CTSP']->giasanpham, 0, ',', '.') . ' VNĐ' }}</span>
                                                @else
                                                    <p>{{ number_format($item['CTSP']->giasanpham, 0, ',', '.') . ' VNĐ' }}</p>
                                                @endif
                                            </td>
                                            <td class="quantity">
                                                <div class="input-group mb-3">
                                                    <input type="number" name="quantity" class="quantity form-control input-number" value="{{ $item['SoLuong'] }}" min="1"
                                                        data-id="{{ $item['CTSP']->id }}">
                                                </div>
                                            </td>
                                            <td class="total">{{ number_format($item['TongGia'] , 0, ',', '.') . ' VNĐ' }}</td>
                                        </tr><!-- END TR-->
                                    @endforeach
                                </tbody>
                            </table>
                            <p class="text-center"><a href="javascript:(0)" class="update-all btn btn-primary py-3 px-4">Cập Nhật Số Lượng</a></p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col col-lg-4 col-md-6 mt-5 cart-wrap ftco-animate">
                        <div class="cart-total mb-3"> {{-- danh sách sản phẩm --}}
                            <h3>Tổng Giỏ Hàng</h3>
                            <p class="d-flex">
                                <span>Tổng Tiền</span>
                                <span id="cart-totalPrice">{{ number_format(Session::get('GioHangOnline')->totalPrice, 0, ',', '.') . ' VNĐ' }}</span>
                            </p>
                            <p class="d-flex">
                                <span>Giảm Giá</span>
                                <span id="cart-totalDiscount">{{ number_format(Session::get('GioHangOnline')->totalDiscount, 0, ',', '.') . ' VNĐ' }}</span>
                            </p>
                            <hr>
                            <p class="d-flex total-price">
                                <span>Thành Tiền</span>
                                <span id="cart-Total">{{ number_format(Session::get('GioHangOnline')->Total, 0, ',', '.') . ' VNĐ' }}</span>
                            </p>
                        </div>
                        <p class="text-center"><a href="{{ route('GioHang.show') }}" class="btn btn-primary py-3 px-4">Tiến Hành Thanh Toán</a></p>
                    </div>
                </div>
                <div id="removed-value"></div>
            </div>

        </section>
    @else
        <div class="notproduct">
            <p style="font-family: 'Times New Roman';font-style:bolder">Giỏ Hàng không có sản phẩm</p>
            <p><a href="{{ route('SanPham.index') }}" class="btn btn-primary p-3 px-xl-4 py-xl-3">Mua ngay</a>
        </div>
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center pb-3">
                    <div class="col-md-7 heading-section ftco-animate text-center">
                        <span class="subheading">Khám phá</span>
                        <h2 class="mb-4">Cà phê bán chạy nhất hiện nay</h2>
                        <p>Cà phê là thức uống quen thuộc mỗi buổi sáng giúp tôi có thể cảm nhận được cả thế giới chuyển động
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
    @endif

@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/css.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/themes/default.min.css') }}">
@endsection
@section('script')
    <script src="{{ asset('frontend/alertifyjs/alertify.min.js') }}"></script>
    <script type="text/javascript">
        $('.removed_all').on('click', function() { // xóa  tất cả.
            if (confirm("Bỏ Tất Cả Sản Phẩm")) {
                $.ajax({
                    url: "/bo-tat-ca",
                    method: "POST",
                    data: {
                        _token: $("input[name='_token']").val(),
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
        $('.removed').on('click', function() { // xóa từng sản phẩm.
            var id = $(this).data('id');
            var name = $(this).data('name');
            if (confirm("Bỏ " + name)) {
                $.ajax({
                    url: "loai-bo-san-phan/" + id,
                    method: "POST",
                    data: {
                        _token: $("input[name='_token']").val(),
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
        $('.update-all').on('click', function() { // cập nhật số lượng sản phẩm.
            if (confirm("Cập Nhật Số Lượng")) {
                var lists = [];
                var test = 1;
                $('table tbody tr td').each(function() {
                    $(this).find('input').each(function() {
                        var element = {
                            id: $(this).data('id'),
                            sl: $(this).val()
                        };
                        lists.push(element);
                        if ($(this).val() < 1) {
                            test = 0;
                        }
                    });
                });
                if (test == 0) {
                    alertify.error('Số lượng không được nhỏ hơn 1');
                }
                if (test == 1) {
                    $.ajax({
                        url: "/cap-nhat-so-luong",
                        method: "POST",
                        data: {
                            _token: $("input[name='_token']").val(),
                            data: lists,
                        },
                        success: function(response) {
                            location.reload();
                        }
                    });
                }
            }
        });
    </script>
@endsection
