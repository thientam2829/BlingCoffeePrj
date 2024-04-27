@if (isset($SanPham))
    @foreach ($SanPham as $item)
        <tr>
            <td><img src="{{ asset('uploads/SanPham/' . $item->hinhanh) }}" alt="image" height="60" width="60">
                <p class="d-inline-block align-middle mb-0 f_s_16 f_w_600 color_theme2" style=padding-left: 10px">{{ $item->tensanpham }}</p>
            </td>
            <td>
                <select onchange="kichthuoc(this,'{{ $item->id }}')" data-ia="{{ $item->id }}" class="form-control">
                    <option value="0">Chọn Quy Cách</option>
                    @if (isset($ChiTietSanPham))
                        @foreach ($ChiTietSanPham as $itemCTHD)
                            @if ($itemCTHD->id_sanpham == $item->id)
                                <option value="{{ $itemCTHD->id }}">
                                    {{ $itemCTHD->tenquycach }}
                                </option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </td>
            <td style="text-align: center" id="giaban{{ $item->id }}"></td>
            <td style="text-align: center" id="giamgia{{ $item->id }}"></td>
            <td style="text-align: center"><a href="javascript:(0)" id="them{{ $item->id }}" class="action_btn">
                    <i class="fas fa-plus-circle"></i></a>
            </td>
        </tr>
    @endforeach
@endif
