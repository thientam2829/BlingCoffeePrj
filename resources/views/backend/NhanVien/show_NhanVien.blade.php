@isset($NhanVien)
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-4 col-sm-4">
                    <img src="{{ asset('uploads/NhanVien/' . $NhanVien->hinhanh) }}" style="width: 250px; height: 250px; border-radius: 5px;">
                </div>
                <div class="col-8 col-sm-8">
                    <h4><b>{{ $NhanVien->tennhanvien }} </b> <span>({{ $NhanVien->id }})</span></h4>
                    <h4><b>SĐT: </b> <span>{{ $NhanVien->sdt }}</span></h4>
                    <h4><b>Email: </b> <span>{{ $NhanVien->email }}</span></h4>
                    <h4><b>Lương: </b> <span>{{ number_format($NhanVien->luong, 0, ',', '.') . ' VNĐ' }}</span></h4>
                    <h4><b>Giới Tính: </b> <span>{{ $NhanVien->gioitinh == 1 ? 'Nam' : 'Nữ' }}</span></h4>
                    <h4><b>Ngày Sinh: </b> <span>{{ Date_format(Date_create($NhanVien->ngaysinh), 'd/m/Y') }}</span></h4>
                    <h4><b>Loại Nhân Viên: </b> <span>
                            @if (isset($LoaiNhanVien))
                                @foreach ($LoaiNhanVien as $valuelnv)
                                    @if ($NhanVien->id_loainhanvien == $valuelnv->id)
                                        {{ $valuelnv->tenloainhanvien }}
                                    @endif
                                @endforeach
                            @endif
                        </span></h4>
                    <h4><b>Trạng Thái: </b> <span>{{ $NhanVien->trangthai == 1 ? 'Còn Làm' : 'Đã Nghỉ' }}</span></h4>
                    <h4><b>Địa Chỉ: </b> <span>{{ $NhanVien->diachi }}</span></h4>
                </div>
            </div>
        </div>
    </div>
@endisset
