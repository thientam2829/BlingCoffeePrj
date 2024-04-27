<form method="POST">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <div class="form-check">
                    <label>Trạng Thái </label>
                    <input type="checkbox" value='1' class="form-check-input" name="trangthai" checked="">
                </div>
            </div>
            <div class="form-group">
                <label>Tên Loại Nhân Viên<b style="color:red"> *</b></label>
                <input type="text" class='form-control' maxlength="50" name="tenloainhanvien">
            </div>
            <button id="form-create" data-url="{{ route('loai-nhan-vien.store') }}" type="submit" class="btn btn-success"
                style="width: 100%">Thêm</button>
        </div>
    </div>
</form>
