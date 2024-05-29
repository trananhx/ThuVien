<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'sdt' => ['required', 'numeric', 'digits_between:8,10'],
            'mssv' => ['required', 'string', 'min:3'],
        ], [
            'email.*' => 'Email không hợp lệ hoặc đã bị người khác dùng',
            'name.*' => 'Tên không hợp lệ',
            'password.confirmed' => 'Mật khẩu phải giống mật khẩu xác nhận',
            'password.*' => 'Mật khẩu ít nhất phải 6 kí tự',
            'sdt.*' => 'Số điện thoại phải từ 8 - 10 số',
            'mssv.*' => 'Mã số sinh viên ít nhất phải 3 kí tự'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['sdt'],
            'ma_sv' => $data['mssv'],
        ]);
    }
}
