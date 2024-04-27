@isset($DanhGia)
    <div class="row">
        <div class="col-sm-4">
            <img src="{{ asset('uploads/SanPham/' . $DanhGia->hinhanh) }}" style="width: 250px; border-radius: 5px;">
        </div>
        <div class="col-sm-7">
            <h4><b>Mã: </b> <span>{{ $DanhGia->id }}</span></h4>
            <h4><b>Họ Tên: </b> <span>{{ $DanhGia->hoten }}</span></h4>
            <h4><b>Email: </b> <span>{{ $DanhGia->email }}</span></h4>
            <h4><b>Sản Phẩm: </b> <span>{{ $DanhGia->tensanpham }}</span></h4>
            <h4><b>Thời Gian: </b> <span>{{ Date_format(Date_create($DanhGia->thoigian), 'd/m/Y H:i:s') }}</span></h4>
            <h4><b>Số Sao Đánh Giá: </b> <span>{{ $DanhGia->sosao }}</span></h4>
            <h4><b>Nội Dung: </b> <span>{{ $DanhGia->noidung }}</span></h4>
        </div>
    </div>
@endisset
