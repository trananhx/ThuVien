<?php

namespace App\Http\Controllers;

use App\chuongTrinhDaoTao;
use App\Mail\TraLoiYeuCau;
use App\monHoc;
use App\Question;
use App\taiLieu;
use App\thongBao;
use App\User;
use App\UserVote;
use App\Vote;
use App\YeuCau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\ResetsPasswords;

class AdminController extends Controller
{
    use ResetsPasswords;

    public function getHome()
    {
        return view('admin.home');
    }

    public function getChuongTrinhDaoTao()
    {
        return view('admin.chuong-trinh-dao-tao');
    }

    public function getMonHoc()
    {
        return view('admin.mon-hoc');
    }

    public function getTaiLieu()
    {
        return view('admin.tai-lieu');
    }

    public function getThongBao()
    {
        return view('admin.thong-bao');
    }
    public function getYeuCau()
    {
        return view('admin.yeu-cau');
    }
    public function getUser()
    {
        return view('admin.nguoi-dung');
    }

    public function getThamDo()
    {
        return view('admin.tham-do');
    }

    public function suaChuongTrinhDaoTao(Request $request)
    {
        $req = $request->all();
        $check = chuongTrinhDaoTao::where('id', $req['id'])->first();
        if ($check) {
            $check->ten = $req['ten'];
            $check->save();
            $res = [
                'rc' => 0,
                'rd' => 'Cập nhật thành công',
                'data' => $check
            ];
        } else {
            $res = [
                'rc' => -1,
                'rd' => 'Không tìm thấy dữ liệu',
                'data' => null
            ];
        }
        return json_encode($res);
    }

    public function suaTaiLieu(Request $request)
    {

        $req = $request->all();
        $check = taiLieu::where('id', $req['id'])->first();
        $slug = Str::slug($req['ten_tai_lieu']);
        if ($check) {
            $check->mon_hoc_chinh = $req['mon_hoc_chinh'];
            $check->mon_hoc_phu = $req['mon_hoc_phu'];
            $check->ten_tai_lieu = $req['ten_tai_lieu'];
            $check->tac_gia = $req['tac_gia'];
            $check->tag = $req['tag'];
            $check->loai = $req['loai'];
            $check->mo_ta = $req['mo_ta'];
            $check->noi_dung = $req['noi_dung'];
            $check->trang_thai = $req['trang_thai'];
            if ($request->file('tai_lieu')) {
                $taiLieu = $request->file('tai_lieu');
                $fileTaiLieu = '/files/taiLieu/' . $slug . '-' . uniqid() . '.' . $taiLieu->extension();
                $taiLieu->move(public_path('files/taiLieu'), $fileTaiLieu);
                $check->link_file = $fileTaiLieu;
            }
            if ($request->file('anh_bia')) {
                $anhBia = $request->file('anh_bia');
                $fileAnhBia = '/files/anhBia/' . $slug . '-' . uniqid() . '.' . $anhBia->extension();
                $anhBia->move(public_path('files/anhBia'), $fileAnhBia);
                $check->hinh_anh = $fileAnhBia;
            }
            $check->save();
            $res = [
                'rc' => 0,
                'rd' => 'Cập nhật thành công',
                'data' => $check
            ];
        } else {
            $res = [
                'rc' => -1,
                'rd' => 'Không tìm thấy dữ liệu',
                'data' => null
            ];
        }
        return json_encode($res);
    }

    public function suaMonHoc(Request $request)
    {
        $req = $request->all();
        $check = monHoc::where('id', $req['id'])->first();
        if ($check) {
            $check->ctdt_id = $req['ctdt_id'];
            $check->ten_mon = $req['ten_mon'];
            $check->ma_mon = $req['ma_mon'];
            $check->save();
            $res = [
                'rc' => 0,
                'rd' => 'Cập nhật thành công',
                'data' => $check
            ];
        } else {
            $res = [
                'rc' => -1,
                'rd' => 'Không tìm thấy dữ liệu',
                'data' => null
            ];
        }
        return json_encode($res);
    }


