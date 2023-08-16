<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;


class UsersController extends Controller
{
    // 自分のプロフィール表示メソッド
    public function profile(){
        $user_id = Auth::id();      // 現在ログインしているユーザーのIDを取得
        $profile = DB::table('users')
                    ->where('id', '=', $user_id)
                    ->first();
        $current_password = session('current_password');    // ログイン時のパスワードの文字数をセッションから取り出す
        return view('users.profile', ['profile'=>$profile, 'current_password'=>$current_password]);
    }

    // ユーザー一覧を表示するメソッド
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

        // ユーザーが検索されたら該当のユーザーのみ表示させる
        if($request->isMethod('post')){
            $data = $request->input('searchUsers');
            $users = DB::table('users')
                            ->where('username', 'like', '%'.$data.'%')
                            ->get();
            return view('users.search', ['users'=>$users, 'user_id'=>$user_id, 'follow_id_lists'=>$follow_id_lists]);
        }

        // ユーザーが検索されない場合は全員を表示させる
        return view('users.search', ['users'=>$users, 'user_id'=>$user_id, 'follow_id_lists'=>$follow_id_lists]);
    }

    // ユーザー一覧画面でフォローする処理
    public function follow(Request $request){
        $follow_id = $request->input("follow_id");  // フォローするユーザーのIDを代入
        $follower_id = Auth::id();  // ログイン中のフォロワーのユーザーIDを取得
        DB::table('follows')->insert([
            'follow' => $follow_id,
            'follower' => $follower_id
        ]);
        return redirect('/users/search');
    }

    // ユーザー一覧画面でフォローをはずす処理
    public function unfollow(Request $request){
        $follow_id = $request->input("follow_id");  // フォローしているユーザーのIDを代入
        $follower_id = Auth::id();  // ログイン中のフォロワーのユーザーIDを取得
        DB::table('follows')    // フォローをはずすボタンを押された対象ユーザーのフォローを解除
            ->where([['follow', '=', $follow_id],['follower', '=', $follower_id]])
            ->delete();
        return redirect('/users/search');
    }

    // フォロー・フォロワーのプロフィールと投稿取得メソッド
    public function followProfile($id){
        // 現在ログインしているユーザーのIDを取得
        $user_id = Auth::id();
        // ユーザーのプロフィールを取得
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
        // ユーザーの投稿内容を取得
        $posts = DB::table('posts')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->where('posts.user_id', '=', $id)
                    ->get();
        return view('users.followProfile', ['users'=>$users, 'posts'=>$posts, 'follow_id_lists'=>$follow_id_lists]);
    }

}
