<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Validation\Rule;



class UsersController extends Controller
{
    //// 自分のプロフィール表示メソッド ////

    public function profile(){
        // 自分のフォロー人数をカウントして変数に保存
        $follow_num = DB::table('follows')
        ->where('follower',Auth::id())
        ->count();
        // 自分のフォロー人数をカウントするして変数に保存
        $follower_num = DB::table('follows')
        ->where('follow',Auth::id())
        ->count();

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
        return view('users.profile', ['profile'=>$profile, 'current_password'=>$current_password,'follow_num' => $follow_num,'follower_num' => $follower_num]);
    }


    //// 自分のプロフィール更新処理 ////
    public function updateProfile(Request $request){
        // 現在認証しているユーザーのメールアドレスを取得
        $auth_mail = Auth::user()->mail;

        // バリデーション
        $request->validate(
        [
            'upName' => 'required|string|min:4|max:12',
            'upMail' => ['required','email','min:4','max:50',Rule::unique('users','mail')->ignore($auth_mail,'mail')],  // 自分が登録したメールアドレス以外とは重複不可
            'upPassword' => 'nullable|string|min:8|max:12',    // 空文字を許容
            'upBio' => 'nullable|string|max:200',   // 空文字を許容
            'upFile' => 'image',
        ],
        [
            'upName.required' => '必須項目です',
            'upName.string' => '使用できない文字が含まれています',
            'upName.min' => 'ユーザー名は4文字以上、12文字以内で入力してください',
            'upName.max' => 'ユーザー名は4文字以上、12文字以内で入力してください',
            'upMail.required' => '必須項目です',
            'upMail.string' => '使用できない文字が含まれています',
            'upMail.email' => 'メールアドレスの形式が正しくありません',
            'upMail.min' => 'メールアドレスは4文字以上で入力してください',
            'upMail.max' => 'メールアドレスは最大50文字までです',
            'upMail.unique' => 'このメールアドレスは既に使用されています',
            'upPassword.string' => '使用できない文字が含まれています',
            'upPassword.min' => 'パスワードは8文字以上、12文字以内で入力してください',
            'upPassword.max' => 'パスワードは8文字以上、12文字以内で入力してください',
            'upBio.string' => '使用できない文字が含まれています',
            'upBio.max' => '200文字以内で入力してください',
            'upFile.image' => '画像のみ登録可能です',
        ]);

        // 現在認証しているユーザーのIDを取得
        $user_id = Auth::id();
        // フォームから送られた値を格納
        $up_name = $request->input('upName');
        $up_mail = $request->input('upMail');
        $up_password = $request->input('upPassword');
        $up_bio = $request->input('upBio');

        // 変数$up_passwordが空文字の時は変数を削除する
        if($up_password == ''){
            unset($up_password);
        }
        // 画像がフォームから送られていいる場合は、imagesフォルダに画像を保存
        if(request('upFile')){
            $file_name = $request->file('upFile')->getClientOriginalName();     // 画像名を取得
            $request->file('upFile')->storeAs('public/images',$file_name);      // 画像を保存
        } else {    // 画像がフォームから送られていいない時は、現在のファイル名を取得
            $file_name = DB::table('users')
            ->where('id',Auth::id())
            ->value('images');  // imagesカラムの値のみ取得
        }

        // usersテーブルのidカラムが変数$user_idと一致するレコードのカラムをそれぞれ更新
        DB::table("users")
            ->where("id", '=', $user_id)
            ->update([
                "username" => $up_name,
                "mail" => $up_mail,
                "bio" => $up_bio,
                "images" => $file_name,
            ]);

        // 新しいパスワードが入力された場合、セッションに保存してレコードを更新する
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

        return redirect('/profile');    // プロフィール画面に遷移
    }


    //// ユーザー一覧を表示するメソッド ////
    public function search(Request $request){
        // 自分のフォロー人数をカウントして変数に保存
        $follow_counts = DB::table('follows')
        ->where('follower',Auth::id())
        ->count();
        // 自分のフォロー人数をカウントするして変数に保存
        $follower_counts = DB::table('follows')
        ->where('follow',Auth::id())
        ->count();

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

            return view('users.search', ['word'=>$word, 'users'=>$users, 'user_id'=>$user_id, 'follow_id_lists'=>$follow_id_lists,'follow_counts' => $follow_counts,'follower_counts' => $follower_counts]);   // 検索結果一覧を表示
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


    //// フォロー・フォロワーのプロフィールと投稿内容表示メソッド ////
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