    public function suaThongBao(Request $request)
    {
        $req = $request->all();
        $check = thongBao::where('id', $req['id'])->first();
        if ($check) {
            $check->tieu_de = $req['tieu_de'];
            $check->mo_ta = $req['mo_ta'];
            $check->noi_dung = $req['noi_dung'];
            $check->save();
            $res = [
                'rc' => 0,
                'rd' => 'Cập nhật thành công',
                'data' => $check
            ];
        } else {
            $res = [
                'rc' => -1,
                'rd' => 'Không tìm thấy dữ liệu',
                'data' => null
            ];
        }
        return json_encode($res);
    }
    public function suaNguoiDung(Request $request)
    {
        $req = $request->all();
        $check = User::where('id', $req['id'])->first();
        if ($check) {
            $check->phone = $req['phone'];
            $check->name = $req['name'];
            $check->save();
            $res = [
                'rc' => 0,
                'rd' => 'Cập nhật thành công',
                'data' => $check
            ];
        } else {
            $res = [
                'rc' => -1,
                'rd' => 'Không tìm thấy dữ liệu',
                'data' => null
            ];
        }
        return json_encode($res);
    }

    public function themChuongTrinhDaoTao(Request $request)
    {
        $req = $request->all();
        $check = chuongTrinhDaoTao::where('ten', $req['ten'])->first();
        if ($check) {
            $res = [
                'rc' => -1,
                'rd' => 'Chương trình đào tạo đã tồn tại.',
                'data' => null
            ];

        } else {
            $dataCreat = chuongTrinhDaoTao::create([
                'ten' => $req['ten'],
            ]);
            $res = [
                'rc' => 0,
                'rd' => 'Thêm dữ liệu thành công.',
                'data' => $dataCreat
            ];
        }
        return json_encode($res);
    }

    public function themMonHoc(Request $request)
    {
        $req = $request->all();
        $check = monHoc::where('ten_mon', $req['ten'])->orWhere('ma_mon', $req['ma_mon'])->first();
        if ($check) {
            $res = [
                'rc' => -1,
                'rd' => 'Học phần đã tồn tại.',
                'data' => null
            ];

        } else {
            $dataCreat = monHoc::create([
                'ten_mon' => $req['ten'],
                'ctdt_id' => $req['ctdt'],
                'ma_mon' => $req['ma_mon'],
            ]);
            $res = [
                'rc' => 0,
                'rd' => 'Thêm dữ liệu thành công.',
                'data' => $dataCreat
            ];
        }
        return json_encode($res);
    }
    public function themNguoiDung(Request $request)
    {
        $req = $request->all();
        $check = User::where('email', $req['email'])->orWhere('ma_sv', $req['ma_sv'])->first();
        if ($check) {
            $res = [
                'rc' => -1,
                'rd' => 'Email hoặc mã người dùng đã tồn tại.',
                'data' => null
            ];
        } else {
            $dataCreat = User::create([
                'phone' => $req['phone'],
                'email' => $req['email'],
                'name' => $req['name'],
                'ma_sv' => $req['ma_sv'],
                'password' => Hash::make($req['pass'])
            ]);
            $res = [
                'rc' => 0,
                'rd' => 'Thêm dữ liệu thành công.',
                'data' => $dataCreat
            ];
        }
        return json_encode($res);
    }
    public function themThongBao(Request $request)
    {
        $req = $request->all();
        $check = thongBao::where('tieu_de', $req['tieu_de'])->first();
        if ($check) {
            $res = [
                'rc' => -1,
                'rd' => 'Thông báo đã tồn tại.',
                'data' => null
            ];

        } else {
            $dataCreat = thongBao::create([
                'tieu_de' => $req['tieu_de'],
                'noi_dung' => $req['noi_dung'],
                'mo_ta' => $req['mo_ta'],
            ]);
            $res = [
                'rc' => 0,
                'rd' => 'Thêm dữ liệu thành công.',
                'data' => $dataCreat
            ];
        }
        return json_encode($res);
    }

