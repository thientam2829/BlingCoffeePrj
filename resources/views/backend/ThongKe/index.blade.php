@extends('layouts.backend_layout')
@section('active_thongke')
    class="nav-item active"
@endsection
@section('content')
    <div class="main_content_iner ">
        <div class="white_card card_height_100 mb_30 user_crm_wrapper">
            <div class="row">
                <div class="col-lg-12"> {{-- doanh số --}}
                    <div class="single_crm">
                        <div class="crm_head d-flex align-items-center">
                            <i class="fas fa-poll f_s_20 white_text"></i><samp class="ml-10">Biểu Đồ Doanh Số Bán Hàng</samp>
                        </div>
                        <div class="crm_body">
                            <div class="row" style="display: flex;align-items: center;">
                                <div class="col-lg-9">
                                    <div id="myfirstchart" style="height: 250px;"></div>
                                </div>
                                <div class="col-lg-3">
                                    {{-- <button id="filer_from_to" type="button" class="btn-w100 mb-10 btn btn-outline-primary">In Thống Kê</button> --}}
                                    <div class="form-group">
                                        <label>Từ Ngày</label>
                                        <input type="date" class='form-control' name="fromdate" id="fromdate">
                                    </div>
                                    <div class="form-group">
                                        <label>Đến Ngày</label>
                                        <input type="date" class='form-control' name="todate" id="todate">
                                    </div>
                                    <button id="filer_from_to" type="button" class="btn-w100 btn btn-outline-primary">Tìm Thống Kê</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-9 d-flex" style="justify-content: space-evenly;">
                                    <div class="">
                                        <samp class="color-data-1">x</samp>
                                        <samp>Doanh Số</samp>
                                    </div>
                                    <div class="">
                                        <samp class="color-data-2">x</samp>
                                        <samp>Lợi Nhuận</samp>
                                    </div>
                                    <div class="">
                                        <samp class="color-data-3">x</samp>
                                        <samp>Số Lượng Đã Bán</samp>
                                    </div>
                                    <div class="">
                                        <samp class="color-data-4">x</samp>
                                        <samp>Số Lượng Đơn Hàng</samp>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4"> {{-- sản phẩm --}}
                    <div class="single_crm" style="height: 430px;">
                        <div class="crm_head d-flex align-items-center">
                            <i class="fas fa-coffee f_s_20 white_text"></i><samp class="ml-10">Sản Phẩm</samp>
                        </div>
                        <div class="crm_body">
                            <div id="san-pham-chart" style="height: 300px;"></div>
                            <div style="text-align: center">{{ number_format($SanPham, 0, ',', '.') }} Sản Phẩm</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4"> {{-- Nhân Viên --}}
                    <div class="single_crm" style="height: 430px;">
                        <div class="crm_head d-flex align-items-center">
                            <i class="fas fa-users-cog f_s_20 white_text"></i><samp class="ml-10">Nhân Viên</samp>
                        </div>
                        <div class="crm_body">
                            <div id="nhan-vien-chart" style="height: 300px;"></div>
                            <div style="text-align: center">{{ number_format($NhanVien - 2, 0, ',', '.') }} Nhân Viên</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4"> {{-- hóa đơn --}}
                    <div class="single_crm" style="height: 430px;">
                        <div class="crm_head d-flex align-items-center">
                            <i class="fas fa-file-invoice-dollar f_s_20 white_text"></i><samp class="ml-10">Hóa Đơn</samp>
                        </div>
                        <div class="crm_body">
                            <div id="hoa-don-chart" style="height: 300px;"></div>
                            <div style="text-align: center">{{ number_format($HoaDon, 0, ',', '.') }} Hóa Đơn</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8"> {{-- Khách Hàng --}}
                    <div class="single_crm" style="min-height: 430px;">
                        <div class="crm_head d-flex align-items-center">
                            <i class="fas fa-users f_s_20 white_text"></i><samp class="ml-10">Khách Hàng</samp>
                        </div>
                        <div class="crm_body">
                            <div class="row" style="display: flex;align-items: center;">
                                <div class="col-lg-6">
                                    <div id="khach-hang-chart" style="height: 300px;"></div>
                                    <div style="text-align: center">{{ number_format($KhachHang - 1, 0, ',', '.') }} Khách Hàng</div>
                                </div>
                                <div class="col-lg-6">
                                    <h4 class="mb-3">Điểm Tích Lũy Cao Nhất</h4>
                                    @isset($KhachHangTop10)
                                        @foreach ($KhachHangTop10 as $key => $item)
                                            <samp>{{ $key + 1 . '. ' . $item->tenkhachhang . ' ' . number_format($item->diemtichluy, 0, ',', '.') . ' Điểm' }}</samp><br>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4"> {{-- Khuyến mãi --}}
                    <div class="single_crm" style="min-height: 430px;">
                        <div class="crm_head d-flex align-items-center">
                            <i class="fas fa-gift f_s_20 white_text"></i><samp class="ml-10">Khuyến Mãi</samp>
                        </div>
                        <div class="crm_body">
                            <div class="row" style="display: flex;align-items: center;">
                                @isset($KhuyenMaiDangApDung)
                                    @if (count($KhuyenMaiDangApDung) > 0)
                                        <h4 class="mb-3">Khuyến Mãi Đang Áp Dụng</h4>
                                        @foreach ($KhuyenMaiDangApDung as $item)
                                            <samp
                                                class="mb-1">{{ $item->tenkhuyenmai }}<br>{{ Date_format(Date_create($item->thoigianbatdau), 'd/m/Y') . ' - ' . Date_format(Date_create($item->thoigianketthuc), 'd/m/Y') }}</samp><br>
                                        @endforeach
                                    @endif
                                @endisset
                                @isset($KhuyenMaiSapDen)
                                    @if (count($KhuyenMaiSapDen) > 0)
                                        <h4 class="mb-3">Khuyến Mãi Sắp Đến</h4>
                                        @foreach ($KhuyenMaiSapDen as $item)
                                            <samp
                                                class="mb-1">{{ $item->tenkhuyenmai }}<br>{{ Date_format(Date_create($item->thoigianbatdau), 'd/m/Y') . ' - ' . Date_format(Date_create($item->thoigianketthuc), 'd/m/Y') }}</samp><br>
                                        @endforeach
                                    @endif
                                @endisset
                            </div>
                            <div style="text-align: center" class="mt-4">{{ number_format($KhuyenMai, 0, ',', '.') }} Khuyến Mãi</div>
                        </div>
                    </div>
                </div>
                {{-- ///////////////////// --}}
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/themes/default.min.css') }}">
    <!-- morris css -->
    <link rel="stylesheet" href="{{ asset('backend/vendors/morris/morris.css') }}">
    <style>
        .btn-w100 {
            width: 100%;
        }

        samp.color-data-1 {
            background: #016DEA;
            color: #016DEA;
            border-radius: 15px;
            padding: 0px 6px;
        }

        samp.color-data-2 {
            background: #FADF01;
            color: #FADF01;
            border-radius: 15px;
            padding: 0px 6px;
        }

        samp.color-data-3 {
            background: #FA4001;
            color: #FA4001;
            border-radius: 15px;
            padding: 0px 6px;
        }

        samp.color-data-4 {
            background: #1ED915;
            color: #1ED915;
            border-radius: 15px;
            padding: 0px 6px;
        }

    </style>
@endsection
@section('script')
    <script src="{{ asset('frontend/alertifyjs/alertify.min.js') }}"></script>
    <!-- morris css -->
    <script src="{{ asset('backend/vendors/morris/morris.min.js') }}"></script>
    <script src="{{ asset('backend/vendors/morris/raphael-min.js') }}"></script>

    <script type="text/javascript">
        statsForThisMonth(); // chạy luôn function khi đến trang này.

        function statsForThisMonth() {
            $.ajax({
                url: 'admin/thong-ke/thang-nay',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    _token: $("input[name='_token']").val(),
                },
                success: function(response) {
                    chart.setData(response);
                    // alertify.success("Đã Tải Thống Kê Từ 30 Ngày Trước");
                },
                error: function(response) {
                    alertify.error("Không Thể Tải Thống Kê Doanh Số");
                }
            });
            $.ajax({
                url: 'admin/thong-ke/san-pham',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    _token: $("input[name='_token']").val(),
                },
                success: function(response) {
                    prouctChart.setData(response);
                },
                error: function(response) {
                    alertify.error("Không Thể Tải Thống Kê Doanh Số");
                }
            });
            $.ajax({
                url: 'admin/thong-ke/khach-hang',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    _token: $("input[name='_token']").val(),
                },
                success: function(response) {
                    customerChart.setData(response);
                },
                error: function(response) {
                    alertify.error("Không Thể Tải Thống Kê Doanh Số");
                }
            });
            $.ajax({
                url: 'admin/thong-ke/nhan-vien',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    _token: $("input[name='_token']").val(),
                },
                success: function(response) {
                    satffChart.setData(response);
                },
                error: function(response) {
                    alertify.error("Không Thể Tải Thống Kê Doanh Số");
                }
            });
            $.ajax({
                url: 'admin/thong-ke/hoa-don',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    _token: $("input[name='_token']").val(),
                },
                success: function(response) {
                    billChart.setData(response);
                },
                error: function(response) {
                    alertify.error("Không Thể Tải Thống Kê Doanh Số");
                }
            });
        }
        $('#filer_from_to').on('click', function() {
            var fromdate = $('#fromdate').val();
            var todate = $('#todate').val();
            $.ajax({
                url: 'admin/thong-ke/tu-den',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    _token: $("input[name='_token']").val(),
                    fromdate: fromdate,
                    todate: todate,
                },
                success: function(response) {
                    if (response.errors) {
                        alert(response.errors);
                    } else {
                        chart.setData(response);
                        alertify.success("Đã Tìm Từ ngày " + fromdate + " Đến Ngày " + todate);
                    }
                },
                error: function(response) {
                    alertify.error("Không Tìm Thấy Thống Kê");
                }
            })
        });
        ////////////////////////////
        var chart = new Morris.Bar({
            // ID of the element in which to draw the chart.
            element: 'myfirstchart',
            //
            barColors: ['#016DEA', '#FADF01', '#FA4001', '#1ED915', '#FF004D'],
            // lineColors:['#FF7EA5', '#20DEFF', '#C388F6', '#F5F5FF', '#ff004d'],
            parsrTime: false,
            hideHover: 'auto',
            xkey: 'thoigian',
            ykeys: ['doanhso', 'loinhuan', 'soluongdaban', 'soluongdonhang'],
            labels: ['Doanh Số', 'Lợi Nhuận', 'Số Lượng Đã Bán', 'Số Lượng Đơn Hàng']
        });
        /////////////////////san-pham-chart
        var prouctChart = new Morris.Donut({
            element: 'san-pham-chart',
            resize: true,
            colors: ['#89644a', '#1f9fc7', '#f65a3e', '#EED703', '#26C6DA', '#00BCD4', '#00ACC1', '#0097A7', '#00838F', '#006064'],
            data: [{
                label: "",
                value: null
            }]
        });
        //////////////////////////khach-hang-chart
        var customerChart = new Morris.Donut({
            element: 'khach-hang-chart',
            resize: true,
            colors: ['#98D3DB', '#5CAFC9', '#437DBA', '#3242A3', '#1B207A'],
            data: [{
                label: "",
                value: null
            }]
        });
        //////////////////////////nhan-vien-chart
        var satffChart = new Morris.Donut({
            element: 'nhan-vien-chart',
            resize: true,
            colors: ['#2EC20A', '#36CF11', '#45DD12', '#45DD12', '#45DD12', '#45DD12'],
            data: [{
                label: "",
                value: null
            }]
        });
        //////////////////////////hoa-don-chart
        var billChart = new Morris.Donut({
            element: 'hoa-don-chart',
            resize: true,
            colors: ['#3342C4', '#FFA52C', '#FF0018'],
            data: [{
                label: "",
                value: null
            }]
        });
    </script>
@endsection
