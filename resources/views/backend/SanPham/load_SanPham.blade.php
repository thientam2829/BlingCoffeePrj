@if (isset($SanPham))
    @foreach ($SanPham as $value)
        <tr id="{{ $value->id }}">
            {{-- <td style="text-align: left">{{ $value->id }}</td> --}}
            <td style="text-align: left"><img src="{{ asset('uploads/SanPham/' . $value->hinhanh) }}" style="width: 100px; height: 100px; border-radius: 5px;"></td>
            <td>{{ $value->tensanpham }}</td>
            <td>{{ $value->the }}</td>
            <td>
                @if (isset($LoaiSanPham))
                    @foreach ($LoaiSanPham as $valuelsp)
                        @if ($value->id_loaisanpham == $valuelsp->id)
                            {{ $valuelsp->tenloaisanpham }}
                        @endif
                    @endforeach
                @endif
            </td>
            <td>
                <span class="badge {{ $value->trangthai == 1 ? 'bg-success' : 'bg-danger' }}">
                    {{ $value->trangthai == 1 ? 'Đang Bán' : 'Ngừng Bán' }}</span>
            </td>
            <td>
                {{-- <div class="d-flex"> --}}
                    <a href="javascript:(0)" class="action_btn mr_10 view-add" data-url="{{ route('chi-tiet-san-pham.create', $value->id) }}" data-id="{{ $value->id }}"><i
                            class="fas fa-plus-square"></i></a>

                    <a href="javascript:(0)" class="action_btn mr_10 view-show" data-url="{{ route('san-pham.show', $value->id) }}" data-id="{{ $value->id }}">
                        <i class="fas fa-eye"></i></a>

                    <a href="{{ route('san-pham.edit', $value->id) }}" class="action_btn mr_10"><i class="fas fa-edit"></i></a>

                    <a href="javascript:(0)" class="action_btn mr_10 form-delete" data-url="{{ route('san-pham.destroy', $value->id) }}" data-id="{{ $value->id }}">
                        <i class="fas fa-trash-alt"></i></a>
                {{-- </div> --}}
            </td>
        </tr>
    @endforeach
@endif
