<form method="POST">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label>Trạng Thái<b style="color:red"> *</b></label>
                <select class="form-control" name="trangthai">
                    <option value="1" {{ $LoaiSanPham->trangthai == 1 ? 'selected' : '' }}>Sản phẩm Có Hạn Sử Dụng</option>
                    <option value="2" {{ $LoaiSanPham->trangthai == 2 ? 'selected' : '' }}>Sản Phẩm Dùng Trong Ngày</option>
                    <option value="0" {{ $LoaiSanPham->trangthai == 0 ? 'selected' : '' }}>Không Được Phép Thêm Sản Phẩm</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tên Loại Sản Phẩm</label>
                <input type="text" class='form-control' maxlength="50" name="tenloaisanpham" required value="{{ $LoaiSanPham->tenloaisanpham }}">
            </div>
            <button id="form-edit" data-url="{{ route('loai-san-pham.update', $LoaiSanPham->id) }}" data-id="{{ $LoaiSanPham->id }}" type="submit" class="btn btn-success" style="width: 100%">Cập
                Nhật</button>
        </div>
    </div>
</form>
