@if (isset($BinhLuan))
    @foreach ($BinhLuan as $value)
        <tr id="{{ $value->id }}">
            <td style="width: 15%; text-align: left">{{ $value->hoten }}</td>
            <td style="width: 20%">{{ Date_format(Date_create($value->thoigian), 'd/m/Y H:i:s') }}</td>
            <td style="text-align: left">{{ $value->noidung }}</td>
            <td>
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-center">
                        <a href="javascript:(0)" class="action_btn mr_10 view-show" data-url="{{ route('binh-luan.show', $value->id) }}">
                            <i class="fas fa-eye"></i></a>

                        <a href="javascript:(0)" class="action_btn mr_10 form-delete" data-url="{{ route('binh-luan.destroy', $value->id) }}" data-id="{{ $value->id }}"><i
                                class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
@endif
