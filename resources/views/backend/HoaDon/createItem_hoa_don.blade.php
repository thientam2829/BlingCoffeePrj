@if (Session::has('GioHang') != null)
    <table class="table mb-0" style="text-align: right">
        <thead>
            <tr>
                <th class="border-top-0" style="text-align: left">Sản Phẩm</th>
                <th class="border-top-0">Giá Bán</th>
                <th class="border-top-0">Giảm Giá</th>
                <th class="border-top-0">Số Lượng</th>
                <th class="border-top-0">Tổng Cộng</th>
                <th class="border-top-0" style="text-align: center">Thao Tác</th>
            </tr>
        </thead>
        <tbody id="value-update-all">
            @foreach (Session::get('GioHang')->products as $item)
                <tr>
                    <td style="text-align: left"><img src="{{ asset('uploads/SanPham/' . $item['SanPham']->hinhanh) }}" alt="image" width="60" height="60">
                        <p style="padding-left: 10px" class="d-inline-block align-middle mb-0 f_s_19 f_w_700 color_theme2">
                            {{ $item['SanPham']->tensanpham }}<br><span class="text-muted font_s_13">{{ $item['CTSP']->tenquycach }}</span>
                        </p>
                    </td>
                    <td>{{ number_format($item['CTSP']->giasanpham, 0, ',', '.') }} VNĐ
                    </td>
                    <td>
                        @if ($item['GiamGia'] > 0)
                            {{ number_format($item['GiamGia'], 0, ',', '.') }} VNĐ
                        @else

                        @endif
                    </td>
                    <td style="width: 70px;padding-left: 30px;"><input id="SoLuongSanPham" data-id="{{ $item['CTSP']->id }}" type="number" class="form-control" value="{{ $item['SoLuong'] }}">
                    </td>
                    <td>{{ number_format($item['TongGia'], 0, ',', '.') }} VNĐ</td>
                    <td style="text-align: center">
                        <a href="javascript:(0)" data-id="{{ $item['CTSP']->id }}" class="action_btn deleteItemHoaDon">
                            <i class="fas fa-times-circle"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <div class="d-flex mt_10 justify-content-center">
        <p class="text-center"><a href="javascript:(0)" id="update-all" class="btn btn-warning mr_10">Cập Nhật Số Lượng</a></p>
        <p class="text-center"><a href="javascript:(0)" id="delete-all" class="btn btn-warning mr_10">Xóa Tất Cả</a></p>
        <p class="text-center"><a href="javascript:(0)" onclick="showModalAddMember()" id="add-member" class="btn btn-warning">Tìm Khách Mua Hàng</a></p>
    </div>
    <input hidden type="text" id="soluong" value="{{ number_format(Session::get('GioHang')->totalQuanty, 0, ',', '.') }}">
    <input hidden type="text" id="tongcong" value="{{ number_format(Session::get('GioHang')->totalPrice, 0, ',', '.') }}">
    <input hidden type="text" id="giamgia" value="{{ number_format(Session::get('GioHang')->totalDiscount, 0, ',', '.') }}">
    <input hidden type="text" id="giamgiathanhvien" value="{{ number_format(Session::get('GioHang')->DiscountMember, 0, ',', '.') }}">
    <input hidden type="text" id="thanhtien" value="{{ number_format(Session::get('GioHang')->Total, 0, ',', '.') }}">
@else
    <table class="table mb-0" style="text-align: center">
        <thead>
            <tr>
                <th class="border-top-0" style="text-align: left">Sản Phẩm</th>
                <th class="border-top-0">Giá Bán</th>
                <th class="border-top-0">Giảm Giá</th>
                <th class="border-top-0">Số Lượng</th>
                <th class="border-top-0">Tổng Cộng</th>
                <th class="border-top-0">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <input hidden type="text" id="tongcong" value="0">
    </table>
@endif
