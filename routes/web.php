<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['namespace' => 'frontend'], function () {
    // trang chủ

    Route::get('/', 'TrangChuController@index')->name('Trangchu.index');
    // Sản Phẩm

    Route::get('/san-pham', 'SanPhamController@index')->name('SanPham.index');
    Route::get('/chi-tiet/{id}', 'SanPhamController@show')->name('SanPham.show');
    Route::post('/tim-san-pham', 'SanPhamController@search')->name('SanPham.search');
    Route::get('/loc-san-pham/{id}', 'SanPhamController@filter')->name('SanPham.filter');
    Route::get('/the-san-pham/{tag}', 'SanPhamController@tag')->name('SanPham.tag');
    Route::get('/khuyen-mai', 'SanPhamController@sale')->name('SanPham.sale');
    Route::get('/hien-san-pham/{id}', 'SanPhamController@showProduct')->name('SanPham.showProduct'); // hiện sản phẩm để thêm vào giỏ hàng.
    Route::get('/binh-luan-san-pham/{id}', 'SanPhamController@comment')->name('SanPham.comment');
    Route::get('/danh-gia-san-pham/{id}', 'SanPhamController@review')->name('SanPham.review');
    // Dịch Vụ

    Route::get('/dich-vu', 'DichVuController@index')->name('DichVu.index');

    //Menu
    Route::get('/menu', 'MenuController@index')->name('Menu.index');

    // Về Chúng Tôi

    Route::get('/ve-chung-toi', 'VeChungToiController@index')->name('VeChungToi.index');
    // Liên lạc

    Route::get('/lien-lac', 'LienLacController@index')->name('LienLac.index');
    // Giỏ hàng

    Route::get('/gio-hang', 'GioHangController@index')->name('GioHang.index');
    Route::get('/thanh-toan', 'GioHangController@show')->name('GioHang.show');
    Route::post('/them-vao-gio', 'GioHangController@addCart')->name('GioHang.addCart');
    Route::post('/them-vao-gio-hang', 'GioHangController@addCartOnline')->name('GioHang.addCartOnline'); // thêm vào giỏ từ trang chi tiết. (chưa cải thiện từ ngữ trả về )
    Route::post('/loai-bo-san-phan/{id}', 'GioHangController@deleteItemCartOnline')->name('GioHang.deleteItemCartOnline'); // xóa 1 sản phẩm.
    Route::post('/bo-tat-ca', 'GioHangController@deleteCartOnline')->name('GioHang.deleteCartOnline'); // xóa tất cả sản phẩm.
    Route::post('/cap-nhat-so-luong', 'GioHangController@updateQuantityOnline')->name('GioHang.updateQuantityOnline'); // cập nhật số lượng. (Chư sử lý thông báo khi số lượng lớn hơn)
    Route::post('/dat-hang', 'GioHangController@orderOnline')->name('GioHang.orderOnline'); // tìm giảm giá thành viên.
    Route::get('/xem-gio-hang', 'GioHangController@viewCart')->name('GioHang.viewCart'); // xem giỏ hàng.
    Route::post('/dat-pay-pal', 'GioHangController@checkOutPayPal')->name('GioHang.checkOutPayPal'); // thanh toán pay pal.
    Route::get('/ket-qua-pay-pal','GioHangController@resultCheckOut')->name('GioHang.viewAfterCheckOut'); // trả về trang chủ sau khi thânh toán.
});


