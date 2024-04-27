@if (isset($KhachMuaHang))
    <h4 class="mt_30"><b>Họ Tên: </b> <span>{{ $KhachMuaHang->tenkhachhang }}</span></h4>
    <h4><b>SĐT: </b> <span>{{ $KhachMuaHang->sdt }}</span></h4>
    <h4><b>Địa Chỉ: </b> <span>{{ $KhachMuaHang->diachi }}</span></h4>
    <h4><b>Email: </b> <span>{{ $KhachMuaHang->email }}</span></h4>
    <h4><b>Điểm Tích Lũy: </b> <span>{{ number_format($KhachMuaHang->diemtichluy, 0, ',', '.') . ' Điểm' }}</span></h4>
    @if ($KhachMuaHang->trangthai == 1)
        <h4><b>Được Giảm: </b> <span>
                {{-- // 1%       3%      5%          10%
                    // 1,000    5,000   10,000     100,000 --}}
                @if ($KhachMuaHang->diemtichluy >= 100000)
                    10% Tiền Thanh Toán
                @elseif($KhachMuaHang->diemtichluy >= 10000)
                    5% Tiền Thanh Toán
                @elseif($KhachMuaHang->diemtichluy >= 5000)
                    3% Tiền Thanh Toán
                @elseif($KhachMuaHang->diemtichluy >= 1000)
                    1% Tiền Thanh Toán
                @else
                    0% Tiền Thanh Toán
                @endif
            </span></h4>
        <p class="text-center"><a href="javascript:(0)" onclick="apdung('{{ $KhachMuaHang->sdt }}')" id="apdung" class="btn btn-primary  mt_30">Áp Dụng Thành Viên</a></p>
        <p class="text-center"><a href="javascript:(0)" onclick="boapdung()" id="boapdung" class="btn btn-danger  mt_30" style="display: none;">Bỏ Áp Dụng Thành Viên</a></p>
    @else
        <h4 class="text-center mt_30"><b style="color: red;">Khách Hàng Đã Bị Khóa</b></h4>
    @endif

@else
    <p class="text-center mt_50"><a href="javascript:(0)" onclick="themkh()" id="themkh" class="btn btn-success">Thêm Khách Hàng Mới</a></p>
@endif
