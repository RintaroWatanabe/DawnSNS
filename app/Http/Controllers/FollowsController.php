<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class FollowsController extends Controller
{
    // フォローリスト一覧表示メソッド
    public function followList(){
        $follower_id = Auth::id();
        $follows = DB::table('follows')
                    ->join('users', 'follows.follow', '=', 'users.id')
                    ->join('posts', 'users.id', '=', 'posts.user_id')
                    ->where("follower", $follower_id)
                    ->select('users.id', 'users.username', 'users.images', 'posts.posts', 'posts.created_at')
                    ->latest()
                    ->get();
        return view('follows.followList', ['follows'=>$follows]);
    }

    // フォロワー一覧表示メソッド
    public function followerList(){
        return view('follows.followerList');
    }
}