//////////////////////////////        Login       //////////////////////////////

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/DangNhap', 'DangNhapController@index')->name('DangNhap.index'); // trang đăng nhập.
    Route::post('/DangNhap', 'DangNhapController@DangNhap')->name('DangNhap'); // đăng nhập.
    Route::get('/DangXuat', 'DangNhapController@DangXuat')->name('DangXuat');  // đăng xuất.
});
//////////////////////////////        interactive (tương tác)        //////////////////////////////
Route::group(['namespace' => 'interactive'], function () {
    // bình luận.

    Route::group(['prefix' => 'binh-luan'], function () {

        Route::group(['middleware' => 'auth'], function () {

            Route::get('/', 'BinhLuanController@index')->name('binh-luan.index'); // danh sách.
            Route::get('/so-luong', 'BinhLuanController@countHandleDelivery')->name('binh-luan.countHandleDelivery');
            Route::get('/chua-duyet', 'BinhLuanController@handleDelivery')->name('binh-luan.handleDelivery'); // danh sách bình luận cần duyệt.
            Route::get('/{id}/show', 'BinhLuanController@show')->name('binh-luan.show'); // xem bình luận.
            Route::post('/reply', 'BinhLuanController@reply')->name('binh-luan.reply'); // trả lời.
            Route::get('/{id}/destroy', 'BinhLuanController@destroy')->name('binh-luan.destroy'); // Xóa bình luận.
            Route::get('/{id}/destroyReply', 'BinhLuanController@destroyReply')->name('binh-luan.destroyReply'); // Xóa.
            Route::get('/search', 'BinhLuanController@search')->name('binh-luan.search'); // tìm.
            Route::get('/filter', 'BinhLuanController@filter')->name('binh-luan.filter'); // lọc & sắp xếp.
            Route::get('/comment-email/{id}/{TT}', 'BinhLuanController@commentEmail')->name('binh-luan.commentEmail'); // gửi email phản hồi.
        });

        Route::post('/gui', 'BinhLuanController@create')->name('binh-luan.create'); // gửi.
        Route::post('/tim-kiem', 'BinhLuanController@userSearch')->name('binh-luan.userSearch'); // người dùng tiềm kiếm.
    });
    // đánh giá.

    Route::group(['prefix' => 'danh-gia'], function () {

        Route::group(['middleware' => 'auth'], function () {

            Route::get('/', 'DanhGiaController@index')->name('danh-gia.index'); // danh sách.
            Route::get('/so-luong', 'DanhGiaController@countHandleDelivery')->name('danh-gia.countHandleDelivery');
            Route::get('/chua-duyet', 'DanhGiaController@handleDelivery')->name('danh-gia.handleDelivery'); // danh sách đánh gia cần duyệt.
            Route::get('/{id}/show', 'DanhGiaController@show')->name('danh-gia.show'); // xem đánh gia.
            Route::get('/{id}/approval', 'DanhGiaController@approval')->name('danh-gia.approval'); // duyệt đánh giá.
            Route::get('/{id}/destroy', 'DanhGiaController@destroy')->name('danh-gia.destroy'); // Xóa đánh gia.
            Route::get('/search', 'DanhGiaController@search')->name('danh-gia.search'); // tìm.
            Route::get('/filter', 'DanhGiaController@filter')->name('danh-gia.filter'); // lọc & sắp xếp.
            Route::get('/review-email/{id}/{TT}', 'DanhGiaController@creviewEmail')->name('binh-luan.reviewEmail'); // gửi email phản hồi.
        });

        Route::post('/gui', 'DanhGiaController@create')->name('danh-gia.create'); // gửi.
        Route::post('/tim-kiem', 'DanhGiaController@userSearch')->name('danh-gia.userSearch'); // người dùng tiềm kiếm.
        Route::get('/loc', 'DanhGiaController@userFilter')->name('danh-gia.userFilter'); // người dùng lọc.
    });
});


//////////////////////////////        admin       //////////////////////////////

