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
    <p style="margin: 15px 0px 35px 0px;">Chúng tôi đã duyệt bình luận và trả lời bình luận của bạn. Đây là toàn bộ nội dung bình luận:</p>

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

    <p style="margin: 7px 0px;">Cảm ơn bạn rất nhiều!</p>
    <p style="margin: 7px 0px;">Trân trọng,</p>
    <p style="margin: 7px 0px;">Bling Coffee.</p>
</body>

</html>
