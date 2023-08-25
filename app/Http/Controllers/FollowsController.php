<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class FollowsController extends Controller
{
    //// フォローリスト一覧表示メソッド ////
    public function followList(){
        // 自分のフォロー人数をカウントして変数に保存
        $follow_num = DB::table('follows')
        ->where('follower',Auth::id())
        ->count();
        // 自分のフォロー人数をカウントするして変数に保存
        $follower_num = DB::table('follows')
        ->where('follow',Auth::id())
        ->count();

        $follower_id = Auth::id();  // 自分のIDを取得

        // 自分がフォローしているユーザー一覧を表示するために名前と画像を取得する
        $follows_lists = DB::table('follows')
                        ->where("follower", '=',  $follower_id)
                        ->join('users', 'follows.follow', '=', 'users.id')
                        ->select('users.id', 'users.username', 'users.images')
                        ->get();

        // 自分がフォローしているユーザーのユーザー名、投稿内容、プロフィール画像、投稿日時を取得
        $follows_posts = DB::table('follows')
                    ->join('users', 'follows.follow', '=', 'users.id')
                    ->join('posts', 'users.id', '=', 'posts.user_id')
                    ->where("follower", '=',  $follower_id)
                    ->select('users.id', 'users.username', 'users.images', 'posts.posts', 'posts.created_at')
                    ->latest()
                    ->get();

        // フォローリストの画面表示
        return view('follows.followList', ['follows_lists'=>$follows_lists, 'follows_posts'=>$follows_posts, 'follow_num' => $follow_num,'follower_num' => $follower_num]);
    }

    //// フォロワー一覧表示メソッド ////
    public function followerList(){
        // 自分のフォロー人数をカウントして変数に保存
        $follow_num = DB::table('follows')
        ->where('follower',Auth::id())
        ->count();
        // 自分のフォロー人数をカウントするして変数に保存
        $follower_num = DB::table('follows')
        ->where('follow',Auth::id())
        ->count();

        // 自分のIDを取得
        $follower_id = Auth::id();

        // 自分のフォロワー一覧を表示するために名前と画像を取得する
        $followers_lists = DB::table('follows')
                        ->where("follow", '=', $follower_id)
                        ->join('users', 'follows.follower', '=', 'users.id')
                        ->select('users.id', 'users.username', 'users.images')
                        ->get();

        // 自分のフォロワーのユーザー名、投稿内容、プロフィール画像、投稿日時を取得
        $followers_posts = DB::table('follows')
                    ->join('users', 'follows.follower', '=', 'users.id')
                    ->join('posts', 'users.id', '=', 'posts.user_id')
                    ->where("follow", '=', $follower_id)
                    ->select('users.id', 'users.username', 'users.images', 'posts.posts', 'posts.created_at')
                    ->latest()
                    ->get();

        // フォロワーリストの画面表示
        return view('follows.followerList', ['followers_lists'=>$followers_lists, 'followers_posts'=>$followers_posts, 'follow_num' => $follow_num,'follower_num' => $follower_num]);
    }
}
