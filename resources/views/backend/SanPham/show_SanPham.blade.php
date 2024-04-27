@isset($SanPham)
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-3 col-sm-3">
                    <img src="{{ asset('uploads/SanPham/' . $SanPham->hinhanh) }}" style="width: 250px; border-radius: 5px;">
                </div>
                <div class="col-8 col-sm-8">
                    <h4><b>{{ $SanPham->tensanpham }} </b> <span>({{ $SanPham->id }})</span></h4>
                    <h4><b>Thẻ: </b> <span>{{ $SanPham->the }}</span></h4>
                    <h4><b>Loại Sản Phẩm: </b> <span>
                            @if (isset($LoaiSanPham))
                                {{ $LoaiSanPham->tenloaisanpham }}
                            @endif
                        </span></h4>
                    <h4><b>Trạng Thái: </b> <span>{{ $SanPham->trangthai == 1 ? 'Đang Bán' : 'Ngừng Bán' }}</span></h4>
                    <h4><b>Mô Tả: </b> <span>{{ $SanPham->mota }}</span></h4>
                </div>
            </div>
        </div>
    </div>
    <hr>
    {{-- chi tiết sảm phẩm --}}
    @isset($ChiTietSanPham)
        @isset($LoaiSanPham)
            @if ($LoaiSanPham->trangthai == 1) {{-- có hạng sử dụng --}}
                <table class="table" style="text-align: center">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: left">Quy Cách</th>
                            <th scope="col">Số Lượng</th>
                            <th scope="col">Giá Bán</th>
                            <th scope="col">Ngày Sản Xuất</th>
                            <th scope="col">Ngày Hết Hạn</th>
                            <th scope="col">Trạng Thái</th>
                            <th scope="col">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ChiTietSanPham as $valuectsp)
                            <tr>
                                <td style="text-align: left">
                                    @isset($QuyCach)
                                        @foreach ($QuyCach as $itemQC)
                                            @if ($itemQC->id == $valuectsp->kichthuoc)
                                                {{ $itemQC->tenquycach }}
                                            @endif
                                        @endforeach
                                    @endisset
                                </td>
                                <td>{{ number_format($valuectsp->soluong, 0, ',', '.') }}</td>
                                <td>{{ number_format($valuectsp->giasanpham, 0, ',', '.') . ' VNĐ' }}</td>
                                <td>{{ Date_format(Date_create($valuectsp->ngaysanxuat), 'd/m/Y') }}</td>
                                <td>{{ Date_format(Date_create($valuectsp->hansudung), 'd/m/Y') }}</td>
                                <td>
                                    <span class="badge {{ $valuectsp->trangthai == 1 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $valuectsp->trangthai == 1 ? 'Còn Bán' : 'Hết Bán' }}</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="javascript:(0)" class="action_btn mr_10 view-edit-CTSP" data-url="{{ route('chi-tiet-san-pham.edit', $valuectsp->id) }}" data-id="{{ $valuectsp->id }}">
                                            <i class="fas fa-edit"></i></a>

                                        <a href="javascript:(0)" class="action_btn mr_10 form-delete-CTSP" data-url="{{ route('chi-tiet-san-pham.destroy', $valuectsp->id) }}" data-idsp="{{ $SanPham->id }}">
                                            <i class="fas fa-trash-alt"></i></a>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else {{-- dùng trong ngày --}}
                <table class="table" style="text-align: center">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: left">Quy Cách</th>
                            <th scope="col">Giá Bán</th>
                            <th scope="col">Trạng Thái</th>
                            <th scope="col">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ChiTietSanPham as $valuectsp)
                            <tr>
                                <td style="text-align: left">
                                    @isset($QuyCach)
                                        @foreach ($QuyCach as $itemQC)
                                            @if ($itemQC->id == $valuectsp->kichthuoc)
                                                {{ $itemQC->tenquycach }}
                                            @endif
                                        @endforeach
                                    @endisset
                                </td>
                                <td>{{ number_format($valuectsp->giasanpham, 0, ',', '.') . ' VNĐ' }}</td>
                                <td>
                                    <span class="badge {{ $valuectsp->trangthai == 1 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $valuectsp->trangthai == 1 ? 'Còn Bán' : 'Hết bán' }}</span>
                                </td>
                                <td>
                                    <a href="javascript:(0)" class="action_btn mr_10 view-edit-CTSP" data-url="{{ route('chi-tiet-san-pham.edit', $valuectsp->id) }}" data-id="{{ $valuectsp->id }}">
                                        <i class="fas fa-edit"></i></a>

                                    <a href="javascript:(0)" class="action_btn mr_10 form-delete-CTSP" data-url="{{ route('chi-tiet-san-pham.destroy', $valuectsp->id) }}" data-idsp="{{ $SanPham->id }}">
                                        <i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endisset
    @endisset
@endisset
