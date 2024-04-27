<form method="POST"> 
    <div class="row">
        <div class="col-lg-12">
            <input type="text" name="id_loaisanpham" value="{{ $QuyCach->id_loaisanpham }}" hidden>
            <div class="form-group">
                <label>Trạng Thái<b style="color:red"> *</b></label>
                <select class="form-control" name="trangthai">
                    <option value="1" {{ $QuyCach->trangthai == 1 ? 'selected' : '' }}>Được Phép Thêm Sản Phẩm</option>
                    <option value="2" {{ $QuyCach->trangthai == 2 ? 'selected' : '' }}>Hiện Đại Diện Trên Website</option>
                    <option value="0" {{ $QuyCach->trangthai == 0 ? 'selected' : '' }}>Không Được Phép Thêm Sản Phẩm</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tên Quy Cách<b style="color:red"> *</b></label>
                <input type="text" class='form-control' maxlength="50" name="tenquycach" value="{{ $QuyCach->tenquycach }}">
            </div>
            <button id="form-editQC" data-url="{{ route('quy-cach.update', $QuyCach->id) }}" type="submit" class="btn btn-success" style="width: 100%">Cập Nhật</button>
        </div>
    </div>
</form>
