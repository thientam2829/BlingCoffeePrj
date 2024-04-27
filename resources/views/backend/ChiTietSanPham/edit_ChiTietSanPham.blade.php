<form method="POST">
    @isset($LoaiSanPham)
        @if ($LoaiSanPham->trangthai == 1) {{-- có hạn sử dụng --}}
            <div class="row">
                <div class="col-lg-12">
                    <input type="text" name="id_sanpham" value="{{ $ChiTietSanPham->id_sanpham }}" hidden>
                    <div class="form-group">
                        <div class="form-check">
                            <label>Trạng Thái </label>
                            <input type="checkbox" name="trangthai" value='1' class="form-check-input" {{ $ChiTietSanPham->trangthai == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Quy Cách<b style="color:red"> *</b></label>
                        <select class="form-control" name="kichthuoc" id="kichthuocquycach">
                            @isset($QuyCach)
                                @foreach ($QuyCach as $itemQC)
                                    <option value="{{ $itemQC->id }}" {{ $ChiTietSanPham->kichthuoc == $itemQC->id ? 'selected' : '' }}>{{ $itemQC->tenquycach }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Số Lượng<b style="color:red"> *</b></label>
                        <input type="text" class='form-control money' name="soluong" value="{{ $ChiTietSanPham->soluong }}">
                    </div>
                    <div class="form-group">
                        <label>Giá Sản Phẩm<b style="color:red"> *</b></label>
                        <input type="text" class='form-control money' name="giasanpham" value="{{ $ChiTietSanPham->giasanpham }}">
                    </div>
                    <div class="form-group">
                        <label>Ngày Sản Xuất<b style="color:red"> *</b></label>
                        <input type="date" class='form-control' name="ngaysanxuat" value="{{ $ChiTietSanPham->ngaysanxuat }}">
                    </div>
                    <div class="form-group">
                        <label>Hạn Sử Dụng<b style="color:red"> *</b></label>
                        <input type="date" class='form-control' name="hansudung" value="{{ $ChiTietSanPham->hansudung }}">
                    </div>
                    <button id="form-edit-CTSP" data-url="{{ route('chi-tiet-san-pham.update', $ChiTietSanPham->id) }}" type="submit" class="btn btn-success" style="width: 100%">Cập Nhật</button>
                </div>
            </div>
            @else{{-- có hạng sử dụng --}}
            <div class="row">
                <div class="col-lg-12">
                    <input type="text" name="id_sanpham" value="{{ $ChiTietSanPham->id_sanpham }}" hidden>
                    <input type="text" class='form-control money' name="soluong" value="2000000000" hidden>
                    <input type="date" class='form-control' name="ngaysanxuat" value="1000-01-01" hidden>
                    <input type="date" class='form-control' name="hansudung" value="9999-12-31" hidden>
                    <div class="form-group">
                        <div class="form-check">
                            <label>Trạng Thái </label>
                            <input type="checkbox" name="trangthai" value='1' class="form-check-input" {{ $ChiTietSanPham->trangthai == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Quy Cách<b style="color:red"> *</b></label>
                        <select class="form-control" name="kichthuoc">
                            @isset($QuyCach)
                                @foreach ($QuyCach as $itemQC)
                                    <option value="{{ $itemQC->id }}" {{ $ChiTietSanPham->kichthuoc == $itemQC->id ? 'selected' : '' }}>{{ $itemQC->tenquycach }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Giá Sản Phẩm<b style="color:red"> *</b></label>
                        <input type="text" class='form-control money' name="giasanpham" value="{{ $ChiTietSanPham->giasanpham }}">
                    </div>
                    <button id="form-edit-CTSP" data-url="{{ route('chi-tiet-san-pham.update', $ChiTietSanPham->id) }}" type="submit" class="btn btn-success" style="width: 100%">Cập Nhật</button>
                </div>
            </div>
        @endif
    @endisset
</form>
