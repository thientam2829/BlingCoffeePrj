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
    <p style="margin: 0;margin-bottom: 35px;">Chào bạn <span style="text-transform: capitalize;">{{ $DanhGia->hoten }}</span>,</p>
    <p style="margin: 0;margin-bottom: 15px;">Vào lúc {{ Date_format(Date_create($DanhGia->thoigian), 'd/m/Y H:i:s') }} bạn đã đánh giá sản phẩm
        <a style=" text-decoration: none; color: blue" href="{{ route('SanPham.show', $DanhGia->id_sanpham) }}">{{ $SanPham->tensanpham }}</a> tại
        <a style=" text-decoration: none; color: blue" href="{{ route('Trangchu.index') }}">Bling Coffee</a> với {{ $DanhGia->sosao }} sao và nội dung là: "{{ $DanhGia->noidung }}"
    </p>
    <p style="margin: 15px 0px 35px 0px;">Chúng tôi đã duyệt đánh giá của bạn.</p>

    <p style="margin: 7px 0px;">Cảm ơn bạn rất nhiều!</p>
    <p style="margin: 7px 0px;">Trân trọng,</p>
    <p style="margin: 7px 0px;">Bling Coffee.</p>
</body>

</html>
