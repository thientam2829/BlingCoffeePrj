@extends('layouts.backend_layout')
@section('active_quanlysanpham')
    class="nav-item active"
@endsection
@section('content')
    <div class="main_content_iner ">
        <form class="add-form" method="POST" action="{{ route('san-pham.update', $SanPham->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="btn-pm">
                <div class="mb-3 btn-1">
                    <button type="submit" class="btn btn-success">Lưu</button>
                    <a class="btn btn-danger" href="{{ route('san-pham.index') }}">Thoát</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="white_card">
                        <div class="white_card_header">
                            <div class="main-title">
                                <h2 class="m-0">Cập Nhật Sản Phẩm</h2>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <div class="form-group">
                                <div class="form-check">
                                    <label>Trạng Thái </label>
                                    <input type="checkbox" name="trangthai" value='1' class="form-check-input"
                                        {{ $SanPham->trangthai == 1 ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label>Tên Sản Phẩm<b style="color:red"> *</b></label>
                                        <input type="int" class='@error(' tensanpham') is-invalid @enderror form-control'
                                            maxlength="50" name="tensanpham" required value="{{ $SanPham->tensanpham }}">
                                    </div>
                                    @error('tensanpham')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="form-group">
                                        <label>Thẻ Sản Phẩm<b style="color:red"> *</b></label>
                                        <select class="@error(' the') is-invalid @enderror form-control" name="the"
                                            required>

                                            <option value="THƯỜNG" {{ $SanPham->the == 'THƯỜNG' ? 'selected' : '' }}>
                                                THƯỜNG
                                            </option>
                                            <option value="MỚI" {{ $SanPham->the == 'MỚI' ? 'selected' : '' }}>MỚI
                                            </option>
                                            <option value="BÁN CHẠY NHẤT"
                                                {{ $SanPham->the == 'BÁN CHẠY NHẤT' ? 'selected' : '' }}>BÁN CHẠY
                                                NHẤT</option>
                                        </select>
                                    </div>
                                    @error('the')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="form-group">
                                        <label>Loại Sản Phẩm<b style="color:red"> *</b></label>
                                        <select class="@error(' id_loaisanpham') is-invalid @enderror form-control"
                                            name="id_loaisanpham" required>
                                            @if (isset($LoaiSanPham))
                                                @foreach ($LoaiSanPham as $valuelsp)
                                                    <option value="{{ $valuelsp->id }}"
                                                        {{ $valuelsp->id == $SanPham->id_loaisanpham ? 'selected' : '' }}>
                                                        {{ $valuelsp->tenloaisanpham }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('id_loaisanpham')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label>Mô Tả</label>
                                        <textarea type="text" class='@error(' mota') is-invalid @enderror form-control'
                                            name="mota"> {{ $SanPham->mota }}</textarea>
                                    </div>
                                    @error('mota')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                    <label>Hình Ảnh Sản Phẩm<b style="color:red"> *</b></label> <br>
                                    <input type="file" class="image @error(' hinhanh') is-invalid @enderror" id="image"
                                        name="hinhanh" onchange="UpImg()">
                                    <div id="displayIMG">
                                        <img src="{{ asset('uploads/SanPham/' . $SanPham->hinhanh) }}">
                                    </div>
                                    @error('hinhanh')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        function UpImg() { // hiện hình ảnh.
            var fileSL = document.getElementById('image').files;
            if (fileSL.length > 0) {
                var imgUp = fileSL[0];
                var fileReader = new FileReader();
                fileReader.onload = function(fileLoaderEvent) {
                    var srcI = fileLoaderEvent.target.result;
                    var newImg = document.createElement('img');
                    newImg.src = srcI;
                    document.getElementById('displayIMG').innerHTML = newImg.outerHTML;
                }
                fileReader.readAsDataURL(imgUp);
            }

        }
    </script>
@endsection
