@if (isset($KhachHang))
    @foreach ($KhachHang as $value)
        <tr id="{{ $value->id }}">
            {{-- <td style="text-align: left">{{ $value->id }}</td> --}}
            <td style="text-align: left">{{ $value->tenkhachhang }}</td>
            <td>{{ $value->sdt }}</td>
            <td style="text-align: left; width: 20%">{{ $value->diachi }}</td>
            <td style="text-align: left">{{ $value->email }}</td>
            <td>{{ number_format($value->diemtichluy, 0, ',', '.') }}</td>
            <td>
                @if ($value->trangthai == 1)
                    <span class="badge bg-success">Được Dùng</span>
                @else
                    <span class="badge bg-danger">Đã Khoá</span>
                @endif
            </td>
            <td>
                <div class="d-flex">
                    <a href="javascript:(0)" class="action_btn mr_10 view-edit" data-url="{{ route('khach-hang.edit', $value->id) }}">
                        <i class="fas fa-edit"></i></a>

                    <a href="javascript:(0)" class="action_btn mr_10 form-delete" data-url="{{ route('khach-hang.destroy', $value->id) }}" data-id="{{ $value->id }}">
                        <i class="fas fa-trash-alt"></i></a>
                </div>

            </td>
        </tr>
    @endforeach
@endif
