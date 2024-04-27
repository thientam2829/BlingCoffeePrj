@extends('layouts.backend_layout')
@section('active_quanlykhuyenmai')
    class="nav-item active"
@endsection
@section('content')
    <div class="main_content_iner ">
        {{-- header --}}
        <div class="btn-pm d-flex justify-content-between">
            <div class="mb-3 btn-1">
                @if (Auth::user()->id_loainhanvien == 'LNV00000000000000')
                    <a onclick="Create('{{ route('khuyen-mai.create') }}')" class="btn btn-success" href="javascript:(0)">Thêm Khuyến Mãi</a>
                @endif
                <a id="formfilter" class="btn btn-primary" href="javascript:(0)">Lọc & Sắp Xếp</a>
            </div>
            <div class="serach_field-area d-flex align-items-center mb-3">
                <div class="search_inner">
                    <form method="GET">
                        <div class="search_field">
                            <input type="text" placeholder="Tên..." name="search">
                        </div>
                        <button id="form-search" data-url="{{ route('khuyen-mai.search') }}" type="submit">
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
                                <h2 class="m-0">Danh Sách Khuyến Mãi</h2>
                            </div>
                        </div>
                        <div class="white_card_body">
                            {{-- data sheet --}}
                            <div class="table-responsive">
                                <table class="table" style="text-align: center">
                                    <thead>
                                        <tr>
                                            {{-- <th scope="col" style="text-align: left">#</th> --}}
                                            <th scope="col" style="text-align: left">Tên Khuyến Mãi</th>
                                            <th scope="col">Bắt đầu</th>
                                            <th scope="col">Kết Thúc</th>
                                            <th scope="col">Tình Trạng</th>
                                            <th scope="col">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataSheet">
                                        @if (isset($KhuyenMai))
                                            @foreach ($KhuyenMai as $value)
                                                <tr id="{{ $value->id }}">
                                                    {{-- <td style="text-align: left">{{ $value->id }}</td> --}}
                                                    <td style="text-align: left">{{ $value->tenkhuyenmai }}</td>
                                                    <td>{{ Date_format(Date_create($value->thoigianbatdau), 'd/m/Y') }}</td>
                                                    <td>{{ Date_format(Date_create($value->thoigianketthuc), 'd/m/Y') }}</td>
                                                    <td>
                                                        @isset($today)
                                                            @if ($value->trangthai == 0)
                                                                <span class="badge bg-warning">Đã Khóa</span>
                                                            @elseif ($value->thoigianketthuc < $today) <span class="badge bg-danger">Kết Thúc</span>
                                                                @elseif ($value->thoigianbatdau > $today )
                                                                    <span class="badge bg-info">Sắp Đến</span>
                                                                @else
                                                                    <span class="badge bg-primary">Đang Áp Dụng</span>
                                                            @endif
                                                        @endisset
                                                    </td>
                                                    <td>
                                                        @if (Auth::user()->id_loainhanvien == 'LNV00000000000000')
                                                            <a href="javascript:(0)" class="action_btn mr_10 view-add" data-url="{{ route('chi-tiet-khuyen-mai.create', $value->id) }}"
                                                                data-id="{{ $value->id }}">
                                                                <i class="fas fa-plus-square"></i></a>

                                                            <a href="javascript:(0)" class="action_btn mr_10 view-show" data-url="{{ route('khuyen-mai.show', $value->id) }}"
                                                                data-id="{{ $value->id }}">
                                                                <i class="fas fa-eye"></i></a>

                                                            <a href="javascript:(0)" class="action_btn mr_10 view-edit" data-url="{{ route('khuyen-mai.edit', $value->id) }}"
                                                                data-id="{{ $value->id }}">
                                                                <i class="fas fa-edit"></i></a>

                                                            <a href="javascript:(0)" class="action_btn mr_10 form-delete" data-url="{{ route('khuyen-mai.destroy', $value->id) }}"
                                                                data-id="{{ $value->id }}">
                                                                <i class="fas fa-trash-alt"></i></a>
                                                        @else
                                                            <a href="javascript:(0)" class="action_btn mr_10 view-show" data-url="{{ route('khuyen-mai.show', $value->id) }}"
                                                                data-id="{{ $value->id }}">
                                                                <i class="fas fa-eye"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if (isset($KhuyenMai))
                                {{-- pagination --}}
                                <div class='col-12 d-flex justify-content-center' style='padding: 15px'>
                                    {{ $KhuyenMai->links() }}
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
    {{-- modal 800px --}}
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
                                <label>Tình Trạng</label>
                                <select class="form-control" name="filtertrangthai" id="filtertrangthai">
                                    <option value="all">Tất Cả</option>
                                    <option value="come">Sắp Đến</option>
                                    <option value="apply">Đang Áp Dụng</option>
                                    <option value="end">Kết Thúc</option>
                                    <option value="lock">Đã Khóa</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Ngày Khuyến Mãi</label>
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
        function Create(url) { // trang thêm.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#modal-body').html(response);
                    $("#exampleModalLabel").text("Thêm Khuyến Mãi");
                    $("#exampleModal").modal('show');
                    Store();
                },
                error: function(response) {
                    alertify.error("Lỗi Tải Trang");
                }
            })
        };

        function Store() { // thêm.
            $('#form-create').on('click', function(e) {
                e.preventDefault(); // dừng  sự kiện submit.
                $.ajax({
                    url: $(this).data('url'),
                    method: 'POST',
                    data: {
                        _token: $("input[name='_token']").val(),
                        trangthai: $('input[name = "trangthai"]:checked').length,
                        tenkhuyenmai: $("input[name='tenkhuyenmai']").val(),
                        thoigianbatdau: $("input[name='thoigianbatdau']").val(),
                        thoigianketthuc: $("input[name='thoigianketthuc']").val(),
                        mota: $("textarea[name='mota']").val(),
                    },
                    success: function(response) {
                        if (response.errors) {
                            alert(response.errors);
                        } else {
                            $("#exampleModal").modal('hide');
                            alertify.success(response.success);
                            loadData();
                        }
                    },
                    error: function(response) {
                        alertify.error("Lỗi Thêm Mới");
                    }
                })
            })
        };

        function loadData() { // tải lại.
            $.ajax({
                url: "{{ route('khuyen-mai.load') }}",
                method: 'GET',
                success: function(response) {
                    $('#dataSheet').html(response);
                },
                error: function(response) {
                    alertify.error("Lỗi Tải Dữ Liệu");
                }
            });
        };
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

        function CreateCTKM(url) { // trang thêm chi tiết.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#modal-body').html(response);
                    $("#exampleModalLabel").text("Thêm Chi Tiết Khuyến Mãi");
                    $("#exampleModal").modal('show');
                    $(document).ready(function() {
                        $("#select-sanpham").select2({
                            width: 'resolve',
                        });
                    });
                    StoreCTKM();
                },
                error: function(response) {
                    alertify.error("Lỗi Tải Trang");
                }
            })
        };
        $(document).on('click', '.view-add', function() { // gọi CreateCTKM.
            CreateCTKM($(this).data('url'));
        });

        function Show(url) { // trang chi tiết.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#modal-body-2').html(response);
                    $("#exampleModalLabel2").text("Chi Tiết Khuyến Mãi");
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

        function StoreCTKM() { // thêm chi tiết.
            $('#form-create-CTKM').on('click', function(e) {
                e.preventDefault(); // dừng  sự kiện submit.
                var id = $(this).data('id');
                $.ajax({
                    url: $(this).data('url'),
                    method: 'POST',
                    data: {
                        _token: $("input[name='_token']").val(),
                        id_khuyenmai: $("input[name='id_khuyenmai']").val(),
                        id_chitietsanpham: $("select[name='id_chitietsanpham']").val(),
                        muckhuyenmai: $("input[name='muckhuyenmai']").val(),
                    },
                    success: function(response) {
                        if (response.errors) {
                            alert(response.errors);
                        } else {
                            $("#exampleModal").modal('hide');
                            alertify.success(response.success);
                            Show('khuyen-mai/' + id + '/show');
                        }
                    },
                    error: function(response) {
                        alertify.error("Lỗi Thêm Mới");
                    }
                })
            })
        };

        function Edit(url) { // trang cập nhật.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#modal-body').html(response);
                    $("#exampleModalLabel").text("Cập Nhật Khuyến Mãi");
                    $("#exampleModal").modal('show');
                    Update();
                },
                error: function(response) {
                    alertify.error("Lỗi Tải Trang");
                }
            })
        };
        $(document).on('click', '.view-edit', function() { // gọi edit.
            Edit($(this).data('url'));
        });

        function Update() { // cập nhật.
            $('#form-edit').on('click', function(e) {
                e.preventDefault(); // dừng  sự kiện submit.
                var id = $(this).data('id');
                $.ajax({
                    url: $(this).data('url'),
                    method: 'PUT',
                    data: {
                        _token: $("input[name='_token']").val(),
                        trangthai: $('input[name = "trangthai"]:checked').length,
                        tenkhuyenmai: $("input[name='tenkhuyenmai']").val(),
                        thoigianbatdau: $("input[name='thoigianbatdau']").val(),
                        thoigianketthuc: $("input[name='thoigianketthuc']").val(),
                        mota: $("textarea[name='mota']").val(),
                    },
                    success: function(response) {
                        if (response.errors) {
                            alert(response.errors);
                        } else {
                            $("#exampleModal").modal('hide');
                            alertify.success(response.success);
                            loadUpdate(id);
                        }
                    },
                    error: function(response) {
                        alertify.error("Lỗi Cập Nhật");
                    }
                })
            })
        };

        function loadUpdate(id) { // tải lại cập nhật.
            $.ajax({
                url: "khuyen-mai/" + id + "/loadUpdate",
                method: 'GET',
                success: function(response) {
                    $('#' + id).html(response);
                },
                error: function(response) {
                    alertify.error("Lỗi Tải Dữ Liệu");
                }
            });
        };

        function Delete(url, id) { // xóa.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#' + id).html("");
                    alertify.success(response.success);
                },
                error: function(response) {
                    alertify.error("Khuyến Mãi Này Đã Được Sử Dụng");
                }
            })
        };
        $(document).on('click', '.form-delete', function() { // gọi xóa.
            if (confirm("Đồng Ý Để Xóa?")) {
                Delete($(this).data('url'), $(this).data('id'));
            }
        });

        function EditCTKM(idctsp, idkm) { // trang cập nhật chi tiết.
            $.ajax({
                url: 'chi-tiet-khuyen-mai/' + idctsp + '/' + idkm + '/edit',
                method: 'GET',
                success: function(response) {
                    $('#modal-body').html(response);
                    $("#exampleModalLabel").text("Cập Nhật Chi Tiết Khuyến Mãi");
                    $("#exampleModal2").modal('hide');
                    $("#exampleModal").modal('show');
                    UpdateCTKM();
                },
                error: function(response) {
                    alertify.error("Lỗi Tải Trang");
                }
            })
        };
        $(document).on('click', '.view-edit-CTKM', function() { // gọi EditCTKM.
            EditCTKM($(this).data('idctsp'), $(this).data('idkm'));
        });

        function UpdateCTKM() { // cập nhật.
            $('#form-edit-CTKM').on('click', function(e) {
                e.preventDefault(); // dừng  sự kiện submit.
                var idctsp = $(this).data('idctsp');
                var idkm = $(this).data('idkm');
                $.ajax({
                    url: 'chi-tiet-khuyen-mai/' + idctsp + '/' + idkm + '/update',
                    method: 'PUT',
                    data: {
                        _token: $("input[name='_token']").val(),
                        id_khuyenmai: $("input[name='id_khuyenmai']").val(),
                        id_chitietsanpham: $("input[name='id_chitietsanpham']").val(),
                        muckhuyenmai: $("input[name='muckhuyenmai']").val(),
                    },
                    success: function(response) {
                        if (response.errors) {
                            alert(response.errors);
                        } else {
                            $("#exampleModal").modal('hide');
                            alertify.success(response.success);
                            Show('khuyen-mai/' + idkm + '/show');
                        }
                    },
                    error: function(response) {
                        alertify.error("Lỗi Cập Nhật");
                    }
                })

            })
        };

        function DeleteCTKM(idctsp, idkm) { // xóa chi tiết.
            $.ajax({
                url: 'chi-tiet-khuyen-mai/' + idctsp + '/' + idkm + '/delete',
                method: 'GET',
                success: function(response) {
                    alertify.success(response.success);
                    Show('khuyen-mai/' + idkm + '/show');
                },
                error: function(response) {
                    alertify.error("Chi Tiết Khuyến Mãi Này Đã Được Sử Dụng");
                }
            })
        };
        $(document).on('click', '.form-delete-CTKM', function() { // gọi DeleteCTKM.
            if (confirm("Đồng Ý Để Xóa?")) {
                DeleteCTKM($(this).data('idctsp'), $(this).data('idkm'));
            }
        });
        /////////////////////////////////////////////////////////////////////////////////////////// lọc
        function filter() {
            $.ajax({
                url: '/admin/khuyen-mai/filter',
                method: 'GET',
                data: {
                    filtertrangthai: $('#filtertrangthai').val(),
                    filterngay: $('#filterngay').val(),
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
