<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class PostsController extends Controller
{


    //// 投稿画面一覧(Top画面)表示メソッド ////
    public function index(){
        // 自分のフォロー人数をカウントして変数に保存
        $follow_num = DB::table('follows')
        ->where('follower',Auth::id())
        ->count();
        // 自分のフォロー人数をカウントするして変数に保存
        $follower_num = DB::table('follows')
        ->where('follow',Auth::id())
        ->count();

        // 自分とフォローユーザーの投稿内容のみを、投稿日時が新しい順に取得する
        // 現在認証しているユーザーのIDを取得
        $user_id = Auth::id();

        // 自分がフォローしているユーザーのid一覧を配列で取得する
        $follow_id_lists = Db::table('follows')
                        ->where("follower", '=', $user_id)
                        ->join('users', 'follows.follow', '=', 'users.id')
                        ->select('users.id')
                        ->pluck('id')   // idカラムのみ取得
                        ->toArray();    // 配列に変換

        // 自分の投稿と、フォローユーザーの投稿を取得
        // 配列$follow_id_listsの要素にuser_idがある＝自分がそのユーザーをフォローしている
        $posts = DB::table('posts')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->where('posts.user_id', '=', $user_id)   // 自分の投稿を取得
                    ->orwhereIn('posts.user_id', $follow_id_lists)  // 自分のフォローユーザーの投稿を取得
                    ->select('posts.*', 'users.username', 'users.images')
                    ->latest()
                    ->get();

        // Top画面を表示
        return view('posts.index', ['posts'=>$posts, 'user_id'=>$user_id,'follow_num' => $follow_num,'follower_num' => $follower_num]);
    }


    //// 新規投稿処理メソッド ////
    public function create(Request $request){
        // フォームから送られたname属性がnewPostの値を格納
        $post = $request->input('newPost');
        // 現在認証しているユーザーのIDを取得
        $user_id = Auth::id();

        // 150文字以上の投稿ができないようにする
        $request->validate(
            ['newPost' => 'max:150'],
            ['newPost.max' => '150文字以内で入力してください']);

        // 投稿内容をデータベースに登録する
        DB::table('posts')->insert([
            'posts' => $post,
            'user_id' => $user_id,
            'created_at' => Carbon::now(),  // 現在時刻を自動で取得
            'updated_at' => Carbon::now()
        ]);

        if (isset($error)) {
        return redirect('/top', ['showModal' => true, 'errors' => $errors]);
}

        return redirect('/top');    // Top画面へ遷移
    }

    //// 投稿内容の更新メソッド ////
    public function update(Request $request) {
        // フォームから送られたname属性がidの値を変数$idに代入
        $id = $request->input("id");
        // フォームから送られたname属性がupPostの値を変数$up_postに代入
        $up_post = $request->input("upPost");

        // 150文字以上の投稿ができないようにする
        $request->validate(
            ['upPost' => 'max:150'],
            ['upPost.max' => '150文字以内で入力してください']);

        // postsテーブルのidカラムが変数$idと一致するレコードのpostsカラムを変数$up_postの値に更新
        DB::table("posts")
            ->where("id", '=', $id)
            ->update(["posts" => $up_post]);

        return redirect('/top');    // Top画面へ遷移
    }

    //// 投稿内容の削除メソッド ////
    public function delete(Request $request){
        // フォームから送られたname属性がidの値を変数$idに代入
        $id = $request->input("id");
        // postsテーブルのidカラムが変数$idと一致するレコードを削除
        DB::table('posts')
            ->where('id', '=', $id)
            ->delete();

        return redirect('/top');    // Top画面へ遷移
    }

}
