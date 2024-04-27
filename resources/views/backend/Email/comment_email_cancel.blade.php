<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 20px;
            width: 100%;
        }

        .rowuser {
            margin-top: 30px;
        }

        div#listreply {
            margin-left: 30px;
        }

    </style>
</head>

<body>
    <p style="margin: 0;margin-bottom: 35px;">Chào bạn <span style="text-transform: capitalize;">{{ $TimBinhLuan->hoten }}</span>,</p>
    <p style="margin: 0;margin-bottom: 15px;">Vào lúc {{ Date_format(Date_create($TimBinhLuan->thoigian), 'd/m/Y H:i:s') }} bạn đã bình luận tại
        <a style=" text-decoration: none; color: blue" href="{{ route('Trangchu.index') }}">Bling Coffee</a> với nội dung: "{{ $TimBinhLuan->noidung }}"
    </p>
    <p style="margin: 15px 0px 35px 0px;">Chúng tôi thật tiết khi nội dung bình luận của bạn đã vi phạm quy định đăng bình luận của chúng tôi. Đây là toàn bộ nội dung bình luận:</p>
    <div class="comment" style="margin: 15px 0px 35px 0px;">
        <div class="rowuser">
            <img src="{{ asset('uploads/NhanVien/NOIMAGE.png') }}" alt="" style="width: 25px"> {{ $BinhLuan->hoten }} - {{ Date_format(Date_create($BinhLuan->thoigian), 'd/m/Y H:i:s') }}
        </div>
        <div class="question" style="margin-top: 10px;">
            {{ $BinhLuan->noidung }}
        </div>
        <div id="listreply">
            @isset($TraLoi)
                @foreach ($TraLoi as $item)
                    <div class="rowuser">
                        @if ($item->trangthai == 2)
                            <img src="{{ asset('uploads/Logo/logo_bling_coffee.png') }}" alt="" style="width: 25px">
                        @else
                            <img src="{{ asset('uploads/NhanVien/NOIMAGE.png') }}" alt="" style="width: 25px">
                        @endif
                        {{ $item->hoten }} - {{ Date_format(Date_create($item->thoigian), 'd/m/Y H:i:s') }}
                    </div>
                    <div class="question" style="margin-top: 10px;">
                        {{ $item->noidung }}
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
    <p style="margin: 15px 0px">Quy định đăng bình luận:</p>
    <p style="margin: 7px 0px;">- Thông tin viết giống nhau lặp đi lặp lại.</p>
    <p style="margin: 7px 0px;">- Thông tin không liên quan gì đến nội dung của sản phẩm, dịch vụ cần bình luận.</p>
    <p style="margin: 7px 0px;">- Thông tin xâm hại đến quyền lợi hoặc đời tư của người khác.</p>
    <p style="margin: 7px 0px;">- Thông tin mang tính bài xích, gây tổn thương đến người khác.</p>
    <p style="margin: 7px 0px;">- Thông tin có liên quan đến các hành vi tội phạm.</p>
    <p style="margin: 7px 0px;">- Nhưng thông tin vi phạm đạo đức, thuần phong mỹ tục của Việt Nam và các nước khác.</p>
    <p style="margin: 7px 0px;">- Thông tin có liên quan đến những việc nguy hiểm.</p>
    <p style="margin: 7px 0px;">- Thông tin mang tính trục lợi, thương mại cá nhân, tuyên truyền quảng cáo.</p>
    <p style="margin: 7px 0px;">- Thông tin liên quan đến chính trị, tôn giáo</p>
    <p style="margin: 7px 0px;">- Đặt tên hoặc bình luận không rõ nội dung.</p>
    <p style="margin: 7px 0px;">- Thông tin ảnh hưởng đến công việc kinh doanh của <a style=" text-decoration: none; color: blue" href="{{ route('Trangchu.index') }}">Bling Coffee</a>.</p>
    <p style="margin: 7px 0px 35px 0px;">- Những thông tin khác mà công ty chúng tôi cho rằng không hợp lý khi đăng tải lên <a style=" text-decoration: none; color: blue"
            href="{{ route('Trangchu.index') }}">Bling Coffee</a>.</p>

    <p style="margin: 7px 0px;">Cảm ơn bạn rất nhiều!</p>
    <p style="margin: 7px 0px;">Trân trọng,</p>
    <p style="margin: 7px 0px;">Bling Coffee.</p>
</body>

</html>
