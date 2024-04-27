@if (isset($LoaiNhanVien))
    @foreach ($LoaiNhanVien as $value)
        <tr id="{{ $value->id }}">
            {{-- <td style="text-align: left">{{ $value->id }}</td> --}}
            <td style="text-align: left">{{ $value->tenloainhanvien }}</td>
            <td>
                <span class="badge {{ $value->trangthai == 1 ? 'bg-success' : 'bg-danger' }}">
                    {{ $value->trangthai == 1 ? 'Hoạt Động' : 'Tạm Dừng' }}</span>
            </td>
            <td>
                <a href="javascript:(0)" class="action_btn mr_10 view-edit" data-url="{{ route('loai-nhan-vien.edit', $value->id) }}">
                    <i class="fas fa-edit"></i></a>

                <a href="javascript:(0)" class="action_btn mr_10 form-delete" data-url="{{ route('loai-nhan-vien.destroy', $value->id) }}" data-id="{{ $value->id }}">
                    <i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
    @endforeach
@endif
