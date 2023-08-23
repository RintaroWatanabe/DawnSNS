<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;


class UsersController extends Controller
{

    // バリデーションメソッド
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'up_name' => 'required|string|max:255',
            'up_mail' => 'required|string|email|max:255|unique:users',
            'up_password' => 'string|min:8',
        ],
        [
            'up_name.required' => '必須項目です',
            'up_name.max' => 'ユーザー名は最大255文字までです',
            'up_name.string' => '使用できない文字が含まれています',
            'up_mail.required' => '必須項目です',
            'up_mail.email' => 'メールアドレスの入力が正しくありません',
            'up_username.string' => '使用できない文字が含まれています',
            'up_mail.max' => 'メールアドレスは最大255文字までです',
            'up_mail.unique' => 'このメールアドレスは既に使用されています',
            'up_password.string' => '使用できない文字が含まれています',
            'up_password.min' => '8文字以上で入力してください',
        ])->validate();
    }


    //// 自分のプロフィール表示メソッド ////
    public function profile(){
        // 現在ログインしているユーザーのIDを取得
        $user_id = Auth::id();

        // usersテーブルから自分のカラムを取得
        $profile = DB::table('users')
                    ->where('id', '=', $user_id)
                    ->first();

        // ログイン時のパスワードの文字数をセッションから取り出す
        $password_count = session('password_count');
        $current_password = str_repeat('⚫︎', $password_count);

        // プロフィール画面を表示
        return view('users.profile', ['profile'=>$profile, 'current_password'=>$current_password]);
    }


    //// 自分のプロフィール更新処理 ////
    public function updateProfile(Request $request){
        // 現在認証しているユーザーのIDを取得
        $user_id = Auth::id();
        // フォームから送られた値を格納
        $up_name = $request->input('upName');
        $up_mail = $request->input('upMail');
        $up_bio = $request->input('upBio');
        $up_password = $request->input('upPassword');
        // 変数$up_passwordが空文字の時は変数を削除する
        if($up_password == ''){
            unset($up_password);
        }

        // バリデーションチェック
        $data = compact('up_name', 'up_mail') ;
        $val = validator($data);


        // usersテーブルのidカラムが変数$user_idと一致するレコードのカラムをそれぞれ更新
        DB::table("users")
            ->where("id", '=', $user_id)
            ->update([
                "username" => $up_name,
                "mail" => $up_mail,
                "bio" => $up_bio
            ]);

        if(isset($up_password)){
            // 更新したパスワードの文字数をcurrent_passwordのキー名でセッションに保存
            $password_count = mb_strlen($up_password);
            session(['password_count' => $password_count]);
            // パスワードをハッシュ化
            $up_password = bcrypt($up_password);
            // usersテーブルのidカラムが変数$user_idと一致するレコードのパスワードを更新
            DB::table("users")
            ->where("id", '=', $user_id)
            ->update(["password" => $up_password]);
        }

        return redirect('/profile');
    }


    //// ユーザー一覧を表示するメソッド ////
    public function search(Request $request){
        // データベースからユーザーを取得
        $users = DB::table('users')
                    ->get();

        // ログイン中のユーザーのIDを取得
        $user_id = Auth::id();

        // 自分がフォローしているユーザーのid一覧を取得する
        $follow_id_lists = Db::table('follows')
                        ->where("follower", '=', $user_id)
                        ->join('users', 'follows.follow', '=', 'users.id')
                        ->select('users.id')
                        ->pluck('id')   // idカラムのみ取得
                        ->toArray();    // 配列に変換

        // ユーザーが検索された場合は該当のユーザーのみ表示させる処理
        if($request->isMethod('post')){
            $word = $request->input('searchUsers');     // フォームから送られた値を格納
            $users = DB::table('users')
                            ->where('username', 'like', '%'.$word.'%')  // あいまい検索
                            ->get();

            return view('users.search', ['word'=>$word, 'users'=>$users, 'user_id'=>$user_id, 'follow_id_lists'=>$follow_id_lists]);   // 検索結果一覧を表示
        }

        // ユーザーが検索されない場合は全ユーザーを表示させる
        return view('users.search', ['users'=>$users, 'user_id'=>$user_id, 'follow_id_lists'=>$follow_id_lists]);
    }


    //// ユーザー一覧画面でフォローする処理メソッド ////
    public function follow(Request $request){
        $follow_id = $request->input("follow_id");  // フォローするユーザーのIDを代入
        $follower_id = Auth::id();  // ログイン中のフォロワーのユーザーIDを取得
        DB::table('follows')->insert([
            'follow' => $follow_id,
            'follower' => $follower_id
        ]);

        return back();   // ユーザー一覧画面へ遷移
    }


    //// ユーザー一覧画面でフォローをはずす処理メソッド ////
    public function unfollow(Request $request){
        $follow_id = $request->input("follow_id");  // フォローしているユーザーのIDを代入
        $follower_id = Auth::id();  // ログイン中のフォロワーのユーザーIDを取得
        DB::table('follows')    // フォローをはずすボタンを押された対象ユーザーのフォローを解除
            ->where([['follow', '=', $follow_id],['follower', '=', $follower_id]])
            ->delete();

        return back();   // ユーザー一覧画面へ遷移
    }


    //// フォロー・フォロワーのプロフィールと投稿取得メソッド ////
    public function followProfile($id){
        // 現在ログインしているユーザーのIDを取得
        $user_id = Auth::id();

        // 選択したユーザーのプロフィールを取得
        $users = DB::table('users')
                    ->where('id', '=', $id)
                    ->first();

        // 自分がフォローしているユーザーのid一覧を取得する
        $follow_id_lists = Db::table('follows')
                        ->where("follower", '=', $user_id)
                        ->join('users', 'follows.follow', '=', 'users.id')
                        ->select('users.id')
                        ->pluck('id')   // idカラムのみ取得
                        ->toArray();    // 配列に変換

        // 選択したユーザーの投稿内容を取得
        $posts = DB::table('posts')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->where('posts.user_id', '=', $id)
                    ->get();

        // フォロー・フォロワーのプロフィール画面を表示
        return view('users.followProfile', ['users'=>$users, 'posts'=>$posts, 'follow_id_lists'=>$follow_id_lists]);
    }


    //// フォロー・フォロワーのプロフィール画面でフォローする処理メソッド ////
    public function profileFollow(Request $request){
        $follow_id = $request->input("follow_id");  // フォローするユーザーのIDを代入
        $follower_id = Auth::id();  // ログイン中のフォロワーのユーザーIDを取得
        DB::table('follows')->insert([
            'follow' => $follow_id,
            'follower' => $follower_id
        ]);

        return back();   // プロフィール画面へ遷移
    }


    //// フォロー・フォロワーのプロフィール画面でフォローをはずす処理メソッド ////
    public function profileUnfollow(Request $request){
        $follow_id = $request->input("follow_id");  // フォローしているユーザーのIDを代入
        $follower_id = Auth::id();  // ログイン中のフォロワーのユーザーIDを取得
        DB::table('follows')    // フォローをはずすボタンを押された対象ユーザーのフォローを解除
            ->where([['follow', '=', $follow_id],['follower', '=', $follower_id]])
            ->delete();

        return back();   // プロフィール画面へ遷移
    }

}
