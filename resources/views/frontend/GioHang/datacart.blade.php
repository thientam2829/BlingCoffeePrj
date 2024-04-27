@if (Session::has('GioHangOnline') != null)
    <div class="billing-form ftco-bg-dark ftco-bg-dark-info p-3 p-md-5">
        <h3 class="mb-4 billing-heading billing-heading-center">Thông Tin Giỏ Hàng</h3>
        <table class="info-product ">
            <thead>
                <tr class="text-center">
                    <th>SẢN PHẨM</th>
                    <th>GIÁ BÁN</th>
                    <th>SL</th>
                    <th>T.TIỀN</th>
                </tr>
            </thead>
            <tbody class="info-product-tbody">
                @foreach (Session::get('GioHangOnline')->products as $item) {{-- danh sách sản phẩm --}}
                    <tr class="text-center">
                        <td class="text-left">
                            <span> {{ $item['SanPham']->tensanpham . ' (' . $item['CTSP']->tenquycach . ')' }}</span>
                        </td>
                        <td>
                            @if ($item['GiamGia'] > 0)
                                <span>{{ number_format($item['CTSP']->giasanpham - $item['GiamGia'], 0, ',', '.') . ' VNĐ' }}</span><br>
                                <span class="discount">{{ number_format($item['CTSP']->giasanpham, 0, ',', '.') . ' VNĐ' }}</span>
                            @else
                                <span>{{ number_format($item['CTSP']->giasanpham, 0, ',', '.') . ' VNĐ' }}</span>
                            @endif
                        </td>
                        <td>
                            <span>{{ $item['SoLuong'] }}</span>
                        </td>
                        <td><span>{{ number_format($item['TongGia'], 0, ',', '.') . ' VNĐ' }}</span></td>
                    </tr><!-- END TR-->
                @endforeach
            </tbody>
        </table>
        <table class="info-product2">
            <thead>
                <th>TỔNG TIỀN</th>
                <th>ĐÃ GIẢM</th>
                @if (Session::get('GioHangOnline')->PhoneMember != null)
                    <th>GG.THÀNH VIÊN</th>
                @endif
                <th>THÀNH TIỀN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ number_format(Session::get('GioHangOnline')->totalPrice, 0, ',', '.') . ' VNĐ' }}</td>
                    <td>{{ number_format(Session::get('GioHangOnline')->totalDiscount, 0, ',', '.') . ' VNĐ' }}</td>
                    @if (Session::get('GioHangOnline')->PhoneMember != null)
                        <td>{{ number_format(Session::get('GioHangOnline')->DiscountMember, 0, ',', '.') . ' VNĐ' }}</td>
                    @endif
                    <td class="info-product2-color">{{ number_format(Session::get('GioHangOnline')->Total, 0, ',', '.') . ' VNĐ' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endif