    public function themTaiLieu(Request $request)
    {
        Log::info('Thêm tài liệu');
        $req = $request->all();
        $fileTaiLieu = null;
        $fileAnhBia = null;
        $slug = Str::slug($req['ten_tai_lieu']);
        Log::info('Slug là:');
        Log::info($slug);
        if ($request->file('tai_lieu')) {
            $taiLieu = $request->file('tai_lieu');
            $fileTaiLieu = '/files/taiLieu/' . $slug . '-' . uniqid() . '.' . $taiLieu->extension();
            $taiLieu->move(public_path('files/taiLieu'), $fileTaiLieu);
        }
        if ($request->file('anh_bia')) {
            $anhBia = $request->file('anh_bia');
            $fileAnhBia = '/files/anhBia/' . $slug . '-' . uniqid() . '.' . $anhBia->extension();
            $anhBia->move(public_path('files/anhBia'), $fileAnhBia);
        }
        try {
            $dataCreat = taiLieu::create([
                'mon_hoc_chinh' => $req['mon_hoc_chinh'],
                'mon_hoc_phu' => $req['mon_hoc_phu'],
                'ten_tai_lieu' => $req['ten_tai_lieu'],
                'tac_gia' => $req['tac_gia'],
                'tag' => $req['tag'],
                'mo_ta' => $req['mo_ta'],
                'noi_dung' => $req['noi_dung'],
                'link_file' => $fileTaiLieu ? $fileTaiLieu : '/404',
                'hinh_anh' => $fileAnhBia,
            ]);
        } catch (\Exception $exception){
            $res = [
                'rc' => '-1',
                'data' => null,
                'rd' => 'Có lỗi xảy ra trong quá trình thêm',
            ];
        }

        $res = [
            'rc' => '0',
            'data' => $dataCreat,
            'rd' => 'Thêm tài liệu thành công',
        ];
        return json_encode($res);
    }

    public function themTraLoi(Request $request){
        $tieuDe = $request->input('tieu_de', '');
        $noiDung = $request->input('noi_dung', '');
        $id = $request->input('id', '-1');
        $yeuCau = YeuCau::find($id);
        if ($tieuDe == '' || $noiDung == '')
            return json_encode([
                'rc' => '-1',
                'rd' => 'Vui lòng điền tiêu đề và nội dung',
                'data' => null,
            ]);

        if ($yeuCau == null){
            return json_encode([
                'rc' => '-1',
                'rd' => 'Không tìm thấy yêu cầu, vui lòng tải lại trang!',
                'data' => null,
            ]);
        }

        if ($yeuCau->trang_thai != 2){
            Mail::to($yeuCau->nguoiTao)->send(new TraLoiYeuCau($tieuDe, $noiDung));
            $yeuCau->trang_thai = 2;
            $yeuCau->save();
            return json_encode([
                'rc' => '0',
                'rd' => 'Gửi email thành công',
                'data' => null,
            ]);
        }

        else {
            return json_encode([
                'rc' => '-1',
                'rd' => 'Không tìm thấy yêu cầu, vui lòng tải lại trang!',
                'data' => null,
            ]);
        }
    }

    public function xoaChuongTrinhDaoTao(Request $request)
    {
        $req = $request->all();
        $check = chuongTrinhDaoTao::where('id', $req['id'])->first();
        $check_mon_hoc = monHoc::where('ctdt_id', 'like', '%' . $req['id'] . '%')->first();
        if (isset($check_mon_hoc)) {
            $res = [
                'rc' => '-1',
                'rd' => 'Chương trình đào tạo đang có môn học. Không thể xóa. [' . $check_mon_hoc['ten_mon'] . ']'
            ];
        } else {
            if ($check) {
                $check->delete();
                $res = [
                    'rc' => 0,
                    'rd' => 'Đã xóa thành công.',
                    'data' => null
                ];

            } else {
                $res = [
                    'rc' => '-1',
                    'rd' => 'Không tìm thấy dữ  liệu cần xoá'
                ];
            }
        }
        return json_encode($res);
    }

    public function xoaMonHoc(Request $request)
    {
        $req = $request->all();
        $check = monHoc::where('id', $req['id'])->first();
        $tai_lieu = taiLieu::where('mon_hoc_chinh',$req['id'])->get();
        if (count($tai_lieu)) {
            $res =
            [
                'rc' => '-1',
                'rd' => 'Học phần đang có tài liệu, không thể xóa.'
            ];
        } else {
            if ($check) {
                $check->delete();
                $res =
                [
                    'rc' => 0,
                    'rd' => 'Đã xóa thành công.',
                    'data' => null
                ];

            } else {
                $res =
                [
                    'rc' => '-1',
                    'rd' => 'Không tìm thấy dữ  liệu cần xoá'
                ];
            }
        }
        return json_encode($res);
    }