Route::group(['namespace' => 'backend', 'prefix' => 'admin', 'middleware' => 'auth'], function () {
    // thống kê.
    Route::group(['middleware' => 'is.admin'], function () {

        Route::get('/', 'ThongKeController@index')->name('thong-ke.index'); // trang chủ.
        Route::post('/thong-ke/tu-den', 'ThongKeController@fromto')->name('thong-ke.fromto'); // thống kê từ ngày đến ngày.
        Route::post('/thong-ke/thang-nay', 'ThongKeController@statsForThisMonth')->name('thong-ke.statsForThisMonth'); // thông kê trong 30 ngày qua.
        Route::post('/thong-ke/san-pham', 'ThongKeController@product')->name('thong-ke.product'); // thông kê sản phẩm.
        Route::post('/thong-ke/khach-hang', 'ThongKeController@customer')->name('thong-ke.customer'); // thông kê khách hàng.
        Route::post('/thong-ke/nhan-vien', 'ThongKeController@satff')->name('thong-ke.satff'); // thông kê nhân viên.
        Route::post('/thong-ke/hoa-don', 'ThongKeController@bill')->name('thong-ke.bill'); // thông kê hóa đơn.
    });

    // loại nhân viên

    Route::group(['prefix' => 'loai-nhan-vien', 'middleware' => 'is.admin'], function () {

        Route::get('/', 'LoaiNhanVienController@index')->name('loai-nhan-vien.index'); // danh sách.
        Route::get('/create', 'LoaiNhanVienController@create')->name('loai-nhan-vien.create'); // trang thêm.
        Route::post('/store', 'LoaiNhanVienController@store')->name('loai-nhan-vien.store'); //thêm.
        Route::get('/{id}/edit', 'LoaiNhanVienController@edit')->name('loai-nhan-vien.edit'); // trang cập nhật.
        Route::put('/{id}/update', 'LoaiNhanVienController@update')->name('loai-nhan-vien.update'); //cập nhật
        Route::get('/{id}/destroy', 'LoaiNhanVienController@destroy')->name('loai-nhan-vien.destroy'); // xóa
        Route::get('/load', 'LoaiNhanVienController@load')->name('loai-nhan-vien.load'); // tải lại.
        Route::get('/search', 'LoaiNhanVienController@search')->name('loai-nhan-vien.search'); // tìm.
        Route::get('/filter', 'LoaiNhanVienController@filter')->name('loai-nhan-vien.filter'); // lọc & sắp xếp.
    });
    // nhân viên

    Route::group(['prefix' => 'nhan-vien'], function () {

        Route::group(['middleware' => 'is.admin'], function () {

            Route::get('/', 'NhanVienController@index')->name('nhan-vien.index'); // danh sách.
            Route::get('/create', 'NhanVienController@create')->name('nhan-vien.create'); // trang thêm. (Chưa ajax)
            Route::post('/store', 'NhanVienController@store')->name('nhan-vien.store'); //thêm. (Chưa ajax)
            Route::get('/{id}/show', 'NhanVienController@show')->name('nhan-vien.show'); // trang chi tiết.
            Route::get('/{id}/edit', 'NhanVienController@edit')->name('nhan-vien.edit'); // trang cập nhật. (Chưa ajax)
            Route::put('/{id}/update', 'NhanVienController@update')->name('nhan-vien.update'); //cập nhật (Chưa ajax)
            Route::get('/{id}/destroy', 'NhanVienController@destroy')->name('nhan-vien.destroy'); // xóa
            Route::get('/search', 'NhanVienController@search')->name('nhan-vien.search'); // tìm.
            Route::get('/filter', 'NhanVienController@filter')->name('nhan-vien.filter'); // lọc & sắp xếp.
        });

        Route::get('/{id}/myProfile', 'NhanVienController@myProfile')->name('nhan-vien.myProfile'); // Thông tin cá nhân.
    });
    // khách hàng

    Route::group(['prefix' => 'khach-hang'], function () {

        Route::group(['middleware' => 'is.admin'], function () {

            Route::get('/', 'KhachHangController@index')->name('khach-hang.index'); // danh sách.
            Route::get('/create', 'KhachHangController@create')->name('khach-hang.create'); // trang thêm.
            Route::get('/{id}/edit', 'KhachHangController@edit')->name('khach-hang.edit'); // trang cập nhật.
            Route::put('/{id}/update', 'KhachHangController@update')->name('khach-hang.update'); //cập nhật
            Route::get('/{id}/destroy', 'KhachHangController@destroy')->name('khach-hang.destroy'); // xóa
            Route::get('/load', 'KhachHangController@load')->name('khach-hang.load'); // tải lại.
            Route::get('/{id}/loadUpdate', 'KhachHangController@loadUpdate')->name('khach-hang.loadUpdate'); // tải cập nhật.
            Route::get('/search', 'KhachHangController@search')->name('khach-hang.search'); // tìm.
            Route::get('/filter', 'KhachHangController@filter')->name('khach-hang.filter'); // lọc & sắp xếp.
        });

        Route::post('/store', 'KhachHangController@store')->name('khach-hang.store'); //thêm.
    });
    // loai san phẩm

    Route::group(['prefix' => 'loai-san-pham', 'middleware' => 'is.admin'], function () {

        Route::get('/', 'LoaiSanPhamController@index')->name('loai-san-pham.index'); // danh sách.
        Route::get('/create', 'LoaiSanPhamController@create')->name('loai-san-pham.create'); // trang thêm.
        Route::post('/store', 'LoaiSanPhamController@store')->name('loai-san-pham.store'); //thêm.
        Route::get('/{id}/show', 'LoaiSanPhamController@show')->name('loai-san-pham.show'); // trang cập nhật.
        Route::get('/{id}/edit', 'LoaiSanPhamController@edit')->name('loai-san-pham.edit'); // trang cập nhật.
        Route::put('/{id}/update', 'LoaiSanPhamController@update')->name('loai-san-pham.update'); //cập nhật
        Route::get('/{id}/destroy', 'LoaiSanPhamController@destroy')->name('loai-san-pham.destroy'); // xóa
        Route::get('/load', 'LoaiSanPhamController@load')->name('loai-san-pham.load'); // tải lại.
        Route::get('/{id}/loadUpdate', 'LoaiSanPhamController@loadUpdate')->name('loai-san-pham.loadUpdate'); // tải cập nhật.
        Route::get('/search', 'LoaiSanPhamController@search')->name('loai-san-pham.search'); // tìm.
        Route::get('/filter', 'LoaiSanPhamController@filter')->name('loai-san-pham.filter'); // lọc & sắp xếp.
    });
    // quy cách.

    Route::group(['prefix' => 'quy-cach', 'middleware' => 'is.admin'], function () {

        Route::get('/create', 'QuyCachController@create')->name('quy-cach.create'); // trang thêm.
        Route::post('/store', 'QuyCachController@store')->name('quy-cach.store'); //thêm.
        Route::get('/{id}/edit', 'QuyCachController@edit')->name('quy-cach.edit'); // trang cập nhật.
        Route::put('/{id}/update', 'QuyCachController@update')->name('quy-cach.update'); //cập nhật
        Route::get('/{id}/destroy', 'QuyCachController@destroy')->name('quy-cach.destroy'); // xóa
    });
    // sản phẩm.

    Route::group(['prefix' => 'san-pham', 'middleware' => 'is.admin'], function () {

        Route::get('/', 'SanPhamController@index')->name('san-pham.index'); // danh sách.
        Route::get('/create', 'SanPhamController@create')->name('san-pham.create'); // trang thêm. (chưa ajax)
        Route::post('/store', 'SanPhamController@store')->name('san-pham.store'); //thêm. (chưa ajax)
        Route::get('/{id}/show', 'SanPhamController@show')->name('san-pham.show'); // trang chi tiết.
        Route::get('/{id}/edit', 'SanPhamController@edit')->name('san-pham.edit'); // trang cập nhật. (chưa ajax)
        Route::put('/{id}/update', 'SanPhamController@update')->name('san-pham.update'); //cập nhật (chưa ajax)
        Route::get('/{id}/destroy', 'SanPhamController@destroy')->name('san-pham.destroy'); // xóa.
        Route::get('/search', 'SanPhamController@search')->name('san-pham.search'); // tìm.
        Route::get('/so-luong-xu-ly', 'SanPhamController@handledProductQuantity')->name('san-pham.handledProductQuantity'); // sản phẩm hết hạng.
        Route::get('/so-luong-het-han-su-dung', 'SanPhamController@expiredProductQuantity')->name('san-pham.expiredProductQuantity'); // sản phẩm hết hạng.
        Route::get('/so-luong-het-hang', 'SanPhamController@outOfProductQuantity')->name('san-pham.outOfProductQuantity'); // sản phẩm hết hàng.
        Route::get('/het-han-su-dung', 'SanPhamController@expiredProduct')->name('san-pham.expiredProduct'); // sản phẩm hết hạng.
        Route::get('/het-hang', 'SanPhamController@outOfProduct')->name('san-pham.outOfProduct'); // sản phẩm hết hàng.
        Route::put('/cap-nhat-xu-ly/{id}', 'SanPhamController@updateHandledProduct')->name('san-pham.updateHandledProduct'); // sản phẩm hết hàng.
        Route::get('/filter', 'SanPhamController@filter')->name('san-pham.filter'); // lọc & sắp xếp.
    });
    // chi tiết san phẩm

    Route::group(['prefix' => 'chi-tiet-san-pham', 'middleware' => 'is.admin'], function () {

        Route::get('/{id}/create', 'ChiTietSanPhamController@create')->name('chi-tiet-san-pham.create'); // trang thêm chi tiết.
        Route::post('/store', 'ChiTietSanPhamController@store')->name('chi-tiet-san-pham.store'); // thêm chi tiết.
        Route::get('/{id}/edit', 'ChiTietSanPhamController@edit')->name('chi-tiet-san-pham.edit'); // trang cập nhật chi tiết.
        Route::put('/{id}/update', 'ChiTietSanPhamController@update')->name('chi-tiet-san-pham.update'); //cập nhật chi tiết.
        Route::get('/{id}/delete', 'ChiTietSanPhamController@destroy')->name('chi-tiet-san-pham.destroy'); //xóa chi tiết.
    });
    // khuyến mãi

    Route::group(['prefix' => 'khuyen-mai'], function () {

        Route::group(['middleware' => 'is.admin'], function () {

            Route::get('/create', 'KhuyenMaiController@create')->name('khuyen-mai.create'); // trang thêm.
            Route::post('/store', 'KhuyenMaiController@store')->name('khuyen-mai.store'); //thêm.
            Route::get('/{id}/edit', 'KhuyenMaiController@edit')->name('khuyen-mai.edit'); // trang cập nhật.
            Route::put('/{id}/update', 'KhuyenMaiController@update')->name('khuyen-mai.update'); //cập nhật
            Route::get('/{id}/loadUpdate', 'KhuyenMaiController@loadUpdate')->name('khuyen-mai.loadUpdate'); // tải cập nhật.
            Route::get('/{id}/destroy', 'KhuyenMaiController@destroy')->name('khuyen-mai.destroy'); // xóa.
            Route::get('/load', 'KhuyenMaiController@load')->name('khuyen-mai.load'); // tải lại.
        });

        Route::get('/', 'KhuyenMaiController@index')->name('khuyen-mai.index'); // danh sách.
        Route::get('/{id}/show', 'KhuyenMaiController@show')->name('khuyen-mai.show'); // trang chi tiết.
        Route::get('/search', 'KhuyenMaiController@search')->name('khuyen-mai.search'); // tìm.
        Route::get('/filter', 'KhuyenMaiController@filter')->name('khuyen-mai.filter'); // lọc & sắp xếp.
    });
    // chi tiết khuyến mãi

    Route::group(['prefix' => 'chi-tiet-khuyen-mai', 'middleware' => 'is.admin'], function () {

        Route::get('/{id}/create', 'ChiTietKhuyenMaiController@create')->name('chi-tiet-khuyen-mai.create'); // trang thêm chi tiết.
        Route::post('/store', 'ChiTietKhuyenMaiController@store')->name('chi-tiet-khuyen-mai.store'); // thêm chi tiết.
        Route::get('/{idCTSP}/{idKM}/edit', 'ChiTietKhuyenMaiController@edit')->name('chi-tiet-khuyen-mai.edit'); // trang cập nhật chi tiết.
        Route::put('/{idCTSP}/{idKM}/update', 'ChiTietKhuyenMaiController@update')->name('chi-tiet-khuyen-mai.update'); //cập nhật chi tiết.
        Route::get('/{idCTSP}/{idKM}/delete', 'ChiTietKhuyenMaiController@destroy')->name('chi-tiet-khuyen-mai.destroy'); //xóa chi tiết.
    });
    // hóa đơn.

    Route::group(['prefix' => 'hoa-don'], function () {
        // danh sách hóa đơn.

        Route::get('/', 'HoaDonController@index')->name('hoa-don.index'); // đến trang danh sách.
        Route::get('/show/{id}', 'HoaDonController@show')->name('hoa-don.show'); // chi tiết.
        Route::put('updateStatus/{id}', 'HoaDonController@updateStatus')->name('hoa-don.updateStatus')->middleware('is.admin'); // cập nhật trạng thái.
        Route::get('destroy/{id}', 'HoaDonController@destroy')->name('hoa-don.destroy')->middleware('is.admin'); // xóa.
        Route::get('/search', 'HoaDonController@search')->name('hoa-don.search'); // tìm.
        // thêm giỏ hàng.

        Route::get('/create', 'HoaDonController@create')->name('hoa-don.create'); // đến trang thêm.
        Route::get('priceProduct/{id}', 'HoaDonController@priceProduct')->name('hoa-don.priceProduct'); // lấy giá sản phẩm.
        Route::get('discountProduct/{id}', 'HoaDonController@discountProduct')->name('hoa-don.discountProduct'); //lấy giảm giá khuyến mãi.
        Route::get('addCart/{id}', 'HoaDonController@addCart')->name('hoa-don.addCart'); // thêm vào GioHang.
        // cập nhật giỏ hàng.

        Route::get('quantityChange', 'HoaDonController@quantityChange')->name('hoa-don.quantityChange'); // thay đổi số lượng SP trong GioHang.
        // xóa giỏ hàng.

        Route::get('deleteItemHoaDon/{id}', 'HoaDonController@deleteItemHoaDon')->name('hoa-don.deleteItemHoaDon'); // xóa khổi GioHang.
        Route::post('deleteHoaDon/', 'HoaDonController@deleteHoaDon')->name('hoa-don.deleteHoaDon'); // xóa khổi GioHang.
        // tìm kiếm.

        Route::get('searchProduct', 'HoaDonController@searchProduct')->name('hoa-don.searchProduct'); // tìm sản phẩm.
        Route::get('searchCustomer', 'HoaDonController@searchCustomer')->name('hoa-don.searchCustomer'); // tìm khách hàng.
        // giảm giá thành viên.

        Route::get('discountMember', 'HoaDonController@discountMember')->name('hoa-don.discountMember'); // áp dụng giảm giá cho thành viên.
        Route::get('unDiscountMember', 'HoaDonController@unDiscountMember')->name('hoa-don.unDiscountMember'); // bỏ áp dụng giảm giá cho thành viên.
        // in.

        Route::get('in', 'HoaDonController@in')->name('hoa-don.in'); // tạo hóa đơn. {IN HÓA ĐƠN}
        // cần được xử lý.

        Route::get('/xu-ly', 'HoaDonController@handleDelivery')->name('hoa-don.handleDelivery'); // đến trang cập nhật giao hàng.
        Route::put('/cap-nhat-xu-ly/{id}', 'HoaDonController@updateDelivery')->name('hoa-don.updateDelivery'); // cập nhật giao hàng. {IN HÓA ĐƠN, Thông báo email}
        Route::get('/xoa-xu-ly/{id}', 'HoaDonController@deleteDelivery')->name('hoa-don.deleteDelivery'); // xóa giao hàng. {thông báo email}
        Route::get('/so-luong', 'HoaDonController@countHandleDelivery')->name('hoa-don.countHandleDelivery'); // số lượng hóa đơn cần xử lý.
        // hóa đơn đã hủy.

        Route::get('/da-huy', 'HoaDonController@cancelled')->name('hoa-don.cancelled'); // danh sách hóa đơn đã hủy.
        Route::get('/tim-da-huy', 'HoaDonController@searchCancelled')->name('hoa-don.searchCancelled'); // tìm.
        // in hóa đơn.

        Route::get('/print-bill/{id}', 'HoaDonController@print_bill')->name('hoa-don.print_bill'); // xem trước khi in.
        // Route::get('/download-bill/{id}', 'HoaDonController@download_bill')->name('hoa-don.download_bill'); // tải file.
        //gửi email.

        Route::get('/send-email/{id}/{TT}', 'HoaDonController@send_email')->name('hoa-don.send_email'); // email sẽ gửi.
        // Route::get('/email/{id}/{TT}', 'HoaDonController@email')->name('hoa-don.email'); // xem gửi email.
        // lọc & sắp xếp.

        Route::get('/filter', 'HoaDonController@filter')->name('hoa-don.filter'); // lọc & sắp xếp.
        Route::get('/filter-product', 'HoaDonController@filterProduct')->name('hoa-don.filterProduct'); // lọc & sắp xếp.
    });
});

Route::get('/config-cache', function() {
    Artisan::call('config:cache');
    return "Config cache cleared";
});
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'Application cache cleared';
});
