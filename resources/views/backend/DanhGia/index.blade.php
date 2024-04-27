@extends('layouts.backend_layout')
@section('active_danhgia')
    class="nav-item active"
@endsection
@section('content')
    <div class="main_content_iner ">
        {{-- header --}}
        <div class="btn-pm d-flex justify-content-between">
            <div class="mb-3 btn-1">
                <a class="btn btn-warning" href="{{ route('danh-gia.handleDelivery') }}">Đánh Giá Cần Duyệt <span class="badge bg-danger soluongdanhgiacanxu"></span></a>
                <a id="formfilter" class="btn btn-primary" href="javascript:(0)">Lọc & Sắp Xếp</a>
            </div>
            <div class="serach_field-area d-flex align-items-center mb-3">
                <div class="search_inner">
                    <form method="GET">
                        <div class="search_field">
                            <input type="text" placeholder="Tên, nội dung..." name="search">
                        </div>
                        <button id="form-search" data-url="{{ route('danh-gia.search') }}" type="submit">
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
                                <h2 class="m-0">Danh Sách Đánh Giá</h2>
                            </div>
                        </div>
                        <div class="white_card_body">
                            {{-- data sheet --}}
                            <div class="table-responsive">
                                <table class="table" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: left">Họ Tên</th>
                                            <th scope="col" style="text-align: center">Thời Gian</th>
                                            <th scope="col" style="text-align: center">Số Sao</th>
                                            <th scope="col" style="text-align: center">Nội Dung</th>
                                            <th scope="col" style="text-align: center">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataSheet">
                                        @if (isset($DanhGia))
                                            @foreach ($DanhGia as $value)
                                                <tr id="{{ $value->id }}">
                                                    <td style="width: 15%; text-align: left">{{ $value->hoten }}</td>
                                                    <td style="width: 20%">{{ Date_format(Date_create($value->thoigian), 'd/m/Y H:i:s') }}</td>
                                                    <td style="width: 8%">{{ $value->sosao }}</td>
                                                    <td style="text-align: left">{{ $value->noidung }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="javascript:(0)" class="action_btn mr_10 view-show" data-url="{{ route('danh-gia.show', $value->id) }}">
                                                                <i class="fas fa-eye"></i></a>
                                                            <a href="javascript:(0)" class="action_btn mr_10 form-delete" data-url="{{ route('danh-gia.destroy', $value->id) }}"
                                                                data-id="{{ $value->id }}"><i class="fas fa-trash-alt"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if (isset($DanhGia))
                                {{-- pagination --}}
                                <div class='col-12 d-flex justify-content-center' style='padding: 15px'>
                                    {{ $DanhGia->links() }}
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Tiêu Đề</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="content-comment">
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
                                <label>Sản Phẩm</label>
                                <select id="filtersanpham" class="form-control" name="filtersanpham" required style="width: 100%; height: 200%">
                                    <option value="all">Tất Cả</option>
                                    @isset($SanPham)
                                        @foreach ($SanPham as $valuesp)
                                            <option value="{{ $valuesp->id }}"> {{ $valuesp->tensanpham }} </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Số Sao</label>
                                <select id="filtersosao" class="form-control" name="filtersosao">
                                    <option value="all">Tất Cả</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Thời Gian</label>
                                <input class="form-control" type="date" name="filterngay" id="filterngay">
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
    <link rel="stylesheet" href="{{ asset('backend/vendors/select2/dist/css/select2.min.css') }}">
@endsection
@section('script')
    <script src="{{ asset('frontend/alertifyjs/alertify.min.js') }}"></script>
    <script src="{{ asset('backend/vendors/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        ///////////////////////////////////////// hiển thị chi tiết.
        function ShowBinhLuan(url) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $("#content-comment").html(response);
                    $("#exampleModalLabel").text("Chi Tiết Đánh Giá");
                    $("#exampleModal").modal('show');
                },
                errors: function(response) {
                    alertify.error("Lỗi Tải Trang");
                }
            })
        };
        $(document).on('click', '.view-show', function() {
            ShowBinhLuan($(this).data('url'));
        });
        ///////////////////////////////////////// Xóa đánh giá.
        function Delete(url, id) {
            alertify.success("Đã Xóa Đánh Giá");
            $("#" + id).html("");
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    countDanhGiaCanXuLy();
                    alertify.success(response.success);
                },
                errors: function(response) {
                    alertify.error("Lỗi Xóa Đánh Giá");
                }
            })
        };
        $(document).on('click', '.form-delete', function() {
            if (confirm('Xóa Đánh Giá')) {
                Delete($(this).data('url'), $(this).data('id'));
            }
        });
        /////////////////////////////////////////////////////////////////////////////////////////// lọc
        function filter() {
            $.ajax({
                url: '/danh-gia/filter',
                method: 'GET',
                data: {
                    filtersanpham: $('#filtersanpham').val(),
                    filterngay: $('#filterngay').val(),
                    filtersosao: $('#filtersosao').val(),
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
            $(document).ready(function() {
                $("#filtersanpham").select2({
                    width: 'resolve',
                });
            });
            $('#ModalFilter').modal('show');
        });
        /////////////////////////////////////////////////////////////////////////////////////////// serach
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
    </script>
@endsection
