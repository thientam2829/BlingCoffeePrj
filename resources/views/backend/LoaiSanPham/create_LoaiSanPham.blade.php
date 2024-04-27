<form method="POST">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label>Trạng Thái<b style="color:red"> *</b></label>
                <select class="form-control" name="trangthai">
                    <option value="1">Sản phẩm Có Hạn Sử Dụng</option>
                    <option value="2">Sản Phẩm Dùng Trong Ngày</option>
                    <option value="0">Không Được Phép Thêm Sản Phẩm</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tên Loại Sản Phẩm</label>
                <input type="text" class='form-control' maxlength="50" name="tenloaisanpham" required>
            </div>
            <button id="form-create" data-url="{{ route('loai-san-pham.store') }}" type="submit" class="btn btn-success" style="width: 100%">Thêm</button>
        </div>
    </div>
</form>
