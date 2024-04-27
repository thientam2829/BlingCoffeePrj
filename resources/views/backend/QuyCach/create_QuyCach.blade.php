<form method="POST">
    <div class="row">
        <div class="col-lg-12">
            <input type="text" name="id_loaisanpham" value="{{ $id_loaisanpham }}" hidden>
            <div class="form-group">
                <label>Trạng Thái<b style="color:red"> *</b></label>
                <select class="form-control" name="trangthai">
                    <option value="1">Được Phép Thêm Sản Phẩm</option>
                    <option value="2">Hiện Đại Diện Trên Website</option>
                    <option value="0">Không Được Phép Thêm Sản Phẩm</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tên Quy Cách<b style="color:red"> *</b></label>
                <input type="text" class='form-control' maxlength="50" name="tenquycach">
            </div>
            <button id="form-createQC" data-url="{{ route('quy-cach.store') }}" type="submit" class="btn btn-success" style="width: 100%">Thêm</button>
        </div>
    </div>
</form>
