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
    // ログイン中のみ閲覧可能なページ

    // 投稿一覧画面
    Route::get('/top','PostsController@index');

    // 新規投稿処理
    Route::post('/top','PostsController@create');

    // 投稿内容更新処理
    Route::post("posts/update", "PostsController@update");

    // 投稿内容削除処理
    Route::get('posts/{id}/delete', 'PostsController@delete');

    Route::get('/profile','UsersController@profile');

    Route::get('users/search','UsersController@index');

    Route::get('/follow-list','PostsController@index');
    Route::get('/follower-list','PostsController@index');
});


//ログアウト中のページ
Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::post('/login', 'Auth\LoginController@login');

// 新規登録フォーム画面
Route::get('/register', 'Auth\RegisterController@register');
Route::post('/register', 'Auth\RegisterController@register');

// 新規登録直後に名前を表示するページ
Route::get('/added', 'Auth\RegisterController@added');
