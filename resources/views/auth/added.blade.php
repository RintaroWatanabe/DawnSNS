@extends('layouts.logout')

@section('content')

<div id="clear">
<!-- 新規登録時に入力した名前を表示させる -->
<p>{{ session('user') }}さん</p>
<p>ようこそ！DAWNSNSへ！</p>
<p>ユーザー登録が完了しました。</p>
<p>さっそく、ログインをしてみましょう。</p>

<p class="btn"><a href="/login">ログイン画面へ</a></p>
</div>

@endsection
