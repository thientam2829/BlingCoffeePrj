<form method="POST">
    @isset($LoaiSanPham)
        @if ($LoaiSanPham->trangthai == 1) {{-- có hạn sử dụng --}}
            <div class="row">
                <div class="col-lg-12">
                    <input type="text" name="id_sanpham" value="{{ $SanPham->id }}" hidden>
                    <div class="form-group">
                        <div class="form-check">
                            <label>Trạng Thái </label>
                            <input type="checkbox" name="trangthai" value='1' class="form-check-input" checked="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Quy Cách<b style="color:red"> *</b></label>
                        <select class="form-control" name="kichthuoc">
                            @isset($QuyCach)
                                @foreach ($QuyCach as $itemQC)
                                    <option value="{{ $itemQC->id }}">{{ $itemQC->tenquycach }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Số Lượng<b style="color:red"> *</b></label>
                        <input type="text" class='form-control money' name="soluong">
                    </div>
                    <div class="form-group">
                        <label>Giá Sản Phẩm<b style="color:red"> *</b></label>
                        <input type="text" class='form-control money' name="giasanpham">
                    </div>
                    <div class="form-group">
                        <label>Ngày Sản Xuất<b style="color:red"> *</b></label>
                        <input type="date" class='form-control' name="ngaysanxuat">
                    </div>
                    <div class="form-group">
                        <label>Hạn Sử Dụng<b style="color:red"> *</b></label>
                        <input type="date" class='form-control' name="hansudung">
                    </div>
                    <button id="form-create" data-url="{{ route('chi-tiet-san-pham.store') }}" type="submit" class="btn btn-success" style="width: 100%">Thêm</button>
                </div>
            </div>
            @else{{-- có hạng sử dụng --}}
            <div class="row">
                <div class="col-lg-12">
                    <input type="text" name="id_sanpham" value="{{ $SanPham->id }}" hidden>
                    <input type="text" class='form-control money' name="soluong" value="2000000000" hidden>
                    <input type="date" class='form-control' name="ngaysanxuat" value="1000-01-01" hidden>
                    <input type="date" class='form-control' name="hansudung" value="9999-12-31" hidden>
                    <div class="form-group">
                        <div class="form-check">
                            <label>Trạng Thái </label>
                            <input type="checkbox" name="trangthai" value='1' class="form-check-input" checked="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Quy Cách<b style="color:red"> *</b></label>
                        <select class="form-control" name="kichthuoc">
                            @isset($QuyCach)
                                @foreach ($QuyCach as $itemQC)
                                    <option value="{{ $itemQC->id }}">{{ $itemQC->tenquycach }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Giá Sản Phẩm<b style="color:red"> *</b></label>
                        <input type="text" class='form-control money' name="giasanpham">
                    </div>
                    <button id="form-create" data-url="{{ route('chi-tiet-san-pham.store') }}" type="submit" class="btn btn-success" style="width: 100%">Thêm</button>
                </div>
            </div>
        @endif
    @endisset
</form>
