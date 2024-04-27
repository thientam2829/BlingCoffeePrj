<div class="container-fluid no-gutters">
    <div class="row">
        <div class="col-lg-12 p-0 ">
            <div class="header_iner d-flex justify-content-between align-items-center">
                <div class="line_icon open_miniSide d-none d-lg-block">
                </div>
                <div class="header_right d-flex justify-content-between align-items-center">
                    <div class="profile_info">
                        <img src="{{ asset('uploads/NhanVien/' . Auth::user()->hinhanh) }}" alt="#">
                        <div class="profile_info_iner">
                            <div class="profile_author_name">
                                <h5>{{ Auth::user()->tennhanvien }}</h5>
                            </div>
                            <div class="profile_info_details">
                                @csrf
                                @if (Auth::user()->id_loainhanvien != 'LNV00000000000000')
                                    <a href="{{ route('nhan-vien.myProfile', Auth::id()) }}">Thông Tin Cá Nhân</a>
                                @endif
                                <a href="{{ route('DangXuat') }}">Đăng Xuất</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
