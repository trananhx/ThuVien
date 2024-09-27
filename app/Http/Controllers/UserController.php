<?php

namespace App\Http\Controllers;

use App\chuongTrinhDaoTao;
use App\monHoc;
use App\Question;
use App\taiLieu;
use App\thongBao;
use App\User;
use App\UserVote;
use App\Vote;
use App\YeuCau;
use Illuminate\Support\Facades\DB;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function dangNhap(Request $request)
    {
        Log::info('Đăng nhập:');
        $infoLogin = array(
            'ma_sv' => $request->ma_sv,
            'password' => $request->password
        );
        $auth = Auth::attempt($infoLogin);
        Log::info($infoLogin);
        Log::info($auth);
        if ($auth) {
            return Redirect::route('user.home');
            Log::info('Đăng nhập thành công');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Tài khoản hoặc mật khẩu không chính xác']);
            Log::info('Đăng nhập thất bại');
        }
    }

    public function getHome()
    {
        $list_ctdt = chuongTrinhDaoTao::with('monHoc')->orderBy('created_at', 'ASC')->get();
        $thong_bao = thongBao::where('id', '>', 0)->orderBy('created_at', 'DESC')->paginate(5, ['*'], 'noti');
        $list_new = taiLieu::with('monHocChinh')->paginate(12, ['*'], 'news');
        return view('user.home', compact(['list_new', 'list_ctdt', 'thong_bao']));
    }

    public function getThayDoiMatKhau()
    {
        $list_ctdt = chuongTrinhDaoTao::with('monHoc')->orderBy('created_at', 'ASC')->get();
        $thong_bao = thongBao::where('id', '>', 0)->orderBy('created_at', 'DESC')->paginate(5, ['*'], 'noti');
        $list_new = taiLieu::with('monHocChinh')->paginate(12, ['*'], 'news');
        return view('user.thay-doi-mat-khau', compact(['list_new', 'list_ctdt', 'thong_bao']));
    }

    public function getThongBao()
    {
        $list_thong_bao = thongBao::orderBy('created_at', 'DESC')->paginate(10, ['*'], 'noti');
        $list_ctdt = chuongTrinhDaoTao::with('monHoc')->orderBy('created_at', 'ASC')->get();
        $tai_lieu_moi = taiLieu::orderBy('created_at', 'DESC')->take(10)->get();
        $tai_lieu_lien_quan = taiLieu::inRandomOrder()->take(10)->get();
        return view('user.thong-bao', compact(['list_thong_bao', 'list_ctdt', 'tai_lieu_moi', 'tai_lieu_lien_quan']));
    }
    public function getYeuCau()
    {
        $list_yeu_cau = YeuCau::orderBy('created_at', 'DESC')->where('user_id',Auth::id())->paginate(10, ['*'], 'noti');
        $list_ctdt = chuongTrinhDaoTao::with('monHoc')->orderBy('created_at', 'ASC')->get();
        $tai_lieu_moi = taiLieu::orderBy('created_at', 'DESC')->take(10)->get();
        $tai_lieu_lien_quan = taiLieu::inRandomOrder()->take(10)->get();
        return view('user.yeu-cau', compact(['list_yeu_cau', 'list_ctdt', 'tai_lieu_moi', 'tai_lieu_lien_quan']));
    }

    public function getTaiLieuTheoMon(Request $request)
    {
        $req = $request->all();
        $list_tai_lieu = taiLieu::where('mon_hoc_chinh', $req['monHocId'])->paginate(6, ['*'], 'news');
        $mon_hoc = monHoc::where('id', $req['monHocId'])->first();
        $list_tai_lieu_khac = taiLieu::where('mon_hoc_chinh', '!=', $req['monHocId'])->get();
        $list_ctdt = chuongTrinhDaoTao::with('monHoc')->orderBy('created_at', 'ASC')->get();
        return view('user.tai-lieu-theo-mon', compact(['list_ctdt', 'list_tai_lieu', 'list_tai_lieu_khac', 'mon_hoc']));
    }

    public function getChiTietTaiLieu(Request $request)
    {
        $req = $request->all();
        $post = taiLieu::where('id', $req['postId'])->first();
        $post->luot_xem += 1;
        $post->save();
        $list_ctdt = chuongTrinhDaoTao::with('monHoc')->orderBy('created_at', 'ASC')->get();
        $tai_lieu_moi = taiLieu::where('id', '!=', $post->id)->orderBy('created_at', 'DESC')->take(10)->get();
        $tai_lieu_lien_quan = taiLieu::where('mon_hoc_chinh', $post->mon_hoc_chinh)->where('id', '!=', $post->id)->paginate(12, ['*'], 'lienquan');
        return view('user.chi-tiet', compact(['list_ctdt', 'post', 'tai_lieu_lien_quan', 'tai_lieu_moi']));
    }

    public function chiTietThongBao(Request $request)
    {
        $req = $request->all();
        $thong_bao = thongBao::where('id', $req['id'])->orderBy('created_at', 'DESC')->first();
        $list_ctdt = chuongTrinhDaoTao::with('monHoc')->orderBy('created_at', 'ASC')->get();
        $tai_lieu_moi = taiLieu::orderBy('created_at', 'DESC')->take(10)->get();
        $thong_bao_khac = thongBao::where('id', '!=', $req['id'])->orderBy('created_at', 'DESC')->paginate(6, ['*'], 'notikhac');
        $tai_lieu_lien_quan = taiLieu::inRandomOrder()->take(10)->get();
        return view('user.chi-tiet-thong-bao', compact(['thong_bao', 'list_ctdt', 'tai_lieu_moi', 'tai_lieu_lien_quan', 'thong_bao_khac']));
    }
    public function chiTietYeuCau(Request $request)
    {
        $req = $request->all();
        $yeu_cau = YeuCau::where('id', $req['id'])->orderBy('created_at', 'DESC')->first();
        $list_ctdt = chuongTrinhDaoTao::with('monHoc')->orderBy('created_at', 'ASC')->get();
        $tai_lieu_moi = taiLieu::orderBy('created_at', 'DESC')->take(10)->get();
        $yeu_cau_khac = YeuCau::where('id', '!=', $req['id'])->where('user_id',Auth::id())->orderBy('created_at', 'DESC')->paginate(6, ['*'], 'notikhac');
        $tai_lieu_lien_quan = taiLieu::inRandomOrder()->take(10)->get();
        return view('user.chi-tiet-yeu-cau', compact(['yeu_cau', 'list_ctdt', 'tai_lieu_moi', 'tai_lieu_lien_quan', 'yeu_cau_khac']));
    }

    public function getTimKiemTaiLieu(Request $request)
    {
        $req = $request->all();
        $key = '';
        if (isset($req['key'])) {
            $key = $req['key'];
        }
        $tai_lieu_moi = taiLieu::where('id', '!=', 0)->orderBy('created_at', 'DESC')->take(10)->get();
        $tai_lieu_lien_quan = taiLieu::where('id', '!=', 0)->paginate(12, ['*'], 'lienquan');
        $list_ctdt = chuongTrinhDaoTao::with('monHoc')->orderBy('created_at', 'ASC')->get();
        $list_tai_lieu = taiLieu::where('tag', 'like', '%' . $key . '%')->orWhere('ten_tai_lieu', 'like', '%' . $key . '%')->paginate(6, ['*'], 'news');
        return view('user.tim-kiem', compact(['list_ctdt', 'list_tai_lieu', 'tai_lieu_moi', 'tai_lieu_lien_quan']));
    }

    public function themYeuCau(Request $request){
        $req = $request->all();
        $dataCreat = YeuCau::create([
            'tieu_de' => $req['tieu_de'],
            'noi_dung' => $req['noi_dung'],
            'user_id' => Auth::id(),
        ]);
        $res = [
            'rc' => 0,
            'rd' => 'Thêm dữ liệu thành công.',
            'data' => $dataCreat
        ];
        return json_encode($res);
    }

    public function themYeuCauGiaHan(Request $request){
        $req = $request->all();
        $noi_dung = "Tôi cần gia hạn mượn sách ".$req['noi_dung']."(mã: ".$req['ma_vach']."), mssv: ".$request->user()->ma_sv;
        $dataCreat = YeuCau::create([
            'tieu_de' => $req['tieu_de'],
            'noi_dung' => $noi_dung,
            'user_id' => Auth::id(),
        ]);
        $res = [
            'rc' => 0,
            'rd' => 'Thêm dữ liệu thành công.',
            'data' => $dataCreat
        ];
        return json_encode($res);
    }

    public function doiMatKhau(Request $request)
    {
        Log::info('Đổi mật khẩu:');
        $req = $request->all();
        Log::info($req);
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        $newP = Hash::make($req['new']);
        $user->password = $newP;
        $user->save();
        $res = [
            'rc' => '0',
            'rd' => 'Đổi mật khẩu thành công'
        ];
        return json_encode($res);

    }

    public function getThongTinVote(Request $request)
    {
        $question = Question::where('is_select', true)->first();
        if ($question == null)
            return json_encode([
                'rc' => '-1',
                'rd' => 'Không tìm thấy question'
            ]);

        $totalVote = DB::table('user_vote')->join('vote', 'user_vote.vote_id', '=', 'vote.id')
            ->where('vote.question_id', '=', $question->id)->get()->count();

        $votes = $question->votes->map(function ($item) use ($totalVote)
        {
            $voteCount = UserVote::where('vote_id', $item->id)->get()->count();
            if ($totalVote > 0)
            {
                return
                [
                    'id' => $item->id,
                    'name' => $item->name,
                    'percent' => round(($voteCount / $totalVote)*100),
                    'count' => $voteCount
                ];
            }
            else
            {
                return
                [
                    'id' => $item->id,
                    'name' => $item->name,
                    'percent' => 0,
                    'count' => $voteCount
                ];
            }
        });

        $currentSelect = null;
        if ($request->user())
            $currentSelect = $request->user()->votes()->where('question_id', $question->id)->first();

        return
        [
            'rc' => '0',
            'rd' => 'Lấy dữ liệu thành công',
            'question' =>
            [
                'id' => $question->id,
                'content' => $question->content
            ],
            'votes' => $votes,
            'total_vote' => $totalVote,
            'user_select' => $currentSelect
        ];
    }

    // Chặn user k login được vote
    public function thucHienVote(Request $request){
        $question_id = $request->input('question_id', -1);
        $vote_id = $request->input('vote_id', -1);
        $question = Question::find($question_id);
        $vote = Vote::find($vote_id);
        if ($question == null || $vote == null)
        {
            return json_encode([
                'rc' => '-1',
                'rd' => 'Không tìm thấy question hoặc vote'
            ]);
        }

        if ($vote->question_id != $question->id)
        {
            return json_encode([
                'rc' => '-1',
                'rd' => 'Vote không thuộc câu hỏi này'
            ]);
        }

        $voteArr = $question->votes->filter(function (Vote $myVote, int $key) use ($request)
        {
            return $myVote->users->where('id', $request->user()->id);
        });

        $request->user()->votes()->detach($voteArr);
        $vote->users()->save($request->user());

        return json_encode([
            'rc' => '0',
            'rd' => 'Chọn thành công',
        ]);
    }

    public function datTruocSach(Request $request)
    {
        $taiLieu = taiLieu::find($request->input('id'));
        if (!$taiLieu)
        {
            $request->session()->flash('status', 'Có lỗi xảy ra');
            return \Illuminate\Support\Facades\Redirect::back();
        }
        YeuCau::create([
            'tieu_de' => 'Đặt trước sách '.$taiLieu->ten_tai_lieu,
            'noi_dung' => '<p>Tôi cần đặt trước tài liệu '.$taiLieu->ten_tai_lieu. ' của tác giả '.$taiLieu->tac_gia. '</p><br><img class="img-thumbnail" width="200" height="200" src="'.url($taiLieu->hinh_anh).'"/>',
            'user_id' => $request->user()->id
        ]);
        $request->session()->flash('status', 'Đặt trước tài liệu thành công');
        return \Illuminate\Support\Facades\Redirect::back();
    }
}
