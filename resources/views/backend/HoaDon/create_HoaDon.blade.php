@extends('layouts.backend_layout')
@section('active_laphoadon')
    class="nav-item active"
@endsection
@section('content')
    {{-- thông báo --}}
    @if (session('message'))
        <input type="text" class="Message-message" id="Message-message" value="{{ session('message') }}" hidden>
    @endif
    @if (session('warning'))
        <input type="text" class="Warning_message" id="Warning_message" value="{{ session('warning') }}" hidden>
    @endif
    <div class="main_content_iner ">
        <div class="btn-pm">
            <div class="mb-3 btn-1">
                <a class="btn btn-success" onclick="showModalAddProduct()" href="javascript:(0)"><span class="btn-label"></span>Thêm Sản Phẩm</a>
            </div>
        </div>
        <div class="row" style="justify-content: flex-end;">
            <div class="col-lg-12">
                <div class="card QA_section border-0">
                    <div class="card-body QA_table ">
                        {{-- Item sản phẩm --}}
                        <div class="table-responsive shopping-cart " id="itemHoaDon">
                            <table class="table mb-0" style="text-align: right">
                                <thead>
                                    <tr>
                                        <th class="border-top-0" style="text-align: left">Sản Phẩm</th>
                                        <th class="border-top-0">Giá Bán</th>
                                        <th class="border-top-0">Giảm Giá</th>
                                        <th class="border-top-0">Số Lượng</th>
                                        <th class="border-top-0">Tổng Cộng</th>
                                        <th class="border-top-0" style="text-align: center">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody id="value-update-all">
                                    @if (Session::has('GioHang') != null)
                                        @foreach (Session::get('GioHang')->products as $item)
                                            <tr>
                                                <td style="text-align: left"><img src="{{ asset('uploads/SanPham/' . $item['SanPham']->hinhanh) }}" alt="image" width="60" height="60">
                                                    <p style="padding-left: 10px" class="d-inline-block align-middle mb-0 f_s_19 f_w_700 color_theme2">
                                                        {{ $item['SanPham']->tensanpham }}<br><span class="text-muted font_s_13">{{ $item['CTSP']->tenquycach }}</span>
                                                    </p>
                                                </td>
                                                <td>{{ number_format($item['CTSP']->giasanpham, 0, ',', '.') }} VNĐ
                                                </td>
                                                <td>
                                                    @if ($item['GiamGia'] > 0)
                                                        {{ number_format($item['GiamGia'], 0, ',', '.') }} VNĐ
                                                    @else

                                                    @endif
                                                </td>
                                                <td style="width: 70px;padding-left: 30px;"><input id="SoLuongSanPham" data-id="{{ $item['CTSP']->id }}" type="number" class="form-control"
                                                        value="{{ $item['SoLuong'] }}">
                                                </td>
                                                <td>{{ number_format($item['TongGia'], 0, ',', '.') }} VNĐ</td>
                                                <td style="text-align: center">
                                                    <a href="javascript:(0)" data-id="{{ $item['CTSP']->id }}" class="action_btn deleteItemHoaDon">
                                                        <i class="fas fa-times-circle"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            @if (Session::has('GioHang') != null)
                                <hr>
                                <div class="d-flex mt_10 justify-content-center">
                                    <p class="text-center"><a href="javascript:(0)" id="update-all" class="btn btn-warning mr_10">Cập Nhật Số Lượng</a></p>
                                    <p class="text-center"><a href="javascript:(0)" id="delete-all" class="btn btn-warning mr_10">Xóa Tất Cả</a></p>
                                    <p class="text-center"><a href="javascript:(0)" onclick="showModalAddMember()" id="add-member" class="btn btn-warning">Tìm Khách Mua Hàng</a></p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5  mt_30">{{-- Tổng Tiền --}}
                <div class="total-payment p-3">
                    <h3 class="header-title">Tổng Cộng</h3>
                    <table class="table">
                        @if (Session::has('GioHang') != null)
                            <tbody id="TienHangTT">
                                <tr>
                                    <td class="payment-title">Số Lượng</td>
                                    <td id="totalQuanty">
                                        {{ number_format(Session::get('GioHang')->totalQuanty, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="payment-title">Giá Bán</td>
                                    <td id="totalPriceCart">
                                        {{ number_format(Session::get('GioHang')->totalPrice, 0, ',', '.') . ' VNĐ' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="payment-title">Giảm Giá</td>
                                    <td id="totalDiscountCart">
                                        {{ number_format(Session::get('GioHang')->totalDiscount, 0, ',', '.') . ' VNĐ' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="payment-title">Giảm Giá Thành Viên</td>
                                    <td id="DiscountMemberCart">
                                        {{ number_format(Session::get('GioHang')->DiscountMember, 0, ',', '.') . ' VNĐ' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="payment-title">Thành Tiền</td>
                                    <td class="text-dark">
                                        <strong id="TotalCart">{{ number_format(Session::get('GioHang')->Total, 0, ',', '.') . ' VNĐ' }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a class="btn btn-success" id="InHD" href="{{ route('hoa-don.in') }}">Tiến Hành Thanh Toán</a>
                                    </td>
                                </tr>
                            </tbody>
                        @else
                            <tbody id="TienHangTT" style="display: none;">
                                <tr>
                                    <td class="payment-title">Số Lượng</td>
                                    <td id="totalQuanty"></td>
                                </tr>
                                <tr>
                                    <td class="payment-title">Giá Bán</td>
                                    <td id="totalPriceCart"></td>
                                </tr>
                                <tr>
                                    <td class="payment-title">Giảm Giá</td>
                                    <td id="totalDiscountCart"></td>
                                </tr>
                                <tr>
                                    <td class="payment-title">Giảm Giá Thành Viên</td>
                                    <td id="DiscountMemberCart"></td>
                                </tr>
                                <tr>
                                    <td class="payment-title">Thành Tiền</td>
                                    <td class="text-dark"><strong id="TotalCart"></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a id="InHD" class="btn btn-success" href="{{ route('hoa-don.in') }}">Tiến Hành Thanh Toán</a>
                                    </td>
                                </tr>
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    {{-- modal thêm sản phẩm --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Thêm Sản Phẩm</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="filterloai" id="filterloai">
                                                <option value="all">Tất Cả Loại Sản Phẩm</option>
                                                @if (isset($LoaiSanPham))
                                                    @foreach ($LoaiSanPham as $valuelsp)
                                                        <option value="{{ $valuelsp->id }}">{{ $valuelsp->tenloaisanpham }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="serach_field-area d-flex align-items-center mb-3">
                                            <div class="search_inner">
                                                <div class="search_field">
                                                    <input type="text" name="keyword" placeholder="Tên..." id="keyword">
                                                </div>
                                                <button type="submit" onclick="search()"> <img src="{{ asset('backend/img/icon/icon_search.svg') }}" alt="">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Sản Phẩm</th>
                                <th scope="col" style="text-align: center">Quy Cách</th>
                                <th scope="col" style="text-align: center">Giá Bán</th>
                                <th scope="col" style="text-align: center">Giảm Giá</th>
                                <th scope="col" style="text-align: center">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody id="listProduct">
                            @if (isset($SanPham))
                                @foreach ($SanPham as $item)
                                    <tr>
                                        <td><img src="{{ asset('uploads/SanPham/' . $item->hinhanh) }}" alt="image" height="60" width="60">
                                            <p class="d-inline-block align-middle mb-0 f_s_19 f_w_700 color_theme2" style="padding-left: 10px">{{ $item->tensanpham }}</p>
                                        </td>
                                        <td>
                                            <select onchange="kichthuoc(this,'{{ $item->id }}')" data-ia="{{ $item->id }}" class="form-control">
                                                <option value="0">Chọn Quy Cách</option>
                                                @if (isset($ChiTietSanPham))
                                                    @foreach ($ChiTietSanPham as $itemCTHD)
                                                        @if ($itemCTHD->id_sanpham == $item->id)
                                                            <option value="{{ $itemCTHD->id }}">
                                                                {{ $itemCTHD->tenquycach }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td style="text-align: center" id="giaban{{ $item->id }}"></td>
                                        <td style="text-align: center" id="giamgia{{ $item->id }}"></td>
                                        <td style="text-align: center"><a href="javascript:(0)" id="them{{ $item->id }}" class="action_btn">
                                                <i class="fas fa-plus-circle"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    {{-- Tìm khách mua hàng --}}
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Tìm Khách Mua Hàng</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="serach_field-area d-flex align-items-center serach_member mb-3">
                        <div class="search_inner">
                            <div class="search_field">
                                <input type="number" name="sdtmember" placeholder="Số Điện Thoại Khách Mua Hàng..." id="sdtmember">
                            </div>
                            <button type="submit" onclick="searchMember()"> <img src="{{ asset('backend/img/icon/icon_search.svg') }}" alt="">
                            </button>
                        </div>
                    </div>
                    <div id="KhachMuaHang"></div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    {{-- Thêm khách hàng mới --}}
    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Thêm khách hàng</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input hidden type="number" class='form-control' name="diemtichluy" value="0" required>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <label>Trạng Thái </label>
                                        <input type="checkbox" name="trangthai" value='1' class="form-check-input" checked="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Họ Tên<b style="color:red"> *</b></label>
                                    <input type="int" class='form-control' maxlength="50" name="tenkhachhang" required>
                                </div>
                                <div class="form-group">
                                    <label>Số Điện Thoại<b style="color:red"> *</b></label>
                                    <input type="number" class='form-control' id="SDT" name="sdt" required>
                                </div>
                                <div class="form-group">
                                    <label>Email<b style="color:red"> *</b></label>
                                    <input type="email" class='form-control' name="email" required>
                                </div>
                                <div class="form-group">
                                    <label>Địa Chỉ<b style="color:red"> *</b></label>
                                    <textarea type="text" class='form-control' maxlength="150" name="diachi" required></textarea>
                                </div>
                                <button id="form-create" data-url="{{ route('khach-hang.store') }}" type="submit" class="btn btn-success" style="width: 100%">Thêm</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/themes/default.min.css') }}">
    <style>
        .serach_field-area.d-flex.align-items-center.serach_member.mb-3 {
            margin-left: 190px;
        }

    </style>
@endsection
@section('script')
    <script src="{{ asset('frontend/alertifyjs/alertify.min.js') }}"></script>
    <script type="text/javascript">
        window.onload = function() {
            if ($('#Message-message').hasClass('Message-message')) {
                alertify.message($('#Message-message').val());
            }
            if ($('#Warning_message').hasClass('Warning_message')) {
                alertify.warning($('#Warning_message').val());
            }
        };

        function showModalAddProduct() { // Hiện modal thêm san phẩm.
            $('#exampleModal').modal('show');
        }

        function kichthuoc(obj, idSP) { // Lấy ra giá sản phẩm và khuyến mãi dựa vào kích thước.
            var value = obj.value;
            $.ajax({ // ajax lấy giá bán và gắn sự kiện onlick addcart().
                url: "priceProduct/" + value,
                method: "GET",
                success: function(data) {
                    $('#giaban' + idSP).html(data);
                    $('#them' + idSP).attr("onclick", "addcart('" + value + "')");
                },
                errors: function(data) {
                    alertify.error("Lỗi Tải Dữ Liệu");
                }
            })
            $.ajax({ //ajax lấy khuyến mãi.
                url: "discountProduct/" + value,
                method: "GET",
                success: function(data) {
                    $('#giamgia' + idSP).html(data);
                },
                errors: function(data) {
                    alertify.error("Lỗi Tải Dữ Liệu");
                }
            })
        }

        function addcart(id) { // thêm sản phẩm vào giỏ hàng.
            $.ajax({
                url: "addCart/" + id,
                method: "GET",
                success: function(data) {
                    LoadTotal(data);
                    alertify.success('Đã Thêm');
                },
                errors: function(data) {
                    alertify.error("Lỗi Thêm Vào Giỏ Hàng");
                }
            })
        }

        function UpdateAll() {
            $('#update-all').on('click', function() { // cập nhật số lượng sản phẩm.
                if (confirm("Cập Nhật Số Lượng")) {
                    var lists = [];
                    var test = 1;
                    $('#value-update-all tr td').each(function() {
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
                            url: "quantityChange",
                            method: "GET",
                            data: {
                                data: lists,
                            },
                            success: function(response) {
                                LoadTotal(response);
                                alertify.success("Đã Cập Nhật Số Lượng");
                            },
                            error: function(response) {
                                alertify.error("Không Thể Cập Nhật");
                            }
                        });
                    }
                }
            });
        }
        UpdateAll(); // luôn gọi 

        function DeleteAll() {
            $('#delete-all').on('click', function() {
                if (confirm("Xóa Tất Cả")) {
                    $.ajax({
                        url: "deleteHoaDon",
                        method: "POST",
                        data: {
                            _token: $("input[name='_token']").val(),
                        },
                        success: function(response) {
                            LoadTotal(response);
                            alertify.success("Đã Xóa Tất Cả");
                        },
                        error: function(response) {
                            alertify.error("Không Thể Xóa");
                        }
                    });
                };
            });
        };
        DeleteAll();

        $("#itemHoaDon").on("click", ".deleteItemHoaDon", function() { // xóa sản phẩm trong giỏ hàng.
            if (confirm("Xóa Bỏ")) {
                $.ajax({
                    url: "deleteItemHoaDon/" + $(this).data("id"),
                    method: "GET",
                    success: function(data) {
                        LoadTotal(data);
                        alertify.success('Đã Bỏ Sản Phẩm');
                    },
                    errors: function(data) {
                        alertify.error("Lỗi Bỏ Sản Phẩm");
                    }
                })
            }
        });

        function LoadTotal(data) { //cập nhật giao diện.
            $('#itemHoaDon').html(data);
            $('#totalPriceCart').text($('#tongcong').val() + " VNĐ");
            $('#totalDiscountCart').text($('#giamgia').val() + " VNĐ");
            $('#DiscountMemberCart').text($('#giamgiathanhvien').val() + " VNĐ");
            $('#TotalCart').text($('#thanhtien').val() + " VNĐ");
            $('#totalQuanty').text($('#soluong').val());
            UpdateAll();
            DeleteAll();
            $('#TienHangTT').show();
            if ($('#tongcong').val() == 0) {
                $('#totalPriceCart').text("");
                $('#totalDiscountCart').text("");
                $('#DiscountMemberCart').text("");
                $('#TotalCart').text("");
                $('#totalQuanty').text("");
                $('#TienHangTT').hide();
                $('#boapdung').hide();
                $('#apdung').show();
            }
        };

        function search() { // ajax tìm sản phẩm.
            var keyword = $('#keyword').val();
            $.ajax({
                url: "searchProduct",
                method: "GET",
                data: {
                    keyword: keyword
                },
                success: function(data) {
                    $('#listProduct').html(data);
                    $('#keyword').val("");
                    alertify.success('Đã Tìm');
                },
                errors: function(data) {
                    alertify.error("Lỗi Tìm Kiếm");
                }
            })
        }

        function showModalAddMember() { // Hiện modal tìm khách mua hàng.
            $("#sdtmember").keypress(function() {
                if (this.value.length == 10) {
                    return false;
                }
            })
            $('#exampleModal2').modal('show');
        };

        function searchMember() {
            var sdt = $('#sdtmember').val();
            $.ajax({
                url: "searchCustomer/",
                method: "GET",
                data: {
                    sdt: sdt
                },
                success: function(response) {
                    $('#KhachMuaHang').html(response);
                    alertify.success('Đã Tìm');
                    $(document).ready(function() {
                        $("#sdtmember").keypress(function() {
                            if (this.value.length == 10) {
                                return false;
                            }
                        })
                    });
                },
                error: function(response) {
                    alertify.error("Lỗi Tìm Kiếm");
                }
            })
        };

        function apdung(sdt) {
            $.ajax({
                url: "discountMember/",
                method: "GET",
                data: {
                    sdt: sdt
                },
                success: function(response) {
                    $('#apdung').hide();
                    $('#boapdung').show();
                    LoadTotal(response);
                    alertify.success("Đã áp dụng giảm giá thành viên");
                },
                error: function(response) {
                    alertify.error("Không thể áp dụng giảm giá thành viên");
                }
            })
        };

        function boapdung() {
            $.ajax({
                url: "unDiscountMember/",
                method: "GET",
                success: function(response) {
                    $('#boapdung').hide();
                    $('#apdung').show();
                    LoadTotal(response);
                    alertify.success("Đã bỏ áp dụng giảm giá thành viên");
                },
                error: function(response) {
                    alertify.error("Không thể bỏ áp dụng giảm giá thành viên");
                }
            })
        }

        function themkh() { // Hiện modal tìm khách mua hàng.
            $("#SDT").keypress(function() {
                if (this.value.length == 10) {
                    return false;
                }
            })
            $('#SDT').val($('#sdtmember').val());
            $('#exampleModal3').modal('show');
            Store();
        };

        function Store() { // thêm khách hàng.
            $('#form-create').on('click', function(e) {
                e.preventDefault(); // dừng  sự kiện submit.
                $.ajax({
                    url: $(this).data('url'),
                    method: 'POST',
                    data: {
                        _token: $("input[name='_token']").val(),
                        trangthai: $('input[name = "trangthai"]:checked').length,
                        sdt: $("input[name='sdt']").val(),
                        email: $("input[name='email']").val(),
                        tenkhachhang: $("input[name='tenkhachhang']").val(),
                        diemtichluy: $("input[name='diemtichluy']").val(),
                        diachi: $("textarea[name='diachi']").val(),
                    },
                    success: function(response) {
                        if (response.errors) {
                            alert(response.errors);
                        } else {
                            $("#exampleModal3").modal('hide');
                            alertify.success(response.success);
                            searchMember();
                        }
                    },
                    error: function(response) {
                        alertify.error("Lỗi Thêm Khách Hàng Mới");
                    }
                })
            })
        };

        $('#InHD').on('click', function() { // in hóa đơn.
            if (confirm("Thanh Toán")) {
                return true;
            }
            return false;
        });

        /////////////////////////////////////////////////////////////////////////////////////////// lọc
        function filter() {
            $.ajax({
                url: '/admin/hoa-don/filter-product',
                method: 'GET',
                data: {
                    filterloai: $('#filterloai').val(),
                },
                success: function(response) {
                    // $("#ModalFilter").modal('hide');
                    // $('.pagination').hide();
                    $('#listProduct').html(response);
                    alertify.success("Đã Lọc");
                },
                error: function(response) {
                    alertify.error("Lỗi Lọc Dữ Liệu");
                }
            })
        }
        $(document).on('change', '#filterloai', function() {
            filter();
        });
    </script>
@endsection
