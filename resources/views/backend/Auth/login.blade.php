<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Bling Coffee - Đăng Nhập</title>

    <link rel="icon" href="{{ asset('uploads/Logo/logo_bling_coffee.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}" /> {{-- bootstrap --}}
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/alertifyjs/css/themes/default.min.css') }}">
</head>

<body class="crm_body_bg">
    <div class="row justify-content-center" style="margin-top: 100px">
        <div class="col-lg-6">
            {{-- Thông báo --}}
            @if (session('success'))
                <input type="text" class="Successful_message" id="Successful_message" value="{{ session('success') }}" hidden>
            @endif
            @if (session('errors'))
                <input type="text" class="Failure_message" id="Failure_message" value="{{ session('errors') }}" hidden>
            @endif
            {{--  --}}
            <div class="modal-content cs_modal">
                <div class="modal-header justify-content-center theme_bg_1">
                    <h5 class="modal-title text_white">Đăng Nhập</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('DangNhap') }}">
                        @csrf
                        <div class="form-group">
                            <input id="SDT" name="sdt" type="number" class="form-control" placeholder="Nhập Số Điện Thoại">
                        </div>
                        <div class="form-group">
                            <input name="password" type="password" class="form-control" placeholder="Mật Khẩu">
                        </div>
                        <button type="submit" class="btn_1 full_width text-center">Đăng Nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- footer  -->
    <script src="{{ asset('backend/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('frontend/alertifyjs/alertify.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#SDT").keypress(function() {
                if (this.value.length == 10) {
                    return false;
                }
            })
        });
        window.onload = function() {
            if ($('#Successful_message').hasClass('Successful_message')) {
                alertify.success($('#Successful_message').val());
            }
            if ($('#Failure_message').hasClass('Failure_message')) {
                alertify.error($('#Failure_message').val());
            }
        };
    </script>
</body>

</html>
