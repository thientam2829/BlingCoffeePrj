@if (isset($LoaiSanPham))
    @foreach ($LoaiSanPham as $value)
        <tr id="{{ $value->id }}">
            {{-- <td style="text-align: left">{{ $value->id }}</td> --}}
            <td style="text-align: left">{{ $value->tenloaisanpham }}</td>
            <td>
                @if ($value->trangthai == 1)
                    <span class="badge bg-primary">Sản phẩm Có Hạn Sử Dụng</span>
                @elseif($value->trangthai == 2)
                    <span class="badge bg-success">Sản Phẩm Dùng Trong Ngày</span>
                @else
                    <span class="badge bg-danger">Không Được Phép Thêm Sản Phẩm</span>
                @endif
            </td>
            <td>
                <a href="javascript:(0)" class="action_btn mr_10 view-add" data-url="{{ route('quy-cach.create') }}" data-id="{{ $value->id }}">
                    <i class="fas fa-plus-square"></i></a>

                <a href="javascript:(0)" class="action_btn mr_10 view-show" data-url="{{ route('loai-san-pham.show', $value->id) }}">
                    <i class="fas fa-eye"></i></a>

                <a href="javascript:(0)" class="action_btn mr_10 view-edit" data-url="{{ route('loai-san-pham.edit', $value->id) }}">
                    <i class="fas fa-edit"></i></a>

                <a href="javascript:(0)" class="action_btn mr_10 form-delete" data-url="{{ route('loai-san-pham.destroy', $value->id) }}" data-id="{{ $value->id }}">
                    <i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
    @endforeach
@endif
