@extends('layouts.logout')

@section('content')

<!-- 新規ユーザー登録フォーム -->
{!! Form::open() !!}

<h2 class='register'>新規ユーザー登録</h2>

<!-- ユーザー名 -->
<div class='register'>{{ Form::label('username','UserName') }}</div>
<div class='register'>
{{ Form::text('username',old('username'),['class' => 'input']) }}
<br>
@error('username')
{{$message}}
@enderror
</div>

<!-- メールアドレス -->
<div class='register'>{{ Form::label('mail','MailAdress') }}</div>
<div class='register'>
{{ Form::text('mail',old('mail'),['class' => 'input']) }}
<br>
@error('mail')
{{$message}}
@enderror
</div>

<!-- パスワード -->
<div class='register'>{{ Form::label('password','Password') }}</div>
<div class='register'>
{{ Form::password('password',null,['class' => 'input']) }}
<br>
@error('password')
{{$message}}
@enderror
</div>

<!-- パスワード確認 -->
<div class='register'>{{ Form::label('password-confirm','Password confirm') }}</div>
<div class='register'>
{{ Form::password('password_confirmation',null,['class' => 'input']) }}
</div>

<!-- 登録ボタン -->
<div  class='register'>
{{ Form::submit('登録') }}
</div>

<!-- ログイン画面へ戻るボタン -->
<p class='register'><a class='login' href="/login">ログイン画面へ戻る</a></p>

<!-- 新規ユーザー登録フォーム終了 -->
{!! Form::close() !!}


@endsection
