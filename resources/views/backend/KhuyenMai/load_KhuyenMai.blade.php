@if (isset($KhuyenMai))
    @foreach ($KhuyenMai as $value)
        <tr id="{{ $value->id }}">
            {{-- <td style="text-align: left">{{ $value->id }}</td> --}}
            <td style="text-align: left">{{ $value->tenkhuyenmai }}</td>
            <td>{{ Date_format(Date_create($value->thoigianbatdau), 'd/m/Y') }}</td>
            <td>{{ Date_format(Date_create($value->thoigianketthuc), 'd/m/Y') }}</td>
            <td>
                @isset($today)
                    @if ($value->trangthai == 0)
                        <span class="badge bg-warning">Đã Khóa</span>
                    @elseif ($value->thoigianketthuc < $today) <span class="badge bg-danger">Kết Thúc</span>
                        @elseif ($value->thoigianbatdau > $today )
                            <span class="badge bg-info">Sắp Đến</span>
                        @else
                            <span class="badge bg-primary">Đang Áp Dụng</span>
                    @endif
                @endisset
            </td>
            <td>
                @if (Auth::user()->id_loainhanvien == 'LNV00000000000000')
                    <a href="javascript:(0)" class="action_btn mr_10 view-add" data-url="{{ route('chi-tiet-khuyen-mai.create', $value->id) }}" data-id="{{ $value->id }}">
                        <i class="fas fa-plus-square"></i></a>

                    <a href="javascript:(0)" class="action_btn mr_10 view-show" data-url="{{ route('khuyen-mai.show', $value->id) }}" data-id="{{ $value->id }}">
                        <i class="fas fa-eye"></i></a>

                    <a href="javascript:(0)" class="action_btn mr_10 view-edit" data-url="{{ route('khuyen-mai.edit', $value->id) }}" data-id="{{ $value->id }}">
                        <i class="fas fa-edit"></i></a>

                    <a href="javascript:(0)" class="action_btn mr_10 form-delete" data-url="{{ route('khuyen-mai.destroy', $value->id) }}" data-id="{{ $value->id }}">
                        <i class="fas fa-trash-alt"></i></a>
                @else
                    <a href="javascript:(0)" class="action_btn mr_10 view-show" data-url="{{ route('khuyen-mai.show', $value->id) }}" data-id="{{ $value->id }}">
                        <i class="fas fa-eye"></i></a>
                @endif
            </td>
        </tr>
    @endforeach
@endif
