@if (isset($NhanVien))
    @foreach ($NhanVien as $value)
        <tr id="{{ $value->id }}">
            {{-- <td style="text-align: left">{{ $value->id }}</td> --}}
            <td style="text-align: left"><img src="{{ asset('uploads/NhanVien/' . $value->hinhanh) }}" style="width: 100px; height: 100px; border-radius: 5px;"></td>
            <td>{{ $value->tennhanvien }}</td>
            <td>{{ $value->sdt }}</td>
            <td>
                @if (isset($LoaiNhanVien))
                    @foreach ($LoaiNhanVien as $valuelnv)
                        @if ($value->id_loainhanvien == $valuelnv->id)
                            {{ $valuelnv->tenloainhanvien }}
                        @endif
                    @endforeach
                @endif
            </td>
            <td>
                <span class="badge {{ $value->trangthai == 1 ? 'bg-success' : 'bg-danger' }}">
                    {{ $value->trangthai == 1 ? 'Còn Làm' : 'Đã Nghỉ' }}</span>
            </td>
            <td>
                <a onclick="Show('{{ route('nhan-vien.show', $value->id) }}')" href="javascript:(0)" class="action_btn mr_10"><i class="fas fa-eye"></i></a>
                <a href="{{ route('nhan-vien.edit', $value->id) }}" class="action_btn mr_10"><i class="fas fa-edit"></i></a>
                <a data-url="{{ route('nhan-vien.destroy', $value->id) }}" data-id="{{ $value->id }}" href="javascript:(0)" class="action_btn form-delete"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
    @endforeach
@endif
