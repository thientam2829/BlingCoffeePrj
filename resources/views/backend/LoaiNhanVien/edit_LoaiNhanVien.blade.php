<form method="POST">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <div class="form-check">
                    <label>Trạng Thái </label>
                    <input type="checkbox" name="trangthai" value='1' class="form-check-input"
                        {{ $LoaiNhanVien->trangthai == 1 ? 'checked' : '' }}>
                </div>
            </div>
            <div class="form-group">
                <label>Tên Loại Nhân Viên<b style="color:red"> *</b></label>
                <input type="text" class='form-control' maxlength="50" name="tenloainhanvien"
                    value="{{ $LoaiNhanVien->tenloainhanvien }}">
            </div>
            <button id="form-edit" data-url="{{ route('loai-nhan-vien.update', $LoaiNhanVien->id) }}" type="submit"
                class="btn btn-success" style="width: 100%">Cập nhật</button>
        </div>
    </div>
</form>
