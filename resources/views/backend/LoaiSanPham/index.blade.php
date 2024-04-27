@extends('layouts.backend_layout')
@section('active_quanlysanpham')
    class="nav-item active"
@endsection
@section('content')
    <div class="main_content_iner ">
        {{-- header --}}
        <div class="btn-pm d-flex justify-content-between">
            <div class="mb-3 btn-1">
                <a onclick="Create('{{ route('loai-san-pham.create') }}')" class="btn btn-success" href="javascript:(0)">Thêm Loại Sản Phẩm</a>
                <a class="btn btn-info" href="{{ route('san-pham.index') }}">Xem Sản Phẩm</a>
                <a id="formfilter" class="btn btn-primary" href="javascript:(0)">Lọc & Sắp Xếp</a>
            </div>
            <div class="serach_field-area d-flex align-items-center mb-3">
                <div class="search_inner">
                    <form method="GET">
                        <div class="search_field">
                            <input type="text" placeholder="Tên..." name="search">
                        </div>
                        <button id="form-search" data-url="{{ route('loai-san-pham.search') }}" type="submit">
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
                                <h2 class="m-0">Loại Sản Phẩm</h2>
                            </div>
                        </div>
                        <div class="white_card_body">
                            {{-- data sheet --}}
                            <div class="table-responsive">
                                <table class="table" style="text-align: center">
                                    <thead>
                                        <tr>
                                            {{-- <th scope="col" style="text-align: left">#</th> --}}
                                            <th scope="col" style="text-align: left">Tên Loại Sản Phẩm</th>
                                            <th scope="col">Trạng Thái</th>
                                            <th scope="col">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataSheet">
                                        @if (isset($LoaiSanPham))
                                            @foreach ($LoaiSanPham as $value)
                                                <tr id="{{ $value->id }}">
                                                    {{-- <td style="text-align: left">{{ $value->id }}</td> --}}
                                                    <td style="text-align: left">{{ $value->tenloaisanpham }}</td>
                                                    <td>
                                                        @if ($value->trangthai == 1)
                                                            <span class="badge bg-primary">Sản phẩm Có Hạn Sử Dụng</span>
                                                        @elseif($value->trangthai == 2)
                                                            <span class="badge bg-success">Sản Phẩm Dùng Trong Ngày</span>
                                                        @else
                                                            <span class="badge bg-danger">Không Được Phép Thêm Sản Phẩm</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="javascript:(0)" class="action_btn mr_10 view-add" data-url="{{ route('quy-cach.create') }}" data-id="{{ $value->id }}">
                                                            <i class="fas fa-plus-square"></i></a>

                                                        <a href="javascript:(0)" class="action_btn mr_10 view-show" data-url="{{ route('loai-san-pham.show', $value->id) }}">
                                                            <i class="fas fa-eye"></i></a>

                                                        <a href="javascript:(0)" class="action_btn mr_10 view-edit" data-url="{{ route('loai-san-pham.edit', $value->id) }}">
                                                            <i class="fas fa-edit"></i></a>

                                                        <a href="javascript:(0)" class="action_btn mr_10 form-delete" data-url="{{ route('loai-san-pham.destroy', $value->id) }}"
                                                            data-id="{{ $value->id }}">
                                                            <i class="fas fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if (isset($LoaiSanPham))
                                {{-- pagination --}}
                                <div class='col-12 d-flex justify-content-center' style='padding: 15px'>
                                    {{ $LoaiSanPham->links() }}
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Tiêu Đề</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body1">

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel2">Tiêu Đề</h3>
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
                                    <option value="Expiry">Sản phẩm Có Hạn Sử Dụng</option>
                                    <option value="Today">Sản Phẩm Dùng Trong Ngày</option>
                                    <option value="Unauthorized">Không Được Phép Thêm Sản Phẩm</option>
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
        function loadData() { // tải lại.
            $.ajax({
                url: "{{ route('loai-san-pham.load') }}",
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
                        alertify.error("Lỗi");
                    }
                })
            } else {
                location.reload();
            }
        });

        function Create(url) { // trang thêm.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {

                    $('#modal-body1').html(response);
                    $("#exampleModalLabel").text("Thêm Loại Sản Phẩm");
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
                        trangthai: $('select[name = "trangthai"]').val(),
                        tenloaisanpham: $("input[name='tenloaisanpham']").val(),
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

        function Edit(url) { // trang cập nhật.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {

                    $('#modal-body1').html(response);
                    $("#exampleModalLabel").text("Sửa Loại Sản Phẩm");
                    $("#exampleModal").modal('show');
                    Update();
                },
                error: function(response) {

                    alertify.error("Lỗi Tải Trang");
                }
            })
        };

        function loadUpdate(id) { // tải lại cập nhật.
            $.ajax({
                url: "loai-san-pham/" + id + "/loadUpdate",
                method: 'GET',
                success: function(response) {
                    $('#' + id).html(response);
                },
                error: function(response) {

                    alertify.error("Lỗi Tải Dữ Liệu");
                }
            });
        };

        function Update() { // cập nhật.
            $('#form-edit').on('click', function(e) {
                e.preventDefault(); // dừng  sự kiện submit.
                var id = $(this).data('id');
                $.ajax({
                    url: $(this).data('url'),
                    method: 'PUT',
                    data: {
                        _token: $("input[name='_token']").val(),
                        trangthai: $('select[name = "trangthai"]').val(),
                        tenloaisanpham: $("input[name='tenloaisanpham']").val(),
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

                        alertify.error("Lỗi Cập nhật");
                    }
                })
            })
        };
        $(document).on('click', '.view-edit', function() { // gọi edit.
            Edit($(this).data('url'));
        });

        function Delete(url, id) { // xóa.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#' + id).html("");
                    alertify.success(response.success);
                },
                error: function(response) {

                    alertify.error("Loại Sản Phẩm Này Đã Được Sử Dụng");
                }
            })
        };
        $(document).on('click', '.form-delete', function() { // gọi xóa.
            if (confirm("Đồng Ý Để Xóa?")) {
                Delete($(this).data('url'), $(this).data('id'));
            }
        });
        /////////////////////////////////////////////////////////////////////////////////////////// quy cach.
        function Add(url, id) { // trang thêm quy cách.
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    $('#modal-body1').html(response);
                    $("#exampleModalLabel").text("Thêm Quy Cách");
                    $("#exampleModal").modal('show');
                    StoreQC();
                },
                error: function(response) {
                    alertify.error("Lỗi Tải Trang");
                }
            })
        };
        $(document).on('click', '.view-add', function() { // gọi add.
            Add($(this).data('url'), $(this).data('id'));
        });

        function StoreQC() { // thêm quy cách.
            $('#form-createQC').on('click', function(e) {
                e.preventDefault(); // dừng  sự kiện submit.
                var url = "loai-san-pham/" + $("input[name='id_loaisanpham']").val() + "/show"
                $.ajax({
                    url: $(this).data('url'),
                    method: 'POST',
                    data: {
                        _token: $("input[name='_token']").val(),
                        trangthai: $('select[name = "trangthai"]').val(),
                        tenquycach: $("input[name='tenquycach']").val(),
                        id_loaisanpham: $("input[name='id_loaisanpham']").val(),
                    },
                    success: function(response) {
                        if (response.errors) {
                            alert(response.errors);
                        } else {
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

        function Show(url) { // trang chi tiết loại sản phảm.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#modal-body').html(response);
                    $("#exampleModalLabel2").text("Chi Tiết Loại Sản Phẩm");
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

        function UpdateQC() { // cập nhật quy cách.
            $('#form-editQC').on('click', function(e) {
                e.preventDefault(); // dừng  sự kiện submit.
                var url = "loai-san-pham/" + $("input[name='id_loaisanpham']").val() + "/show"
                $.ajax({
                    url: $(this).data('url'),
                    method: 'PUT',
                    data: {
                        _token: $("input[name='_token']").val(),
                        trangthai: $('select[name = "trangthai"]').val(),
                        tenquycach: $("input[name='tenquycach']").val(),
                        id_loaisanpham: $("input[name='id_loaisanpham']").val(),
                    },
                    success: function(response) {
                        if (response.errors) {
                            alert(response.errors);
                        } else {
                            $("#exampleModal").modal('hide');
                            Show(url);
                            alertify.success(response.success);
                        }
                    },
                    error: function(response) {

                        alertify.error("Lỗi Cập Nhật");
                    }
                })
            })
        };

        function EditQC(url) { // trang cập nhật quy cách.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $("#exampleModal2").modal('hide');
                    $('#modal-body1').html(response);
                    $("#exampleModalLabel").text("Sửa Quy Cách");
                    $("#exampleModal").modal('show');
                    UpdateQC();
                },
                error: function(response) {

                    alertify.error("Lỗi Tải Trang");
                }
            })
        };
        $(document).on('click', '.view-editQC', function() { // gọi EditQC.
            EditQC($(this).data('url'));
        });

        function DeleteQC(url, id) { //xóa quy cách.
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (response.errors) {
                        alert(response.errors);
                    } else {
                        Show("loai-san-pham/" + id + "/show");
                        alertify.success(response.success);
                    }
                },
                error: function(response) {

                    alertify.error("Quy Cách Này Đã Được Sử Dụng");
                }
            })
        };
        $(document).on('click', '.form-deleteQC', function() { // gọi DeleteQC.
            if (confirm("Xóa Tất Cả Sản Phẩm Thuộc Quy Cách Này?")) {
                DeleteQC($(this).data('url'), $(this).data('id'));
            }
        });
         /////////////////////////////////////////////////////////////////////////////////////////// lọc
         function filter() {
            $.ajax({
                url: '/admin/loai-san-pham/filter',
                method: 'GET',
                data: {
                    filtertrangthai: $('#filtertrangthai').val(),
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
