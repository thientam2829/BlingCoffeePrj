<form method="POST">
    <input hidden type="number" class='form-control' name="diemtichluy" value="0" required>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <div class="form-check">
                    <label>Trạng Thái </label>
                    <input type="checkbox" name="trangthai" value='1' class="form-check-input" checked="">
                </div>
            </div>
            <div class="form-group">
                <label>Họ Tên<b style="color:red"> *</b></label>
                <input type="int" class='form-control' maxlength="50" name="tenkhachhang" required>
            </div>
            <div class="form-group">
                <label>Số Điện Thoại<b style="color:red"> *</b></label>
                <input type="number" class='form-control' id="SDT" name="sdt" required>
            </div>
            <div class="form-group">
                <label>Email<b style="color:red"> *</b></label>
                <input type="email" class='form-control' name="email" required>
            </div>
            <div class="form-group">
                <label>Địa Chỉ<b style="color:red"> *</b></label>
                <textarea type="text" class='form-control' maxlength="150" name="diachi" required></textarea>
            </div>
            <button id="form-create" data-url="{{ route('khach-hang.store') }}" type="submit" class="btn btn-success" style="width: 100%">Thêm</button>
        </div>
    </div>
</form>
