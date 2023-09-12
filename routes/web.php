<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();


// 認可の機能
Route::group(['middleware' => ['auth']], function() {
    //// ログイン中のみ閲覧可能なページ ////


    // 投稿一覧画面(Top画面)
    Route::get('/top','PostsController@index');
    // 新規投稿
    Route::post('/top','PostsController@create');
    // 投稿内容更新
    Route::post("posts/update", "PostsController@update");
    // 投稿内容削除
    Route::post('posts/delete', 'PostsController@delete');


    // 自分のプロフィール画面
    Route::get('/profile','UsersController@profile');
    // 自分のプロフィール更新処理
    Route::post('/update-profile','UsersController@updateProfile');


    // ユーザー一覧画面
    Route::get('users/search','UsersController@search');
    // ユーザー一覧画面(ユーザー検索時)
    Route::post('users/search','UsersController@search');
    // フォローする処理
    Route::post('users/follow','UsersController@follow');
    // フォローをはずす処理
    Route::post('users/unfollow','UsersController@unfollow');


    // フォローリスト一覧
    Route::get('/follow-list','FollowsController@followList');
    // フォロワーリスト一覧
    Route::get('/follower-list','FollowsController@followerList');


    // フォロー・フォロワーのプロフィール画面
    Route::get('users/{id}/followProfile', 'UsersController@followProfile');


    // ログアウト
    Route::post('/logout', 'Auth\LoginController@logout');
});


//// ログアウト中のページ ////


// ログイン画面
Route::get('/login', 'Auth\LoginController@login')->name('login');
// ログイン画面(フォーム送信時)
Route::post('/login', 'Auth\LoginController@login');


// 新規ユーザー登録フォーム画面
Route::get('/register', 'Auth\RegisterController@register');
// 新規ユーザー登録フォーム画面(フォーム送信時)
Route::post('/register', 'Auth\RegisterController@register');
// 新規ユーザー登録後に名前を表示するページ
Route::get('/added', 'Auth\RegisterController@added');
