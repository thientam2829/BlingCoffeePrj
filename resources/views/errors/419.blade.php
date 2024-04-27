<!DOCTYPE html>
<html lang="vi">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Bling Coffee</title>
    <link rel="icon" href="{{ asset('/backend/img/mini_logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}" /> {{-- bootstrap --}}
    <link rel="stylesheet" href="{{ asset('backend/vendors/font_awesome/css/all.min.css') }}" /> {{-- icon --}}
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/css/css.css') }}" />
</head>

<body>
    <div class="erroe_page_wrapper">
        <div class="errow_wrap">
            <div class="container text-center">
                <img src="{{ asset('uploads/Logo/sad.png') }}" alt="">
                <div class="error_heading  text-center">
                    <h3 class="headline font-danger theme_color_6">419</h3>
                </div>
                <div class="col-md-8 offset-md-2 text-center">
                    <p>Trang bạn đang cố gắng truy cập hiện không có sẵn. Điều này có thể là do trang không tồn tại hoặc đã bị di chuyển.</p>
                </div>
                <div class="error_btn  text-center">
                    <a class=" default_btn theme_bg_6 " href="{{ route('Trangchu.index') }}">Về Trang Chủ</a>
                </div>
            </div>
        </div>
    </div>

    <!-- footer  -->
    <script src="{{ asset('backend/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>

</body>

</html>
