<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;


class UsersController extends Controller
{
    //// 自分のプロフィール表示メソッド ////
    public function profile(){
        // 現在ログインしているユーザーのIDを取得
        $user_id = Auth::id();

        // usersテーブルから自分のカラムを取得
        $profile = DB::table('users')
                    ->where('id', '=', $user_id)
                    ->first();

        // ログイン時のパスワードの文字数をセッションから取り出す
        $current_password = session('current_password');

        // プロフィール画面を表示
        return view('users.profile', ['profile'=>$profile, 'current_password'=>$current_password]);
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

        return redirect('/users/search');   // ユーザー一覧画面へ遷移
    }


    //// ユーザー一覧画面でフォローをはずす処理メソッド ////
    public function unfollow(Request $request){
        $follow_id = $request->input("follow_id");  // フォローしているユーザーのIDを代入
        $follower_id = Auth::id();  // ログイン中のフォロワーのユーザーIDを取得
        DB::table('follows')    // フォローをはずすボタンを押された対象ユーザーのフォローを解除
            ->where([['follow', '=', $follow_id],['follower', '=', $follower_id]])
            ->delete();

        return redirect('/users/search');   // ユーザー一覧画面へ遷移
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

}
