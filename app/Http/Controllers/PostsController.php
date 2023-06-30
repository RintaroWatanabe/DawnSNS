<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class PostsController extends Controller
{
    // 投稿画面一覧
    public function index(){
        $posts = DB::table('posts')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->select('posts.id', 'users.username', 'posts.posts')
                    ->get();
        return view('posts.index', ['posts'=>$posts]);
    }

    // 新規投稿処理メソッド
    public function create(Request $request){
        $post = $request->input('newPost');
        $user_id = Auth::id();
        DB::table('posts')->insert([
            'posts' => $post,
            'user_id' => $user_id
        ]);
        return redirect('/top');
    }

    // 投稿内容の更新メソッド
    public function update(Request $request) {
        $id = $request->input("id");    // name属性がidの値を変数$idに代入
        $up_post = $request->input("upPost");     // name属性がupPostの値を変数$up_popstに代入
        DB::table("posts")      // postsテーブルのidカラムが変数$idのレコードのpostsカラムを変数$up_postに更新
            ->where("id", $id)
            ->update(["posts" => $up_post]);
        return redirect("/top");      // 投稿一覧に飛ぶ
    }

    // 投稿内容の削除メソッド
    public function delete($id){
        DB::table('posts')
            ->where('id', $id)
            ->delete();
        return redirect('/top');
    }

}
