<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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

    // 新規登録に成功したら、登録後の画面に遷移
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/added';

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
    // バリデーションメソッド
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|min:4|max:12',
            'mail' => 'required|string|email|min:4|max:50|unique:users',
            'password' => 'required|string|min:8|max:12|confirmed',
        ],
        [
            'username.required' => '必須項目です',
            'username.min' => 'ユーザー名は4文字以上、12文字以内で入力してください',
            'username.max' => 'ユーザー名は4文字以上、12文字以内で入力してください',
            'username.string' => '使用できない文字が含まれています',
            'mail.required' => '必須項目です',
            'mail.email' => 'メールアドレスの形式が正しくありません',
            'mail.string' => '使用できない文字が含まれています',
            'mail.min' => 'メールアドレスは4文字以上で入力してください',
            'mail.max' => 'メールアドレスは最大50文字までです',
            'mail.unique' => 'このメールアドレスは既に使用されています',
            'password.required' => '必須項目です',
            'password.string' => '使用できない文字が含まれています',
            'password.min' => 'パスワードは8文字以上、12文字以内で入力してください',
            'password.max' => 'パスワードは8文字以上、12文字以内で入力してください',
            'password.confirmed' => 'パスワードと確認用パスワードが一致していません',
        ])->validate();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    // 新規ユーザー登録処理メソッド
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'mail' => $data['mail'],
            'password' => bcrypt($data['password']),
        ]);
    }


    // public function registerForm(){
    //     return view("auth.register");
    // }

    //// 新規ユーザー登録とバリデーショメソッド ////
    public function register(Request $request){
        // post通信でフォームから値が送られてきたら、バリデーションを利用し、データベースに登録
        if($request->isMethod('post')){
            $data = $request->input();
            $val = $this->validator($data);     // バリデーションチェックメソッドの呼び出し
            $this->create($data);   // 新規登録処理メソッドの呼び出し
            $user = $request->input('username');    // 入力したユーザー名を取得

            session(['new_user' => $user]);

            return redirect('added');   // ユーザー登録後の画面へ遷移
        }

        // フォームからの値がない(初めてページを訪問した際など)
        return view('auth.register');
    }


    //// ユーザー登録後の画面表示メソッド ////
    public function added(){
        return view('auth.added');
    }
}
