@extends('layouts.frontend_layout')
@section('content')
    <section class="home-slider owl-carousel">
        <div class="slider-item" style="background-image: url({{ asset('frontend/images/bg_3.jpg') }});"
            data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center">
                    <div class="col-md-7 col-sm-12 text-center ftco-animate">
                        <h1 class="mb-3 mt-5 bread">Thanh Toán</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('Trangchu.index') }}">Trang
                                    Chủ</a></span> <span>Thanh Toán</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 ftco-animate">
                    <div class="billing-form ftco-bg-dark ftco-bg-dark-info p-3 p-md-5">
                        <form action="{{ route('GioHang.orderOnline') }}" method="POST" class="___class_+?14___">
                            @csrf
                            <h3 class="mb-4 billing-heading billing-heading-center">Thông Tin Khách Mua Hàng</h3>
                            <div class="row align-items-end">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="firstname">Họ Tên<b style="color:red"> *</b></label>
                                        <input type="text" name="hoten" id="hoten"
                                            class="form-control form-control-info" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="firstname">Số Điện Thoại<b style="color:red"> *</b></label>
                                        <input id="SDT" name="sdt" type="number" class="form-control form-control-info"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="firstname">Email<b style="color:red"> *</b></label>
                                        <input name="email" id="email" type="email"
                                            class="form-control form-control-info" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="firstname">Địa Chỉ<b style="color:red"> *</b></label>
                                        <input type="text" name="diachi" id="diachi"
                                            class="form-control form-control-info" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="firstname">Ghi Chú</label>
                                        <textarea name="ghichu" class="form-control form-control-info" cols="30"
                                            rows="7"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" value="Đặt Hàng" id="dathang" class="btn btn-primary py-3 px-5"
                                        style="margin-left: 335px;width: 300px;margin-bottom: -77px;">
                                </div>
                            </div>
                        </form><!-- END -->
                        <button class="btn btn-primary py-3 px-5" id="xemsanpham" style="width: 300px;">Xem Sản
                            Phẩm</button>
                        {{-- button paypal --}}
                        <div class="col-md-12">
                            <div style="margin-top: 1em">
                                <p><b> Thanh toán đơn hàng bằng Paypal </b></p>
                            </div>
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>

                </div> <!-- .col-md-8 -->
                <div class="col-xl-4 sidebar ftco-animate">
                    <div class="cart-detail ftco-bg-dark ftco-bg-dark-info ftco-bg-dark-sale p-3 p-md-4 category">
                        <h4 class="subheading-bill">Sản Phẩm Khuyến mãi</h4>
                        <div class="productsale-slider-right-to-left owl-carousel">
                            @isset($KhuyenMai)
                                @foreach ($KhuyenMai as $item)
                                    <div class="menu-entry menu-entry-slider">
                                        <a href="{{ route('SanPham.show', $item->id) }}" class="img"
                                            style="background-image: url({{ asset('uploads/SanPham/' . $item->hinhanh) }});"></a>
                                        <div class="text text-center pt-4">
                                            <h3 class="a-name"><a
                                                    href="{{ route('SanPham.show', $item->id) }}">{{ $item->tensanpham . ' ' . $item->tenquycach }}</a>
                                            </h3>
                                            <p class="price">
                                                <span>{{ number_format($item->giasanpham * (1 - $item->muckhuyenmai / 100), 0, ',', '.') . ' VNĐ  (-' . $item->muckhuyenmai . '%)' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- .section -->
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/themes/default.min.css') }}">
    <style>
        tbody.info-product-tbody td {
            height: 60px;
        }

        input.btn.btn-primary.py-3.px-5 {
            width: 45%;
        }

        .category {
            top: 100px;
            position: -webkit-sticky;
            position: sticky;
            left: 0;
        }

        table.info-product {
            width: 100%;
        }

        table.info-product2 {
            width: 100%;
            text-align: center;
            margin-top: 25px;
        }

        .info-product2-color {
            color: #c49b63;
        }

        .info-product tr {
            border-bottom: 1px solid;
        }

        .discount {
            text-decoration: line-through;
        }

        .billing-heading-center {
            text-align: center;
        }

        .menu-entry-slider .img {
            display: block;
            height: 300px;
        }

        .menu-entry-slider .text h3 a {
            color: #fff;
            font-size: 20px;
        }


        .ftco-bg-dark-bill {
            height: 345px;
        }

        .ftco-bg-dark-info {
            box-shadow: 0 4px 8px 0 rgb(255 255 255 / 20%), 0 6px 20px 0 rgb(255 255 255 / 19%);
        }

        .ftco-bg-dark-sale {
            height: 580px;
        }

        .subheading-bill {
            font-size: 30px;
            margin-bottom: 0;
            font-family: "Time New Roman";
            color: #c49b63;
            margin-top: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .large_logo img {
            width: 200px;
        }

        .icon2 {
            color: rgba(255, 255, 255, 0.7) !important;
        }

    </style>
@endsection
@section('modal')
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button style="outline: none" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="dataxemsanpham">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('frontend/alertifyjs/alertify.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() { // nhập 10 số.
            $("#SDT").keypress(function() {
                if (this.value.length == 10) {
                    return false;
                }
            })
        });

        $('#dathang').on('click', function() { // kiểm tra trước khi gửi.
            var hoten2 = $('#hoten').val();
            var SDTa = $('#SDT').val();
            var email = $('#email').val();
            var diachi = $('#diachi').val();
            if (hoten2.length > 0 && SDTa.length > 0 && email.length > 0 && diachi.length > 0) {
                var value = document.getElementById('SDT').value;
                if (value.length == 10) {
                    return true;

                }
                alertify.warning("Số Điện Thoại Không Đúng Định Dạng");
                return false;
            }
        })

        $('#xemsanpham').on('click', function() { // xem giỏ hàng và kiểm tra thành viên.
            $.ajax({
                url: "xem-gio-hang",
                method: "GET",
                data: {
                    sdt: $("input[name='sdt']").val(),
                },
                success: function(data) {
                    $('#dataxemsanpham').html(data);
                    $('#exampleModal').modal('show');
                },
                errors: function(data) {
                    alertify.error("Lỗi Tải Trang");
                }
            })

        })
    </script>

    {{-- Demo paypal --}}
    <script
        src="https://www.paypal.com/sdk/js?client-id=AeLJwZIqcSkv6nX6QKqbS_r0JaY_5g_KyzajVSd05iaqPSxvZb7dQeohs7x45ujcVPWwKJbo5fwYtfNr&commit=true">
        // Required. Replace YOUR_CLIENT_ID with your sandbox client ID.
    </script>
    <script>
        paypal.Buttons({
            // Chỉnh css của nút pay pal
            style: {
                layout: 'horizontal',
                color: 'gold',
                shape: 'pill',
                label: 'paypal',
            },


            // Hàm khởi tạo thanh toán của paypal
            createOrder: function(data, actions) {
                var paypal_ten = $('#hoten').val();
                var paypal_sdt = $('#SDT').val();
                var paypal_email = $('#email').val();
                var paypal_diachi = $('#diachi').val();
                var paypal_ghichu = $('#ghichu').val();
                if (paypal_ten.length < 1) {
                    alertify.warning('Họ tên bị bỏ trống');
                    return false;
                } else if (paypal_sdt.length < 1) {
                    alertify.warning('Số điện thoại bị bỏ trống');
                    return false;
                } else if (paypal_email.length < 1) {
                    alertify.warning('Email bị bỏ trống');
                    return false;
                } else if (paypal_diachi.length < 1) {
                    alertify.warning('Địa chỉ bị bỏ trống');
                    return false;
                } else {
                    // This function sets up the details of the transaction, including the amount and line item details.
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                currency_code: 'USD',
                                value: '{{ round(Session::get('GioHangOnline')->Total / 23000, 2) }}', // Lấy tổng thành tiền của hóa đơn để thanh toán thông qua session và chia cho 23.000 VNĐ để chuyên.

                            }
                        }]
                    });
                }

            },

            //Hàm chạy sau khi chấp nhận thành toán của pay pal
            onApprove: function(data, actions) {

                // Authorize the transaction
                actions.order.authorize().then(function(authorization) {

                    // Get the authorization id
                    var authorizationID = authorization.purchase_units[0]
                        .payments.authorizations[0].id

                    // Call your server to validate and capture the transaction
                    return fetch('/paypal-transaction-complete', {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            authorizationID: authorizationID
                        })

                    });
                });




                // This function captures the funds from the transaction.
                // Hàm xử lý kết quả sau khi thanh toán thành công
                return actions.order.capture().then(function(details) {

                    //Biến trạng thái của thanh toán paypal.
                    var paypal_trangthai = 4;
                    var paypal_ten = $('#hoten').val();
                    var paypal_sdt = $('#SDT').val();
                    var paypal_email = $('#email').val();
                    var paypal_diachi = $('#diachi').val();
                    var paypal_ghichu = $('#ghichu').val();

                    //Tạo form cho phương thức get sau khi thanh toán thành công.
                    var formReturnHome = document.createElement('form');
                    formReturnHome.method = 'GET';
                    formReturnHome.action = "{{ route('GioHang.viewAfterCheckOut') }}";
                    document.body.appendChild(formReturnHome);

                    //PHương thức ajax gửi form mua hàng sau khi khách hàng chấp thuận thanh toán.
                    $.ajax({
                        url: "/dat-pay-pal",
                        method: "POST",
                        data: {
                            hoten: paypal_ten,
                            sdt: paypal_sdt,
                            diachi: paypal_diachi,
                            email: paypal_email,
                            ghichu: paypal_ghichu,
                            trangthai: paypal_trangthai,
                            _token: $("input[name='_token']").val(),
                        },
                        success: function(data) {
                            //Hiện confirm box thông báo đã thành toán thành công và chuyển sang trang chủ sau khi nhấp 'OK'.
                            alertify.alert()
                                .setting({
                                    'title': 'THÀNH TOÁN PAYPAL',
                                    'label': 'Ok',
                                    'message': data.success +

                                        "\n Cảm ơn bạn " + details
                                        .payer.name
                                        .given_name + " đã thanh toán đơn hàng. \n",
                                    'transition': 'flipy',
                                    'onclose': function() {
                                        formReturnHome.submit();
                                    }
                                }).show();
                        },
                        errors: function(data) {
                            alertify.error("Lỗi Tải Trang thanh toans");
                        }
                    });





                });

            }



        }).render('#paypal-button-container');
        //This function displays Smart Payment Buttons on your web page.
    </script>
@endsection
