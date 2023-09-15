@extends('layouts.logout')

@section('content')

{{ Form::open() }}

<p class='login'>DAWNSNSへようこそ</p>

<!-- ログインに失敗した場合はエラーメッセージを表示 -->
<div class='login'>{{ session('error') }}</div>

<div class='login'>{{ Form::label('mail', 'MailAdress') }}</div>
<div class='login'>{{ Form::text('mail',null,['class' => 'input', 'style' => 'width: 200px;']) }}</div>
<div class='login'>{{ Form::label('password', 'Password') }}</div>
<div class='login'>{{ Form::password('password',['class' => 'input', 'style' => 'width: 200px;']) }}</div>
<div class='login'>{{ Form::submit('ログイン') }}</div>

<p class='login'><a class='login' href="/register">新規ユーザーの方はこちら</a></p>

{{ Form::close() }}

@endsection
