@isset($KhuyenMai)
    <div class="row">
        <div class="col-sm-12">
            <h4><b>{{ $KhuyenMai->tenkhuyenmai }} </b> <span>({{ $KhuyenMai->id }})</span></h4>
            <h4><b>Thời Gian Bắt Đầu: </b> <span>{{ Date_format(Date_create($KhuyenMai->thoigianbatdau), 'd/m/Y') }}</span></h4>
            <h4><b>Thời Gian Kết Thúc: </b> <span>{{ Date_format(Date_create($KhuyenMai->thoigianketthuc), 'd/m/Y') }}</span></h4>
            <h4><b>Tình Trạng: </b> <span>@isset($today)
                        @if ($KhuyenMai->thoigianketthuc < $today)
                            Kết Thúc
                        @elseif ($KhuyenMai->trangthai == 0 && $KhuyenMai->thoigianketthuc >= $today)
                            Đã Khóa
                        @elseif ($KhuyenMai->thoigianbatdau > $today )
                            Sắp Đến
                        @else
                            Đang Áp Dụng
                        @endif
                    @endisset
                </span></h4>
            <h4><b>Mô Tả: </b> <span>{{ $KhuyenMai->mota }}</span></h4>
        </div>
    </div>
    <hr>
    {{-- chi tiết sảm phẩm --}}
    @isset($ChiTietKhuyenMai)
        @if (Auth::user()->id_loainhanvien == 'LNV00000000000000')
            <table class="table" style="text-align: center">
                <thead>
                    <tr>
                        <th scope="col" style="text-align: left">Sản Phẩm</th>
                        <th scope="col">Quy cách</th>
                        <th scope="col">Loại</th>
                        <th scope="col">Mức Khuyến Mãi</th>
                        <th scope="col">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ChiTietKhuyenMai as $valuectkm)
                        <tr>
                            <td style="text-align: left">
                                {{ $valuectkm->tensanpham }}
                            </td>
                            <td>
                                {{ $valuectkm->tenquycach }}
                            </td>
                            <td>
                                {{ $valuectkm->tenloaisanpham }}
                            </td>
                            <td>{{ $valuectkm->muckhuyenmai . '%' }}</td>
                            <td>
                                <div class="d-flex"  style="justify-content: center;">
                                    <a href="javascript:(0)" class="action_btn mr_10 view-edit-CTKM" data-idctsp="{{ $valuectkm->id_chitietsanpham }}" data-idkm="{{ $KhuyenMai->id }}">
                                        <i class="fas fa-edit"></i></a>

                                    <a href="javascript:(0)" class="action_btn mr_10 form-delete-CTKM" data-idctsp="{{ $valuectkm->id_chitietsanpham }}" data-idkm="{{ $KhuyenMai->id }}">
                                        <i class="fas fa-trash-alt"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <table class="table" style="text-align: center">
                <thead>
                    <tr>
                        <th scope="col" style="text-align: left">Sản Phẩm</th>
                        <th scope="col">Quy Cách</th>
                        <th scope="col">Loại</th>
                        <th scope="col">Mức Khuyến Mãi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ChiTietKhuyenMai as $valuectkm)
                        <tr>
                            <td style="text-align: left">
                                {{ $valuectkm->tensanpham }}
                            </td>
                            <td>
                                {{ $valuectkm->tenquycach }}
                            </td>
                            <td>
                                {{ $valuectkm->tenloaisanpham }}
                            </td>
                            <td>{{ $valuectkm->muckhuyenmai . '%' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    @endisset
@endisset
