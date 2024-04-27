@isset($LoaiSanPham)
    <div class="row">
        <div class="col-sm-12">
            <h4><b>{{ $LoaiSanPham->tenloaisanpham }} </b> <span>({{ $LoaiSanPham->id }})</span></h4>
            <h4><b>Trạng Thái: </b>
                <span>
                    @if ($LoaiSanPham->trangthai == 1)
                        <span>Sản phẩm Có Hạn Sử Dụng</span>
                    @elseif($LoaiSanPham->trangthai == 2)
                        <span>Sản Phẩm Dùng Trong Ngày</span>
                    @else
                        <span>Không Được Phép Thêm Sản Phẩm</span>
                    @endif
                </span>
            </h4>
        </div>
    </div>
    <hr>
    {{-- chi tiết sảm phẩm --}}
    @isset($QuyCach)
        <table class="table" style="text-align: center">
            <thead>
                <tr>
                    <th scope="col" style="text-align: left">Quy Cách</th>
                    <th scope="col">Trạng Thái</th>
                    <th scope="col">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($QuyCach as $valueqc)
                    <tr id="{{ $valueqc->id }}">
                        <td style=" text-align: left">{{ $valueqc->tenquycach }}</td>
                        <td>
                            @if ($valueqc->trangthai == 1)
                                <span class="badge bg-primary">Được Phép Thêm Sản Phẩm</span>
                            @elseif($valueqc->trangthai == 2)
                                <span class="badge bg-success">Hiện Đại Diện Trên Website</span>
                            @else
                                <span class="badge bg-danger">Không Được Phép Thêm Sản Phẩm</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex" style="justify-content: center;">
                                <a href="javascript:(0)" class="action_btn mr_10 view-editQC" data-url="{{ route('quy-cach.edit', $valueqc->id) }}">
                                    <i class="fas fa-edit"></i></a>

                                <a href="javascript:(0)" class="action_btn mr_10 form-deleteQC" data-url="{{ route('quy-cach.destroy', $valueqc->id) }}" data-id="{{ $LoaiSanPham->id }}">
                                    <i class="fas fa-trash-alt"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset
@endisset
