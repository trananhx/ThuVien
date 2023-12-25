<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\QuenMatKhau;
use App\PasswordReset;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

//    public function index(Request $request){
//        return view('auth.passwords.email');
//    }
//
    public function sendReset(Request $request){
        $data = $request->validate([
            'email' => 'required|email|exists:users',
        ], [
            'email.exists' => 'Email không tồn tại!',
            'email.required' => 'Vui lòng không để trống email',
            'email.email' => 'Email không đúng định dạng'
        ]);

        $this->sendResetLinkEmail($request);

//        // Delete all old code that user send before.
//        PasswordReset::where('email', $request->email)->delete();
//
//        // Generate random code
//        $data['token'] = (string) Str::uuid();
//
//        // Create a new code
//        $codeData = PasswordReset::create($data);
//
//        // Send email to user
//        Mail::to($request->email)->send(new QuenMatKhau($codeData->token));
        $request->session()->flash('status', 'Đã gửi email đến '.$request->email);
        return Redirect::refresh();
    }
}
