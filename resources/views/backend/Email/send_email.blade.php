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

        table {
            border-collapse: collapse;
            border: 1px solid black;
            table-layout: auto;
            width: 50%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px 10px;
            text-transform: uppercase;
        }

    </style>
</head>

<body>
    <p style="margin: 0;margin-bottom: 35px;">Chào bạn <span style="text-transform: capitalize;">{{ $HoaDon->tenkhachhang }}</span>,</p>
    <p style="margin: 0;margin-bottom: 15px;">Vào lúc {{ Date_format(Date_create($HoaDon->ngaylap), 'd/m/Y H:i:s') }} bạn đã đặt hàng tại
        <a style=" text-decoration: none; color: blue" href="{{ route('Trangchu.index') }}">Bling Coffee</a> với các sản phẩm.
    </p>
    <table>
        <thead>
            <tr>
                <th><samp>Sản Phẩm</samp></th>
                <th><samp>Giá bán</samp></th>
                <th><samp>SL</samp></th>
                <th><samp>T.Tiền</samp></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ChiTietHoaDon as $item)
                <tr>
                    <td><samp>{{ $item->tensanpham . ' ' . $item->tenquycach }}</samp></td>
                    @if ($item->giamgia != 0)
                        <td style="text-align: right">
                            <samp>{{ number_format($item->giasanpham - $item->giamgia, 0, ',', '.') }} VNĐ</samp><br>
                            <samp style="text-decoration: line-through;">{{ number_format($item->giasanpham, 0, ',', '.') }} VNĐ</samp>
                        </td>
                    @else
                        <td style="text-align: right"><samp>{{ number_format($item->giasanpham, 0, ',', '.') }} VNĐ</samp></td>
                    @endif
                    <td style="text-align: center"><samp>{{ number_format($item->soluong, 0, ',', '.') }}</samp></td>
                    <td style="text-align: right"><samp>{{ number_format($item->tonggia, 0, ',', '.') }} VNĐ</samp></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin: 20px 0px 7px 0px;">Tổng Tiền: {{ number_format($HoaDon->tongtienhoadon, 0, ',', '.') }} VNĐ</p>
    <p style="margin: 7px 0px;">Giảm giá: {{ number_format($HoaDon->giamgia, 0, ',', '.') }} VNĐ</p>
    @if ($HoaDon->tongtienhoadon - $HoaDon->giamgia - $HoaDon->thanhtien != 0)
        <p style="margin: 7px 0px;">Giảm giá thành viên: {{ number_format($HoaDon->tongtienhoadon - $HoaDon->giamgia - $HoaDon->thanhtien, 0, ',', '.') }} VNĐ
            @if (isset($KhachHang))
                @if ($KhachHang->diemtichluy >= 100000)
                    (10% tiền thanh toán)
                @elseif($KhachHang->diemtichluy >= 10000)
                    (5% tiền thanh toán)
                @elseif($KhachHang->diemtichluy >= 5000)
                    (3% tiền thanh toán)
                @elseif($KhachHang->diemtichluy >= 1000)
                    (1% tiền thanh toán)
                @else
                @endif
            @endif
        </p>
    @endif
    <p style="margin: 7px 0px;">Thành tiền: {{ number_format($HoaDon->thanhtien, 0, ',', '.') }} VNĐ</p>
    <p style="margin: 7px 0px;">@if ($HoaDon->hinhthucthanhtoan != null)Đã thanh toán qua {{$HoaDon->hinhthucthanhtoan}}@endif</p>
    @if ($HoaDon->tongtienhoadon - $HoaDon->giamgia - $HoaDon->thanhtien != 0)
        <p style="margin: 15px 0px 35px 0px;">Với hóa đơn này bạn được cộng {{ number_format($HoaDon->diemtichluy, 0, ',', '.') }} điểm tích lũy.
            Tổng điểm tích lũy của bạn là {{ number_format($KhachHang->diemtichluy, 0, ',', '.') }} điểm
            @if ($KhachHang->diemtichluy >= 100000)
                bạn sẽ được giảm 10%
            @elseif($KhachHang->diemtichluy >= 10000)
                bạn sẽ được giảm 5%
            @elseif($KhachHang->diemtichluy >= 5000)
                bạn sẽ được giảm 3%
            @elseif($KhachHang->diemtichluy >= 1000)
                bạn sẽ được giảm 1%
            @else
                khi đủ 1.000 điểm tích lũy bạn sẽ được giảm 1%
            @endif
            tiền thanh toán khi mua hàng tại <a style=" text-decoration: none; color: blue" href="{{ route('Trangchu.index') }}">Bling Coffee</a>.
        </p>
    @else
        <p style="margin: 15px 0px 35px 0px;">Chúng tôi sẽ sớm giao hàng cho bạn.</p>
    @endif
    <p style="margin: 7px 0px;">Cảm ơn bạn rất nhiều!</p>
    <p style="margin: 7px 0px;">Trân trọng,</p>
    <p style="margin: 7px 0px;">Bling Coffee.</p>
</body>

</html>
