@if (isset($HoaDon))
    @foreach ($HoaDon as $value)
        <tr id="{{ $value->id }}">
            {{-- <td style="text-align: left">{{ $value->id }}</td> --}}
            <td style="text-align: left">{{ Date_format(Date_create($value->ngaylap), 'd/m/Y H:i:s') }}</td>
            <td>{{ $value->sdtkhachhang }}</td>
            <td>
                {{ $value->tenkhachhang }}
            </td>
            <td>
                @isset($NhanVien)
                    @foreach ($NhanVien as $itemNV)
                        @if ($value->id_nhanvien == $itemNV->id)
                            {{ $itemNV->tennhanvien }}
                        @endif
                    @endforeach
                @endisset
            </td>
            <td>
                @if ($value->trangthai == 1)
                    <span class='badge bg-success'>Hoàn Thành</span>
                @else
                    <span class='badge bg-danger'>Đã Đóng</span>
                @endif
            </td>
            <td>
                <a data-id="{{ $value->id }}" href="javascript:(0)" class="action_btn mr_10 view-show">
                    <i class="fas fa-eye"></i></a>
                @if (Auth::user()->id_loainhanvien == 'LNV00000000000000')
                    <a data-id="{{ $value->id }}" href="javascript:(0)" class="action_btn mr_10 form-updatestatus">
                        <i class="fas fa-pencil-alt "></i></a>

                    <a data-id="{{ $value->id }}" href="javascript:(0)" class="action_btn form-delete">
                        <i class="fas fa-trash-alt"></i></a>
                @endif
            </td>
        </tr>
    @endforeach
@endif
