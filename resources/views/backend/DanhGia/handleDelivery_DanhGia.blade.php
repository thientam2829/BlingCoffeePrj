@extends('layouts.backend_layout')
@section('active_danhgia')
    class="nav-item active"
@endsection
@section('content')
    <div class="main_content_iner ">
        {{-- header --}}
        <div class="btn-pm d-flex justify-content-between">
            <div class="mb-3 btn-1">
                <a class="btn btn-info" href="{{ route('danh-gia.index') }}">Danh Sách Đánh Giá</a>
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
                                <h2 class="m-0">Danh Sách Đánh Giá Cần Duyệt</h2>
                            </div>
                        </div>
                        <div class="white_card_body">
                            {{-- data sheet --}}
                            <div class="table-responsive">
                                <table class="table" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: left">Họ Tên</th>
                                            <th scope="col">Thời Gian</th>
                                            <th scope="col">Số Sao</th>
                                            <th scope="col">Nội Dung</th>
                                            <th scope="col">Thao Tác</th>
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
                                                            <a href="javascript:(0)" class="action_btn mr_10 view-approval" data-url="{{ route('danh-gia.approval', $value->id) }}"
                                                                data-id="{{ $value->id }}"><i class="fas fa-pen"></i></a>
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
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/themes/default.min.css') }}">
@endsection
@section('script')
    <script src="{{ asset('frontend/alertifyjs/alertify.min.js') }}"></script>
    <script type="text/javascript">
        ///////////////////////////////////////// hiển thị chi tiết
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
        ///////////////////////////////////////// duyệt đánh giá.
        function approval(url, id) {
            alertify.success("Đã duyệt");
            $('#' + id).html('');
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    countDanhGiaCanXuLy();
                    alertify.success(response.success);
                },
                errors: function(response) {
                    alertify.error("Lỗi Duyệt Đánh Giá");
                }
            })
        };
        $(document).on('click', '.view-approval', function() {
            if (confirm('Duyệt đánh giá')) {
                approval($(this).data('url'), $(this).data('id'));
            }
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
    </script>
@endsection
