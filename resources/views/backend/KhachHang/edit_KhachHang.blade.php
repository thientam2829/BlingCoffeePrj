<form method="POST">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <div class="form-check">
                    <label>Trạng Thái </label>
                    <input type="checkbox" name="trangthai" value='1' class="form-check-input" {{ $KhachHang->trangthai == 1 ? 'checked' : '' }}>
                </div>
            </div>
            <div class="form-group">
                <label>Họ Tên<b style="color:red"> *</b></label>
                <input type="int" class='form-control' maxlength="50" name="tenkhachhang" required value="{{ $KhachHang->tenkhachhang }}">
            </div>
            <div class="form-group">
                <label>Số Điện Thoại<b style="color:red"> *</b></label>
                <input type="number" class='form-control' id="SDT" name="sdt" required value="{{ $KhachHang->sdt }}">
            </div>
            <div class="form-group">
                <label>Email<b style="color:red"> *</b></label>
                <input type="email" class='form-control' name="email" required value="{{ $KhachHang->email }}">
            </div>
            <div class="form-group">
                <label>Điểm Tích Lũy<b style="color:red"> *</b></label>
                <input type="text" class='money form-control' name="diemtichluy" required value="{{ $KhachHang->diemtichluy }}">
            </div>
            <div class="form-group">
                <label>Địa Chỉ<b style="color:red"> *</b></label>
                <textarea type="text" class='form-control' maxlength="150" name="diachi" required>{{ $KhachHang->diachi }}</textarea>
            </div>
            <button id="form-edit" data-url="{{ route('khach-hang.update', $KhachHang->id) }}" data-id="{{ $KhachHang->id }}" type="submit" class="btn btn-success" style="width: 100%">Cập
                Nhật</button>
        </div>
    </div>
</form>
