<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class PostsController extends Controller
{
    //投稿画面一覧
    public function index(){
        $posts = DB::table('posts')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->get();
        return view('posts.index', ['posts'=>$posts]);
    }

    //新規投稿処理メソッド
    public function create(Request $request){
        $post = $request->input('newPost');
        $user_id = Auth::id();
        DB::table('posts')->insert([
            'posts' => $post,
            'user_id' => $user_id
        ]);
        return redirect('/top');
    }

}
