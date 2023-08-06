<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class UsersController extends Controller
{
    //
    public function profile(){
        return view('users.profile');
    }

    // ユーザー一覧を表示するメソッド
    public function search(Request $request){
        // データベースからユーザーを取得
        $users = DB::table('users')
                    ->get();
        $user_id = Auth::id();  // ログイン中のユーザーのIDを取得

        // ユーザーが検索されたら該当のユーザーのみ表示させる
        if($request->isMethod('post')){
            $data = $request->input('searchUsers');
            $users = DB::table('users')
                            ->where('username', 'like', '%'.$data.'%')
                            ->get();
            return view('users.search', ['users'=>$users, 'user_id'=>$user_id]);
        }

        // ユーザーが検索されない場合は全員を表示させる
        return view('users.search', ['users'=>$users, 'user_id'=>$user_id]);
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

}
