@extends('layouts.logout')

@section('content')

<div id="clear">
<!-- 新規登録時に入力した名前セッションから取り出して表示する -->
<p class='added'>{{ session('new_user') }}さん</p>
<p class='added'>ようこそ！DAWNSNSへ！</p>
<p class='added'>ユーザー登録が完了しました。</p>
<p class='added'>さっそく、ログインをしてみましょう。</p>

<p class='added btn'><a href='/login'>ログイン画面へ</a></p>
</div>

@endsection
