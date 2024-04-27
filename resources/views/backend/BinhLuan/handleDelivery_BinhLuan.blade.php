@extends('layouts.backend_layout')
@section('active_binhluan')
    class="nav-item active"
@endsection
@section('content')
    <div class="main_content_iner ">
        {{-- header --}}
        <div class="btn-pm d-flex justify-content-between">
            <div class="mb-3 btn-1">
                <a class="btn btn-info" href="{{ route('binh-luan.index') }}">Danh Sách Bình Luận</a>
            </div>
            <div>
            </div>
        </div>
        {{-- content --}}
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_card">
                        <div class="white_card_header">
                            <div class="main-title">
                                <h2 class="m-0">Danh Sách Bình Luận Cần Duyệt</h2>
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
                                            <th scope="col" style="text-align: center">Nội Dung</th>
                                            <th scope="col" style="text-align: center">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataSheet">
                                        @if (isset($BinhLuan))
                                            @foreach ($BinhLuan as $value)
                                                <tr id="{{ $value->id }}">
                                                    <td style="width: 15%; text-align: left">{{ $value->hoten }}</td>
                                                    <td style="width: 20%">{{ Date_format(Date_create($value->thoigian), 'd/m/Y H:i:s') }}</td>
                                                    <td style="text-align: left">{{ $value->noidung }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="javascript:(0)" class="action_btn mr_10 view-show" data-url="{{ route('binh-luan.show', $value->id) }}">
                                                                <i class="fas fa-eye"></i></a>

                                                            <a href="javascript:(0)" class="action_btn mr_10 form-delete" data-url="{{ route('binh-luan.destroy', $value->id) }}"
                                                                data-id="{{ $value->id }}"><i class="fas fa-trash-alt"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if (isset($BinhLuan))
                                {{-- pagination --}}
                                <div class='col-12 d-flex justify-content-center' style='padding: 15px'>
                                    {{ $BinhLuan->links() }}
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
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/themes/default.min.css') }}">
@endsection
@section('script')
    <script src="{{ asset('frontend/alertifyjs/alertify.min.js') }}"></script>
    <script type="text/javascript">
        /////////////////////////////////////////////////////////////////////////////////////////// hiển thị chi tiết.
        function ShowBinhLuan(url) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $("#content-comment").html(response);
                    $("#exampleModalLabel").text("Chi Tiết Bình Luận");
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
        /////////////////////////////////////////////////////////////////////////////////////////// hiện form trả lời.
        $(document).on('click', '.reply', function() {
            $('#comment').val('@' + $(this).data('name') + ': ');
            $('#idreply').val($(this).data('idreply'));
            $('#form-comment').show();
            $('#comment').focus();
        });
        /////////////////////////////////////////////////////////////////////////////////////////// trả lời.
        function informationForm() {
            var comment = $('#comment').val();
            var id = $('#idreply').val();
            if (comment != '') {
                $.ajax({
                    url: '/binh-luan/reply',
                    method: "POST",
                    data: {
                        _token: $("input[name='_token']").val(),
                        noidung: comment,
                        id_sanpham: $('#comment').data('id_sanpham'),
                        matraloi: $('#comment').data('matraloi'),
                        idreply: id,
                    },
                    success: function(response) {
                        countBinhLuanCanXuLy();
                        $("#listreply").html(response);
                        $("#form-comment").hide();
                        $("#" + id).html('');
                        alertify.success("Đã Trả Lời Bình Luận")
                        ///////////////////////// gửi email phản hồi.
                        $.ajax({
                            url: '/binh-luan/comment-email/' + id + "/" + 1,
                            method: "GET",
                            success: function(response) {
                                alertify.success(response.success);
                            },
                            errors: function(response) {
                                alertify.error("Lỗi Gửi email");
                            }
                        });
                    },
                    error: function() {
                        alertify.error("Lỗi Khi Trả Lời Bình Luận");
                    }
                })
            } else {
                $('.lbMsgCmt').text('Vui lòng nhập nội dung');
            }
        }
        /////////////////////////////////////////////////////////////////////////////////////////// Xóa bình luận góc.
        function Delete(url, id) { //hiển thị chi tiết hóa đơn.
            alertify.success("Thành Công"); // thông báo xóa thành công trước.
            $("#" + id).html("");
            $("#exampleModal").modal('hide');
            // gửi email phản hồi.
            $.ajax({
                url: '/binh-luan/comment-email/' + id + "/" + 2,
                method: "GET",
                success: function(response) {
                    alertify.success(response.success);
                    // xóa bình luận,
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            countBinhLuanCanXuLy();
                        },
                        errors: function(response) {
                            alertify.error("Lỗi Xóa");
                        }
                    })
                },
                errors: function(response) {
                    alertify.error("Lỗi Gửi email");
                }
            });

        };
        $(document).on('click', '.form-delete', function() {
            if (confirm('Xóa Bình Luận Này')) {
                Delete($(this).data('url'), $(this).data('id'));
            }
        });
        /////////////////////////////////////////////////////////////////////////////////////////// Xóa trả lời.
        function DeleteReply(url, id) {
            alertify.success("Thành Công"); // thông báo xóa thành công trước.
            $("#" + id).html("");
            $("#exampleModal").modal('hide');
            // gửi email phản hồi.
            $.ajax({
                url: '/binh-luan/comment-email/' + id + "/" + 2,
                method: "GET",
                success: function(response) {
                    alertify.success(response.success);
                    // xóa bình luận,
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            countBinhLuanCanXuLy();
                        },
                        errors: function(response) {
                            alertify.error("Lỗi Xóa");
                        }
                    })
                },
                errors: function(response) {
                    alertify.error("Lỗi Gửi email");
                }
            });
        };
        $(document).on('click', '.delete-reply', function() {
            if (confirm('Xóa Trả Lời Bình Luận')) {
                DeleteReply($(this).data('url'), $(this).data('id'));
            }
        });
    </script>
@endsection
