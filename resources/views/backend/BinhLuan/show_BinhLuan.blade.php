@isset($BinhLuan)
    <div class="row">
        <div class="col-sm-4">
            <img src="{{ asset('uploads/SanPham/' . $BinhLuan->hinhanh) }}" style="width: 250px; border-radius: 5px;">
        </div>
        <div class="col-sm-7">
            <h4><b>Mã: </b> <span>{{ $BinhLuan->id }}</span></h4>
            <h4><b>Họ Tên: </b> <span>{{ $BinhLuan->hoten }}</span></h4>
            <h4><b>Giới Tính: </b> <span>{{ $BinhLuan->gioitinh == 1 ? 'Nam' : 'Nữ' }}</span></h4>
            <h4><b>Email: </b> <span>{{ $BinhLuan->email }}</span></h4>
            <h4><b>Sản Phẩm: </b> <span>{{ $BinhLuan->tensanpham }}</span></h4>
        </div>
    </div>
    <hr>
    <div class="comment">
        <div class="rowuser">
            <img src="{{ asset('uploads/NhanVien/NOIMAGE.png') }}" alt="" style="width: 25px"> {{ $BinhLuan->hoten }} - {{ Date_format(Date_create($BinhLuan->thoigian), 'd/m/Y H:i:s') }}
        </div>
        <div class="question" style="margin-top: 10px;">
            {{ $BinhLuan->noidung }}
        </div>
        <div class="actionuser">
            <div class="d-flex justify-content-between">
                <div class="">
                    <a class="reply" data-name="{{ $BinhLuan->hoten }}" data-idreply="{{ $BinhLuan->id }}" href="javascript:(0)">Trả lời</a>
                </div>
                <div class="">
                    <a class="form-delete" data-url="{{ route('binh-luan.destroy', $BinhLuan->id) }}" data-id="{{ $BinhLuan->id }}" href="javascript:(0)" style="color: red">Xóa bình luận</a>
                </div>
            </div>
            <hr>
        </div>
        <div id="listreply">
            @isset($TraLoi)
                @foreach ($TraLoi as $item)
                    <div id="Reply{{ $item->id }}">
                        <div class="rowuser">
                            @if ($item->trangthai == 2)
                                <img src="{{ asset('uploads/Logo/logo_bling_coffee.png') }}" alt="" style="width: 25px">
                            @else
                                <img src="{{ asset('uploads/NhanVien/NOIMAGE.png') }}" alt="" style="width: 25px">
                            @endif
                            {{ $item->hoten }} - {{ Date_format(Date_create($item->thoigian), 'd/m/Y H:i:s') }}
                        </div>
                        <div class="question">
                            {{ $item->noidung }}
                        </div>
                        <div class="actionuser">
                            <div class="d-flex justify-content-between">
                                <div>
                                    @if ($item->trangthai == 2)
                                        <a class="reply" data-name="{{ $item->hoten }}" data-idreply="{{ $BinhLuan->id }}" href="javascript:(0)">Trả lời</a>
                                    @else
                                        <a class="reply" data-name="{{ $item->hoten }}" data-idreply="{{ $item->id }}" href="javascript:(0)">Trả lời</a>
                                    @endif
                                </div>
                                <div>
                                    <a class="delete-reply" href="javascript:(0)" style="color: red" data-url="{{ route('binh-luan.destroyReply', $item->id) }}" data-id="{{ $item->id }}">Xóa bình
                                        luận</a>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
    <div class="">
        <div class="form-comment" id="form-comment" style="display: none;">
            <textarea id="comment" cols="30" rows="3" class="form-control" placeholder="Mời bạn để lại bình luận..." data-id_sanpham="{{ $BinhLuan->id_sanpham }}"
                data-matraloi="{{ $BinhLuan->id }}"></textarea>
            <input type="text" id="idreply" hidden>
            <div id="null-comment"><span class="lbMsgCmt"></span></div>
            <button onclick="informationForm()" class="btn btn-primary px-4" style="margin-top: 10px; float:right;">Trả Lời</button>
        </div>
    </div>
@endisset
