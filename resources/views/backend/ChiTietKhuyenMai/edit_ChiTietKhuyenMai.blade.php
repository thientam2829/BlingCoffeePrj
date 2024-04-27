<form method="POST">
    <div class="row">
        <div class="col-lg-12">
            <h4 style="text-align: center">{{ $KhuyenMai->tenkhuyenmai }}</h4>
            <input type="text" name="id_khuyenmai" value="{{ $ChiTietKhuyenMai->id_khuyenmai }}" hidden>
            <h4 style="text-align: center">
                @isset($ChiTietSanPham)
                    {{ $ChiTietSanPham->tensanpham }} {{ ' (' . $ChiTietSanPham->tenquycach . ')' }}
                @endisset
            </h4>
            <input type="text" name="id_chitietsanpham" value="{{ $ChiTietKhuyenMai->id_chitietsanpham }}" hidden>
            <div class="form-group">
                <label>Mức Khuyến Mãi(%)<b style="color:red"> *</b></label>
                <input type="number" class='form-control' name="muckhuyenmai" value="{{ $ChiTietKhuyenMai->muckhuyenmai }}">
            </div>
            <button id="form-edit-CTKM" class="btn btn-success" type="submit" style="width: 100%" data-idctsp="{{ $ChiTietKhuyenMai->id_chitietsanpham }}"
                data-idkm="{{ $ChiTietKhuyenMai->id_khuyenmai }}">Cập Nhật</button>
        </div>
    </div>
</form>
