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
            'username' => 'required|string|max:255',
            'mail' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ],
        [
            'username.required' => '必須項目です',
            'username.max' => 'ユーザー名は最大255文字までです',
            'username.string' => '使用できない文字が含まれています',
            'mail.required' => '必須項目です',
            'mail.email' => 'メールアドレスの入力が正しくありません',
            'username.string' => '使用できない文字が含まれています',
            'mail.max' => 'メールアドレスは最大255文字までです',
            'mail.unique' => 'このメールアドレスは既に使用されています',
            'password.required' => '必須項目です',
            'password.string' => '使用できない文字が含まれています',
            'password.min' => '8文字以上で入力してください',
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

    // 新規ユーザー登録とバリデーショメソッド
    public function register(Request $request){
        // post通信でフォームから値が送られてきたら、バリデーションを利用し、データベースに登録
        if($request->isMethod('post')){
            $data = $request->input();
            $val = $this->validator($data);     // バリデーションチェックメソッドの呼び出し
            $this->create($data);   // 新規登録処理メソッドの呼び出し
            $user = $request->input('username');    // 入力したユーザー名を取得
            return redirect('added')->with('user',$user);   // 取得したユーザー名を一緒に送る
        }
        // フォームからの値がない(初めてページを訪問した際など)
        return view('auth.register');
    }

    public function added(){
        return view('auth.added');
    }
}
