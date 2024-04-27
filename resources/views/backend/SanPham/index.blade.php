@extends('layouts.backend_layout')
@section('active_quanlysanpham')
    class="nav-item active"
@endsection
@section('content')
    <div class="main_content_iner ">
        {{-- header --}}
        <div class="btn-pm d-flex justify-content-between">
            <div class="mb-3 btn-1">
                <a class="btn btn-success" href="{{ route('san-pham.create') }}">Thêm Sản Phẩm</a>
                <a class="btn btn-info" href="{{ route('loai-san-pham.index') }}">Xem Loại Sản Phẩm</a>
                <a class="btn btn-danger" href="{{ route('san-pham.expiredProduct') }}">SP Hết Hạn Sử Dụng
                    <span class="badge bg-warning text-dark countSanPhamHetHanSuDung"></span>
                </a>
                <a class="btn btn-warning" href="{{ route('san-pham.outOfProduct') }}">SP Hết Hàng
                    <span class="badge bg-danger countSanPhamHetHang"></span>
                </a>
                <a id="formfilter" class="btn btn-primary" href="javascript:(0)">Lọc & Sắp Xếp</a>
            </div>
            <div class="serach_field-area d-flex align-items-center mb-3">
                <div class="search_inner">
                    <form method="GET">
                        <div class="search_field">
                            <input type="text" placeholder="Tìm tên, loại, thẻ..." name="search">
                        </div>
                        <button id="form-search" data-url="{{ route('san-pham.search') }}" type="submit">
                            <img src="{{ asset('backend/img/icon/icon_search.svg') }}" alt=""></button>
                    </form>
                </div>
            </div>
        </div>
        {{-- content --}}
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_card">
                        <div class="white_card_header">
                            <div class="main-title">
                                <h2 class="m-0">Danh Sách Sản Phẩm</h2>
                            </div>
                        </div>
                        <div class="white_card_body">
                            {{-- thông báo thành công --}}
                            @if (session('success'))
                                <input type="text" class="alert-success" id="alert-success" value="{{ session('success') }}" hidden>
                            @endif
                            {{-- data sheet --}}
                            <div class="table-responsive">
                                <table class="table" style="text-align: center">
                                    <thead>
                                        <tr>
                                            {{-- <th scope="col" style="text-align: left">#</th> --}}
                                            <th scope="col" style="text-align: left">Hình Ảnh</th>
                                            <th scope="col">Tên Sản Phẩm</th>
                                            <th scope="col">Thẻ</th>
                                            <th scope="col">Loại Sản Phẩm</th>
                                            <th scope="col">Trạng Thái</th>
                                            <th scope="col">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataSheet">
                                        @if (isset($SanPham))
                                            @foreach ($SanPham as $value)
                                                <tr id="{{ $value->id }}">
                                                    {{-- <td style="text-align: left">{{ $value->id }}</td> --}}
                                                    <td style="text-align: left"><img src="{{ asset('uploads/SanPham/' . $value->hinhanh) }}" style="width: 100px; height: 100px; border-radius: 5px;">
                                                    </td>
                                                    <td>{{ $value->tensanpham }}</td>
                                                    <td>{{ $value->the }}</td>
                                                    <td>
                                                        @if (isset($LoaiSanPham))
                                                            @foreach ($LoaiSanPham as $valuelsp)
                                                                @if ($value->id_loaisanpham == $valuelsp->id)
                                                                    {{ $valuelsp->tenloaisanpham }}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge {{ $value->trangthai == 1 ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $value->trangthai == 1 ? 'Đang Bán' : 'Ngừng Bán' }}</span>
                                                    </td>
                                                    <td>
                                                        {{-- <div class="d-flex"> --}}
                                                            <a href="javascript:(0)" class="action_btn mr_10 view-add" data-url="{{ route('chi-tiet-san-pham.create', $value->id) }}"
                                                                data-id="{{ $value->id }}"><i class="fas fa-plus-square"></i></a>

                                                            <a href="javascript:(0)" class="action_btn mr_10 view-show" data-url="{{ route('san-pham.show', $value->id) }}"
                                                                data-id="{{ $value->id }}">
                                                                <i class="fas fa-eye"></i></a>

                                                            <a href="{{ route('san-pham.edit', $value->id) }}" class="action_btn mr_10"><i class="fas fa-edit"></i></a>

                                                            <a href="javascript:(0)" class="action_btn mr_10 form-delete" data-url="{{ route('san-pham.destroy', $value->id) }}"
                                                                data-id="{{ $value->id }}">
                                                                <i class="fas fa-trash-alt"></i></a>
                                                        {{-- </div> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if (isset($SanPham))
                                {{-- pagination --}}
                                <div class='col-12 d-flex justify-content-center' style='padding: 15px'>
                                    {{ $SanPham->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    {{-- modal 500px --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Tiêu Đề</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    {{-- modal 1140px --}}
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel2">Tiêu Đề</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-2">

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    {{-- filter --}}
    <div class="modal fade" id="ModalFilter" tabindex="-1" role="dialog" aria-labelledby="ModalFilterLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="ModalFilterLabel">Lọc & Sắp Xếp</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Trạng Thái</label>
                                <select class="form-control" name="filtertrangthai" id="filtertrangthai">
                                    <option value="all">Tất Cả</option>
                                    <option value="on">Đang Bán</option>
                                    <option value="off">Ngừng Bán</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Thẻ</label>
                                <select class="form-control" name="filterthe" id="filterthe">
                                    <option value="0">Tất Cả</option>
                                    <option value="1">THƯỜNG</option>
                                    <option value="2">MỚI</option>
                                    <option value="3">BÁN CHẠY NHẤT</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Loại Sản Phẩm</label>
                                <select class="form-control" name="filterloai" id="filterloai">
                                    <option value="all0">Tất Cả</option>
                                    @if (isset($LoaiSanPham))
                                        @foreach ($LoaiSanPham as $valuelsp)
                                            <option value="{{ $valuelsp->id }}">{{ $valuelsp->tenloaisanpham }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sắp Xếp</label>
                                <select class="form-control" name="sort" id="sort">
                                    <option value="19">Thời Gian Tạo Giảm Dần</option>
                                    <option value="29">Thời Gian Tạo Tăng Dần</option>
                                </select>
                            </div>
                            <button onclick="filter()" class="btn btn-success" style="width: 100%">Tiến Hành</button>
                        </div>
                    </div>
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
@endsection
@section('script')
    <script src="{{ asset('frontend/alertifyjs/alertify.min.js') }}"></script>
    <script type="text/javascript">
        window.onload = function() { // hiện Thông báo.
            if ($('#alert-success').hasClass('alert-success')) {
                alertify.success($('#alert-success').val());
            }
        };

        function countSanPhamHetHanSuDung() {
            $.ajax({
                url: '/admin/san-pham/so-luong-het-han-su-dung',
                method: 'GET',
                success: function(data) {
                    if (data != 0) {
                        $('.countSanPhamHetHanSuDung').text(data);
                    } else {
                        $('.countSanPhamHetHanSuDung').text("");

                    }
                }
            });
        };
        countSanPhamHetHanSuDung();

        function countSanPhamHetHang() {
            $.ajax({
                url: '/admin/san-pham/so-luong-het-hang',
                method: 'GET',
                success: function(data) {
                    if (data != 0) {
                        $('.countSanPhamHetHang').text(data);
                    } else {
                        $('.countSanPhamHetHang').text("");

                    }
                }
            });
        };
        countSanPhamHetHang();

        function Money() { // định dạng tiền.
            (function($) {
                $.fn.simpleMoneyFormat = function() {
                    this.each(function(index, el) {
                        var elType = null; // input or other
                        var value = null;
                        // get value
                        if ($(el).is('input') || $(el).is('textarea')) {
                            value = $(el).val().replace(/,/g, '');
                            elType = 'input';
                        } else {
                            value = $(el).text().replace(/,/g, '');
                            elType = 'other';
                        }
                        // if value changes
                        $(el).on('paste keyup', function() {
                            value = $(el).val().replace(/,/g, '');
                            formatElement(el, elType, value); // format element
                        });
                        formatElement(el, elType, value); // format element
                    });

                    function formatElement(el, elType, value) {
                        var result = '';
                        var valueArray = value.split('');
                        var resultArray = [];
                        var counter = 0;
                        var temp = '';
                        for (var i = valueArray.length - 1; i >= 0; i--) {
                            // kiểm tra nếu nó là số thì cộng vào.
                            if (!isNaN(valueArray[i]) && valueArray[i] != " ") {
                                temp += valueArray[i];
                                counter++
                                if (counter == 3) {
                                    resultArray.push(temp);
                                    counter = 0;
                                    temp = '';
                                }
                            }
                        };
                        if (counter > 0) {
                            resultArray.push(temp);
                        }
                        for (var i = resultArray.length - 1; i >= 0; i--) {
                            var resTemp = resultArray[i].split('');
                            for (var j = resTemp.length - 1; j >= 0; j--) {
                                result += resTemp[j];
                            };
                            if (i > 0) {
                                result += '.'
                            }
                        };
                        if (elType == 'input') {
                            $(el).val(result);
                        } else {
                            $(el).empty().text(result);
                        }
                    }
                };
            }(jQuery));

            $('.money').simpleMoneyFormat(); // áp dụng cho class money.
        }

        function Store() { // thêm chi tiết.
            $('#form-create').on('click', function(e) {
                e.preventDefault(); // dừng  sự kiện submit.
                var url = "san-pham/" + $("input[name='id_sanpham']").val() + "/show"
                $.ajax({
                    url: $(this).data('url'),
                    method: 'POST',
                    data: {
                        _token: $("input[name='_token']").val(),
                        trangthai: $('input[name = "trangthai"]:checked').length,
                        kichthuoc: $("select[name='kichthuoc']").val(),
                        soluong: $("input[name='soluong']").val(),
                        giasanpham: $("input[name='giasanpham']").val(),
                        ngaysanxuat: $("input[name='ngaysanxuat']").val(),
                        hansudung: $("input[name='hansudung']").val(),
                        id_sanpham: $("input[name='id_sanpham']").val(),
                    },
                    success: function(response) {
                        if (response.errors) {
                            alert(response.errors);
                        } else {
                            countSanPhamHetHanSuDung();
                            countSanPhamHetHang();
                            countSanPhamCanXuLy();
                            $("#exampleModal").modal('hide');
                            alertify.success(response.success);
                            Show(url);
                        }
                    },
                    error: function(response) {
                        alertify.error("Lỗi Thêm Mới");
                    }
                })
            })
        };

        function Add(url, id) { // trang thêm chi tiết.
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    $('#modal-body').html(response);
                    $("#exampleModalLabel").text("Thêm Chi Tiết Sản Phẩm");
                    $("#exampleModal").modal('show');
                    Money();
                    Store();
                },
                error: function(response) {

                    alertify.error("Lỗi Tải Trang");
                }
            })
        };
        $(document).on('click', '.view-add', function() { // gọi add.
            Add($(this).data('url'), $(this).data('id'));
        });

        function Show(url) { // trang chi tiết sản phẩm.
            $.ajax({
                url: url,
                method: 'GET',
                data: {},
                success: function(response) {

                    $('#modal-body-2').html(response);
                    $("#exampleModalLabel2").text("Chi Tiết Sản Phẩm");
                    $("#exampleModal2").modal('show');
                },
                error: function(response) {

                    alertify.error("Lỗi Tải Trang");
                }
            })
        };
        $(document).on('click', '.view-show', function() { // gọi show.
            Show($(this).data('url'));
        });

        function Delete(url, id) { // xóa.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#' + id).html("");
                    countSanPhamHetHanSuDung();
                    countSanPhamHetHang();
                    countSanPhamCanXuLy();
                    alertify.success(response.success);
                },
                error: function(response) {

                    alertify.error("Sản Phẩm Này Đã Được Sử Dụng");
                }
            })
        };
        $(document).on('click', '.form-delete', function() { // gọi delete.
            if (confirm("Đồng Ý Để Xóa?")) {
                Delete($(this).data('url'), $(this).data('id'));
            }
        });

        $('#form-search').on('click', function(e) { //tìm
            e.preventDefault(); // dừng  sự kiện submit.
            if ($("input[name='search']").val().length > 0) {
                $.ajax({
                    url: $(this).data('url'),
                    method: 'GET',
                    data: {
                        search: $("input[name='search']").val()
                    },
                    success: function(response) {
                        $('.pagination').hide();
                        $("input[name='search']").val("");
                        $('#dataSheet').html(response);
                        alertify.success("Đã Tìm");
                    },
                    error: function(response) {
                        alertify.error("Lỗi Tìm Kiếm");
                    }
                })
            } else {
                location.reload();
            }
        });

        function UpdateCTSP() { // cập nhật chi tiết sản phẩm.
            $('#form-edit-CTSP').on('click', function(e) {
                e.preventDefault(); // dừng  sự kiện submit.
                var url = "san-pham/" + $("input[name='id_sanpham']").val() + "/show"
                $.ajax({
                    url: $(this).data('url'),
                    method: 'PUT',
                    data: {
                        _token: $("input[name='_token']").val(),
                        trangthai: $('input[name = "trangthai"]:checked').length,
                        kichthuoc: $("select[name='kichthuoc']").val(),
                        soluong: $("input[name='soluong']").val(),
                        giasanpham: $("input[name='giasanpham']").val(),
                        ngaysanxuat: $("input[name='ngaysanxuat']").val(),
                        hansudung: $("input[name='hansudung']").val(),
                        id_sanpham: $("input[name='id_sanpham']").val(),
                    },
                    success: function(response) {
                        if (response.errors) {
                            alert(response.errors);
                        } else {
                            $("#exampleModal").modal('hide');
                            Show(url);
                            countSanPhamHetHanSuDung();
                            countSanPhamHetHang();
                            countSanPhamCanXuLy();
                            alertify.success(response.success);
                        }
                    },
                    error: function(response) {

                        alertify.error("Lỗi Cập Nhật");
                    }
                })
            })
        };

        function EditCTSP(url) { // trang cập nhật chi tiết sản phẩm.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {

                    $('#modal-body').html(response);
                    $("#exampleModalLabel").text("Sửa Chi Tiết Sản Phẩm");
                    $("#exampleModal").modal('show');
                    Money();
                    UpdateCTSP();
                },
                error: function(response) {

                    alertify.error("Lỗi Tải Trang");
                }
            })
        };
        $(document).on('click', '.view-edit-CTSP', function() { // gọi EditCTSP.
            $("#exampleModal2").modal('hide');
            EditCTSP($(this).data('url'));
        });

        function DeleteCTSP(url, idsp) { //xóa chi tiết.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (response.errors) {
                        alert(response.errors);
                    } else {
                        Show("san-pham/" + idsp + "/show");
                        countSanPhamHetHanSuDung();
                        countSanPhamHetHang();
                        countSanPhamCanXuLy();
                        alertify.success(response.success);
                    }
                },
                error: function(response) {

                    alertify.error("Chi Tiết Sản Phẩm Này Đã Được Sử Dụng");
                }
            })
        };
        $(document).on('click', '.form-delete-CTSP', function() { // gọi DeleteCTSP.
            if (confirm("Đồng Ý Để Xóa?")) {
                DeleteCTSP($(this).data('url'), $(this).data('idsp'));
            }
        });
        /////////////////////////////////////////////////////////////////////////////////////////// lọc
        function filter() {
            $.ajax({
                url: '/admin/san-pham/filter',
                method: 'GET',
                data: {
                    filtertrangthai: $('#filtertrangthai').val(),
                    filterthe: $('#filterthe').val(),
                    filterloai: $('#filterloai').val(),
                    sort: $('#sort').val(),
                },
                success: function(response) {
                    $("#ModalFilter").modal('hide');
                    $('.pagination').hide();
                    $('#dataSheet').html(response);
                    alertify.success("Đã Lọc");
                },
                error: function(response) {
                    alertify.error("Lỗi Lọc Dữ Liệu");
                }
            })
        }
        $(document).on('click', '#formfilter', function() {
            $('#ModalFilter').modal('show');
        });
    </script>
@endsection
