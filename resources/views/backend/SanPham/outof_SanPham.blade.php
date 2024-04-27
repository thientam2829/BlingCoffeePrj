@extends('layouts.backend_layout')
@section('active_quanlysanpham')
    class="nav-item active"
@endsection
@section('content')
    <div class="main_content_iner ">
        {{-- header --}}
        <div class="btn-pm">
            <div class="mb-3 btn-1">
                <a class="btn btn-info" href="{{ route('san-pham.index') }}">Xem Sản Phẩm</a>
            </div>
        </div>
        {{-- content --}}
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_card">
                        <div class="white_card_header">
                            <div class="main-title">
                                <h2 class="m-0">Danh Sách Sản Phẩm Hết Hàng</h2>
                            </div>
                        </div>
                        <div class="white_card_body">
                            {{-- data sheet --}}
                            <div class="table-responsive">
                                <table class="table" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Hình Ảnh</th>
                                            <th scope="col">Tên Sản Phẩm</th>
                                            <th scope="col">Quy Cách</th>
                                            <th scope="col">Số Lượng</th>
                                            <th scope="col">Ngày Sản Xuất</th>
                                            <th scope="col">Ngày Hết Hạn</th>
                                            <th scope="col">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataSheet">
                                        @if (isset($SanPhamHetHang))
                                            @foreach ($SanPhamHetHang as $value)
                                                <tr id="{{ $value->id }}">
                                                    <td><img src="{{ asset('uploads/SanPham/' . $value->hinhanh) }}" style="width: 100px; height: 100px; border-radius: 5px;"></td>
                                                    <td>{{ $value->tensanpham }}</td>
                                                    <td>{{ $value->tenquycach }}</td>
                                                    <td>{{ number_format($value->soluong, 0, ',', '.') }}</td>
                                                    <td>{{ Date_format(Date_create($value->ngaysanxuat), 'd/m/Y') }}</td>
                                                    <td>{{ Date_format(Date_create($value->hansudung), 'd/m/Y') }}</td>
                                                    <td>
                                                        <a href="javascript:(0)" class="action_btn mr_10 view-edit-CTSP" data-url="{{ route('chi-tiet-san-pham.edit', $value->id) }}"
                                                            data-id="{{ $value->id }}">
                                                            <i class="fas fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if (isset($SanPhamHetHang))
                                {{-- pagination --}}
                                <div class='col-12 d-flex justify-content-center' style='padding: 15px'>
                                    {{ $SanPhamHetHang->links() }}
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
                <div class="modal-body">

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
                            if (!isNaN(valueArray[i])  && valueArray[i] != " ") {
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

        function EditCTSP(url, id) { // trang cập nhật chi tiết sản phẩm.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('.modal-body').html(response);
                    $("#exampleModalLabel").text("Sửa Chi Tiết Sản Phẩm");
                    $("#exampleModal").modal('show');
                    document.getElementById("kichthuocquycach").disabled = true;
                    Money();
                    UpdateCTSP_Date(id);
                },
                error: function(response) {

                    alertify.error("Lỗi Tải Trang");
                }
            })
        };
        $(document).on('click', '.view-edit-CTSP', function() { // gọi EditCTSP.
            EditCTSP($(this).data('url'), $(this).data('id'));
        });

        function UpdateCTSP_Date(id) { // cập nhật chi tiết sản phẩm.
            $('#form-edit-CTSP').on('click', function(e) {
                e.preventDefault(); // dừng  sự kiện submit.
                $.ajax({
                    url: "cap-nhat-xu-ly/" + id,
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
                        }

                        if (response.success) {
                            countSanPhamCanXuLy();
                            $("#exampleModal").modal('hide');
                            $("#" + id).html("");
                            alertify.success(response.success);
                        } else {
                            $("#exampleModal").modal('hide');
                            $("#" + id).html(response);
                            alertify.warning('Sản Phẩm Vẫn Trong Trạng Thái Cần xử lý');
                        }
                    },
                    error: function(response) {
                        alertify.error("Lỗi Cập Nhật");
                    }
                })
            })
        };
    </script>
@endsection
