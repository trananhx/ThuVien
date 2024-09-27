<?php

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

//Route::get('/', function () {
//    return view('user.home');
//})->name('user.home');

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// TODO: Sửa lại .env
// TODO: Thêm đổi mật khẩu vào admin
// TODO: Thêm link quên mật khẩu và đăng kí vào giao diện
// TODO: Sửa lại form data

Auth::routes();
Route::get('/', 'UserController@getHome')->name('user.home');
Route::get('/home', function(){return redirect()->route('user.home');})->name('home');
Route::get('/tai-lieu-theo-mon', 'UserController@getTaiLieuTheoMon')->name('user.taiLieuTheoMon');
Route::get('/chi-tiet', 'UserController@getChiTietTaiLieu')->name('user.chiTietTaiLieu');
Route::get('/tim-kiem', 'UserController@getTimKiemTaiLieu')->name('user.timKiemTaiLieu');
Route::get('/thong-bao', 'UserController@getThongBao')->name('user.thongBao');
Route::get('/chi-tiet-thong-bao', 'UserController@chiTietThongBao')->name('user.chiTietThongBao');
Route::get('/forgot-password', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::get('/reset-password/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/forgot-password', 'Auth\ForgotPasswordController@sendReset')->name('password.email');
// Route::get('/chi-tiet-yeu-cau', 'UserController@chiTietYeuCau')->name('user.chiTietYeuCau');
Route::post('/login', 'UserController@dangNhap')->name('login');
// Route::get('register')

Route::group(['middleware' => ['isUser']], function(){
    Route::get('/thay-doi-mat-khau', 'UserController@getThayDoiMatKhau')->name('user.thayDoiMatKhau');
    Route::get('/yeu-cau', 'UserController@getYeuCau')->name('user.yeuCau');
    Route::get('/xem-tham-do', 'UserController@getThongTinVote');
    Route::post('/doi-mat-khau', 'UserController@doiMatKhau');
    Route::post('/gui-tham-do', 'UserController@thucHienVote');
    Route::post('/them-yeu-cau', 'UserController@themYeuCau');
    Route::post('/them-yeu-cau-gia-han', 'UserController@themYeuCauGiaHan');
    Route::post('/dat-truoc-sach', 'UserController@datTruocSach');
});

Route::group(['prefix' => 'admin','middleware' => ['isAdmin']], function(){
//    Route::get('/', 'AdminController@getHome')->name('admin.home');
    Route::get('/chuong-trinh-dao-tao', 'AdminController@getChuongTrinhDaoTao')->name('admin.home');
    Route::get('/mon-hoc', 'AdminController@getMonHoc')->name('admin.monHoc');
    Route::get('/tai-lieu', 'AdminController@getTaiLieu')->name('admin.taiLieu');
    Route::get('/thong-bao', 'AdminController@getThongBao')->name('admin.thongBao');
    Route::get('/yeu-cau', 'AdminController@getYeuCau')->name('admin.yeuCau');
    Route::get('/user', 'AdminController@getUser')->name('admin.user');
    Route::get('/tham-do', 'AdminController@getThamDo')->name('admin.thamDo');
    Route::post('/them-chuong-trinh-dao-tao', 'AdminController@themChuongTrinhDaoTao');
    Route::post('/them-mon-hoc', 'AdminController@themMonHoc');
    Route::post('/them-tai-lieu', 'AdminController@themTaiLieu');
    Route::post('/them-thong-bao', 'AdminController@themThongBao');
    Route::post('/them-nguoi-dung', 'AdminController@themNguoiDung');
    Route::post('/them-tra-loi', 'AdminController@themTraLoi');
    Route::post('/them-tham-do', 'AdminController@themThamDo');
    Route::post('/delete-mon-hoc', 'AdminController@xoaMonHoc');
    Route::post('/delete-ctdt', 'AdminController@xoaChuongTrinhDaoTao');
    Route::post('/delete-tai-lieu', 'AdminController@xoaTaiLieu');
    Route::post('/delete-thong-bao', 'AdminController@xoaThongBao');
    Route::post('/delete-yeu-cau', 'AdminController@xoaYeuCau');
    Route::post('/delete-nguoi-dung', 'AdminController@xoaNguoiDung');
    Route::post('/delete-tham-do', 'AdminController@xoaThamDo');
    Route::post('/sua-chuong-trinh-dao-tao', 'AdminController@suaChuongTrinhDaoTao');
    Route::post('/sua-mon-hoc', 'AdminController@suaMonHoc');
    Route::post('/sua-tai-lieu', 'AdminController@suaTaiLieu');
    Route::post('/sua-thong-bao', 'AdminController@suaThongBao');
    Route::post('/sua-nguoi-dung', 'AdminController@suaNguoiDung');
    Route::post('/sua-tham-do', 'AdminController@suaThamDo');
    Route::post('/lay-danh-sach-chuong-trinh-dao-tao', 'AdminController@layDanhSachChuongTrinhDaoTao');
    Route::post('/lay-danh-sach-mon-hoc', 'AdminController@layDanhSachMonHoc');
    Route::post('/lay-danh-sach-tai-lieu', 'AdminController@layDanhSachTaiLieu');
    Route::post('/lay-danh-sach-thong-bao', 'AdminController@layDanhSachThongBao');
    Route::post('/lay-danh-sach-tham-do', 'AdminController@layDanhSachThamDo');
    Route::post('/lay-danh-sach-yeu-cau', 'AdminController@layDanhSachYeuCau');
    Route::post('/lay-danh-sach-nguoi-dung', 'AdminController@layDanhSachNguoiDung');
    Route::post('/danh-dau-yeu-cau-da-xem', 'AdminController@danhDauYeuCauDaXem');
    Route::post('/check-danh-sach-yeu-cau', 'AdminController@checkDanhSachYeuCau');
    Route::post('/reset-mat-khau', 'AdminController@resetMatKhau');
});

Route::get('/404', function () {
    return view('user.errors.404');
});