    public function xoaTaiLieu(Request $request)
    {
        $req = $request->all();
        $check = taiLieu::where('id', $req['id'])->first();
        if ($check) {
            $check->delete();
            $res =
            [
                'rc' => 0,
                'rd' => 'Đã xóa thành công.',
                'data' => null
            ];

        } else {
            $res =
            [
                'rc' => '-1',
                'rd' => 'Không tìm thấy dữ  liệu cần xoá'
            ];
        }
        return json_encode($res);
    }

    public function xoaThongBao(Request $request)
    {
        $req = $request->all();
        $check = thongBao::where('id', $req['id'])->first();
        if ($check) {
            $check->delete();
            $res = [
                'rc' => 0,
                'rd' => 'Đã xóa thành công.',
                'data' => null
            ];

        } else {
            $res = [
                'rc' => '-1',
                'rd' => 'Không tìm thấy dữ  liệu cần xoá'
            ];
        }
        return json_encode($res);
    }
    public function xoaYeuCau(Request $request)
    {
        $req = $request->all();
        $check = YeuCau::where('id', $req['id'])->first();
        if ($check) {
            $check->delete();
            $res = [
                'rc' => 0,
                'rd' => 'Đã xóa thành công.',
                'data' => null
            ];

        } else {
            $res = [
                'rc' => '-1',
                'rd' => 'Không tìm thấy dữ  liệu cần xoá'
            ];
        }
        return json_encode($res);
    }
    public function xoaNguoiDung(Request $request)
    {
        $req = $request->all();
        $check = User::where('id', $req['id'])->first();
        if ($check) {
            $check->votes()->detach();
            $check->delete();
            $res = [
                'rc' => 0,
                'rd' => 'Đã xóa thành công.',
                'data' => null
            ];

        } else {
            $res = [
                'rc' => '-1',
                'rd' => 'Không tìm thấy dữ  liệu cần xoá'
            ];
        }
        return json_encode($res);
    }

    public function layDanhSachChuongTrinhDaoTao(Request $request)
    {

        $req = $request->all();
        $list = chuongTrinhDaoTao::where('id', '>', 0);
        $total = $list->count();
        $data = $list->orderBy('created_at', 'DESC')->skip($req['start'])->take($req['limit'])->get();
        if (count($data)) {
            $res = [
                'rc' => '0',
                'data' => $data,
                'total' => $total
            ];
        } else {
            $res = [
                'rc' => '1',
                'rd' => 'Không tìm thấy bản ghi nào'
            ];
        }
        return json_encode($res);
    }

