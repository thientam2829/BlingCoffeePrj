<form method="POST">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <div class="form-check">
                    <label>Trạng Thái </label>
                    <input type="checkbox" name="trangthai" value='1' class="form-check-input" checked="">
                </div>
            </div>
            <div class="form-group">
                <label>Tên Khuyến Mãi<b style="color:red"> *</b></label>
                <input type="text" class='form-control' maxlength="100" name="tenkhuyenmai">
            </div>
            <div class="form-group">
                <label>Thời Gian Bắt Đầu<b style="color:red"> *</b></label>
                <input type="date" class='form-control' name="thoigianbatdau">
            </div>
            <div class="form-group">
                <label>Thời Gia Kết Thúc<b style="color:red"> *</b></label>
                <input type="date" class='form-control' name="thoigianketthuc">
            </div>
            <div class="form-group">
                <label>Mô Tả<b style="color:red"> *</b></label>
                <textarea type="text" class='form-control' name="mota"></textarea>
            </div>
            <button id="form-create" data-url="{{ route('khuyen-mai.store') }}" type="submit" class="btn btn-success" style="width: 100%">Thêm</button>
        </div>
    </div>
</form>
