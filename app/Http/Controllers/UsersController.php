<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UsersController extends Controller
{
    //
    public function profile(){
        return view('users.profile');
    }

    public function search(Request $request){
        // データベースからユーザーを取得
        $users = DB::table('users')
                    ->get();

        // ユーザーが検索されたら該当のユーザーのみ表示させる
        if($request->isMethod('post')){
            $data = $request->input('searchUsers');
            $users = DB::table('users')
                            ->where('username', 'like', '%'.$data.'%')
                            ->get();
            return view('users.search', ['users'=>$users]);
        }

        // ユーザーが検索されない場合は全員を表示させる
        return view('users.search', ['users'=>$users]);
    }
}