    public function layDanhSachMonHoc(Request $request)
    {
        $req = $request->all();
        $list = monHoc::where('id', '>', 0);
        if (isset($req['ctdt']) && $req['ctdt'] != '') {
            $list = monHoc::where('ctdt_id', 'like', '%' . $req['ctdt'] . '%');
        }
        $total = $list->count();
        $data = $list->with('chuongTrinhDaoTao')->orderBy('created_at', 'DESC')->skip($req['start'])->take($req['limit'])->get();
        if (count($data)) {
            $res = [
                'rc' => '0',
                'data' => $data,
                'total' => $total
            ];
        } else {
            $res = [
                'rc' => '1',
                'rd' => 'Không tìm thấy bản ghi nào'
            ];
        }
        return json_encode($res);

    }
    public function layDanhSachNguoiDung(Request $request)
    {
        $req = $request->all();
        $list = User::where('role', '=', 0);
        if (isset($req['key']) && $req['key'] != '') {
            $list = User::where('email', 'like', '%' . $req['key'] . '%');
        }
        $total = $list->count();
        $data = $list->orderBy('created_at', 'DESC')->skip($req['start'])->take($req['limit'])->get();
        if (count($data)) {
            $res = [
                'rc' => '0',
                'data' => $data,
                'total' => $total
            ];
        } else {
            $res = [
                'rc' => '1',
                'rd' => 'Không tìm thấy bản ghi nào'
            ];
        }
        return json_encode($res);

    }
    public function layDanhSachThongBao(Request $request)
    {
        $req = $request->all();
        $list = thongBao::where('id', '>', 0);
        if (isset($req['key']) && $req['key'] != '') {
            $list = thongBao::where('tieu_de', 'like', '%' . $req['key'] . '%');
        }
        $total = $list->count();
        $data = $list->orderBy('created_at', 'DESC')->skip($req['start'])->take($req['limit'])->get();
        if (count($data)) {
            $res = [
                'rc' => '0',
                'data' => $data,
                'total' => $total
            ];
        } else {
            $res = [
                'rc' => '1',
                'rd' => 'Không tìm thấy bản ghi nào'
            ];
        }
        return json_encode($res);

    }
    public function danhDauYeuCauDaXem(Request $request){
        $req = $request->all();
        $check = YeuCau::where('id', $req['id'])->first();
        if ($check && $check->trang_thai == 0) {
            $check->trang_thai = 1;
            $check->save();

        } else {

        }
    }
    public function checkDanhSachYeuCau(Request $request)
    {
        $check = YeuCau::where('trang_thai', 0)->count();
        if ($check) {
            $res = [
                'rc' => 1,
                'rd' => 'Bạn có '.$check.' phản hồi chưa xem.',
                'data' => $check
            ];
        } else {
            $res = [
                'rc' => 0,
                'rd' => 'Không tìm thấy dữ liệu',
                'data' => 0
            ];
        }
        return json_encode($res);
    }
    public function layDanhSachYeuCau(Request $request)
    {
        $req = $request->all();
        $list = YeuCau::where('id', '>', 0);
        if (isset($req['key']) && $req['key'] != '') {
            $list = YeuCau::where('tieu_de', 'like', '%' . $req['key'] . '%');
        }
        $total = $list->count();
        $data = $list->orderBy('created_at', 'DESC')->with('nguoiTao')->skip($req['start'])->take($req['limit'])->get();
        if (count($data)) {
            $res = [
                'rc' => '0',
                'data' => $data,
                'total' => $total
            ];
        } else {
            $res = [
                'rc' => '1',
                'rd' => 'Không tìm thấy bản ghi nào'
            ];
        }
        return json_encode($res);
    }

    public function layDanhSachTaiLieu(Request $request)
    {
        $req = $request->all();
        $list = taiLieu::where('ten_tai_lieu', 'like', '%' . $req['key'] . '%');
//        if (isset($req['ctdt'])&&$req['ctdt']!=''){
//            $list = monHoc::where('ctdt_id',$req['ctdt']);
//        }
        $total = $list->count();
        $data = $list->with('monHocChinh.chuongTrinhDaoTao')->with('monHocChinh')->orderBy('created_at', 'DESC')->skip($req['start'])->take($req['limit'])->get();
        if (count($data)) {
            $res = [
                'rc' => '0',
                'data' => $data,
                'total' => $total
            ];
        } else {
            $res = [
                'rc' => '1',
                'rd' => 'Không tìm thấy bản ghi nào'
            ];
        }
        return json_encode($res);
    }

//    public function removeSelectOtherQuestion($question){
//        $select = Question::where('is_select', true)->get();
//        if ($select == null && !$question->is_select){
//            $question->is_select = true;
//            $question->save();
//            return;
//        }
//        if ($question->is_select){
//            // Revoke all select
//            foreach ($select as $item){
//                if ($item->id != $question->id){
//                    $item->is_select = false;
//                    $item->save();
//                }
//            }
//        }
//    }

    public function themThamDo(Request $request){
        $cauHoi = $request->input("tieu_de", "");
        $dsLuaChon = $request->input('list_lua_chon', []);
        if ($dsLuaChon == [] || $cauHoi == ""){
            $res = [
                'rc' => '1',
                'rd' => 'Vui lòng thêm nội dung câu hỏi và lựa chọn'
            ];
            return json_encode($res);
        }

        $select = $request->input('is_select');

        $q = Question::create([
            'content' => $cauHoi,
            'is_select' => $select,
        ]);

        $list = [];
        foreach ($dsLuaChon as $luaChon){
            $list []= new Vote([
                'name' => $luaChon,
                'question_id' => $q->id
            ]);
        }

        $q->votes()->saveMany($list);
//        $this->removeSelectOtherQuestion($q);

        $res = [
            'rc' => '0',
            'data' => 'Lưu thành công câu hỏi',
        ];
        return json_encode($res);
    }


