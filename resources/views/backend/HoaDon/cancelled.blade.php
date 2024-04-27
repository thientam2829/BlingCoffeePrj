@extends('layouts.backend_layout')
@section('active_danhsachhoadon')
    class="nav-item active"
@endsection
@section('content')
    <div class="main_content_iner ">
        {{-- header --}}
        <div class="btn-pm d-flex justify-content-between">
            <div class="mb-3 btn-1">
                <a class="btn btn-info" href="{{ route('hoa-don.index') }}">Danh Sách Hóa Đơn</a>
            </div>
            <div class="serach_field-area d-flex align-items-center mb-3">
                <div class="search_inner">
                    <form method="GET">
                        <div class="search_field">
                            <input type="text" placeholder="Tên, sđt  khách hàng, sđt nhân viên..." name="search">
                        </div>
                        <button id="form-search" data-url="{{ route('hoa-don.searchCancelled') }}" type="submit">
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
                                <h2 class="m-0">Danh Sách Hóa Đơn Đã Hủy</h2>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <div class="table-responsive">
                                <table class="table" style="text-align: center">
                                    <thead>
                                        <tr>
                                            {{-- <th scope="col" style="text-align: left">#</th> --}}
                                            <th scope="col" style="text-align: left">Ngày Lập</th>
                                            <th scope="col">SĐT Khách Hàng</th>
                                            <th scope="col">Khách Hàng</th>
                                            <th scope="col">Người Lập</th>
                                            <th scope="col">Trạng Thái</th>
                                            <th scope="col">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataSheet">
                                        @if (isset($HoaDon))
                                            @foreach ($HoaDon as $value)
                                                <tr id="{{ $value->id }}">
                                                    {{-- <td style="text-align: left">{{ $value->id }}</td> --}}
                                                    <td style="text-align: left">{{ Date_format(Date_create($value->ngaylap), 'd/m/Y H:i:s') }}</td>
                                                    <td>{{ $value->sdtkhachhang }}</td>
                                                    <td>
                                                        {{ $value->tenkhachhang }}
                                                    </td>
                                                    <td>
                                                        @isset($NhanVien)
                                                            @foreach ($NhanVien as $itemNV)
                                                                @if ($value->id_nhanvien == $itemNV->id)
                                                                    {{ $itemNV->tennhanvien }}
                                                                @endif
                                                            @endforeach
                                                        @endisset
                                                    </td>
                                                    <td>
                                                        @if ($value->trangthai == 3)
                                                            <span class='badge bg-warning'>Đã Hủy</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a data-id="{{ $value->id }}" href="javascript:(0)" class="action_btn mr_10 view-show">
                                                            <i class="fas fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if (isset($HoaDon))
                                {{-- pagination --}}
                                <div class='col-12 d-flex justify-content-center' style='padding: 15px'>
                                    {{ $HoaDon->links() }}
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
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Hóa Đơn</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="content-HD">

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
        function ShowHoaDon(id) { //hiển thị chi tiết hóa đơn.
            $.ajax({
                url: '/admin/hoa-don/show/' + id,
                method: 'GET',
                success: function(data) {
                    $("#content-HD").html(data);
                    $("#exampleModalLabel").text("Chi Tiết Hóa Đơn");
                    $("#exampleModal").modal('show');
                }
            })
        };
        $(document).on('click', '.view-show', function() {
            ShowHoaDon($(this).data('id'));
        });
        ///////////////////////////////////////// tìm
        $('#form-search').on('click', function(e) {
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
