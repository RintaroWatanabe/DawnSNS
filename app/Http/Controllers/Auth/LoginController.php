<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    // ログインに成功したら、投稿一覧画面に遷移
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/top';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    //// ログイン処理メソッド ////
    public function login(Request $request){
        if($request->isMethod('post')){

            $data=$request->only('mail','password');
            // ログインが成功したら、トップページへ
            if(Auth::attempt($data)){
                // プロフィール画面でパスワードの文字数を表示するためにログイン時のパスワードの文字数をセッションで保存しておく
                $pass = $request->input('password');
                $password_count = mb_strlen($pass);
                // 現在のパスワードの文字数をpassword_countのキー名でセッションに保存
                session(['password_count' => $password_count]);

                // Top画面の表示
                return redirect('/top');
            } else {
                // 認証に失敗したときに表示するメッセージを保存
                Session::flash('error', 'メールアドレスまたはパスワードの入力に誤りがあります');
            }

        }
        return view("auth.login");  // ログイン画面へ遷移
    }


    //// ログアウト処理メソッド ////
    public function logout(Request $request) {
        Auth::logout();
        return redirect('login');
    }

}