    public function layDanhSachThamDo(Request $request){
        $req = $request->all();
        if (!isset($req['key']))
            $req['key'] = '';
        $data = Question::with('votes')->with('users')->where('content', 'like', '%' . $req['key'] . '%')
            ->orderBy('created_at', 'DESC')->skip($req['start'])->take($req['limit'])->get();
        $count = Question::all()->count();
//        $data->map->votes = $data->votes->map(function($item){
//            $item->total = $item->users()->count;
//            return $item;
//        });
        $data = $data->map(function($question){
           $question->votes = $question->votes->map(function($vote){
                    $vote->total = $vote->users()->count();
                    return $vote;
               });
           return $question;
        });
//        dd($data);
        if ($data->count() != 0) {
            $res = [
                'rc' => '0',
                'data' => $data,
                'total' => $count
            ];
        } else {
            $res = [
                'rc' => '1',
                'rd' => 'Không tìm thấy bản ghi nào'
            ];
        }

        return json_encode($res);
    }

    // Chua fix
    public function suaThamDo(Request $request){
        $req = $request->all();
        $check = Question::where('id', $req['id'])->first();
        if ($check) {
            $check->content = $req['content'];
            $check->is_select = $req['is_select'];
            $check->save();

            $luaChons = $req['votes'];
            $votes = $check->votes;
            foreach ($luaChons as $key => $luaChon){
                if ($luaChon['id'] == 0){
                    Vote::create([
                        'name' => $luaChon['name'],
                        'question_id' => $check->id,
                    ]);
                    unset($luaChons[$key]);
                }
            }

            foreach ($votes as $vote){
                $isHave = false;
                foreach ($luaChons as $luaChon) {
                    if ($vote->id == $luaChon['id'] && !$isHave){
                        $isHave = true;
                        $vote->name = $luaChon['name'];
                        $vote->save();
                        break;
                    }
                }
                if (!$isHave){
                    $vote->users()->detach();
                    $vote->delete();
                }
            }


//            $this->removeSelectOtherQuestion($check);

            $res = [
                'rc' => 0,
                'rd' => 'Cập nhật thành công',
                'data' => $check
            ];
        } else {
            $res = [
                'rc' => -1,
                'rd' => 'Không tìm thấy dữ liệu',
                'data' => null
            ];
        }
        return json_encode($res);
    }

    public function xoaThamDo(Request $request){
        $req = $request->all();
        $check = Question::where('id', $req['id'])->first();
        if ($check) {
            $votes = $check->votes;
            foreach ($votes as $vote){
                $vote->users()->detach();
                $vote->delete();
            }
//            $isSelect = $check->is_select;
            $check->delete();

//            if ($isSelect){
//                $firstQuestion = Question::first();
//                $this->removeSelectOtherQuestion($firstQuestion);
//            }

            $res = [
                'rc' => 0,
                'rd' => 'Xóa thành công',
                'data' => $check
            ];
        } else {
            $res = [
                'rc' => -1,
                'rd' => 'Không tìm thấy dữ liệu',
                'data' => null
            ];
        }
        return json_encode($res);
    }

    public function resetMatKhau(Request $request){
        $req = $request->all();
        $user = User::find($req['id']);
        if ($user == null) {
            return json_encode([
                'rc' => -1,
                'rd' => 'Không tìm thấy user',
                'data' => null
            ]);
        }

        // $user->fill([
        //     'password' => Hash::make("123456Aa@")
        // ]);

        // $user->setRememberToken(Str::random(60));
        // $user->save();
        setUserPassword($user, "123456Aa@");

        return json_encode([
            'rc' => 0,
            'rd' => 'Reset mật khẩu thành 123456Aa@ thành công',
            'data' => null,
        ]);
    }
}
