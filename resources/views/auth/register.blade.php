@extends('layouts.logout')

@section('content')

<!-- 新規ユーザー登録フォーム -->
{!! Form::open() !!}

<h2>新規ユーザー登録</h2>

<!-- ユーザー名 -->
<div>
{{ Form::label('username','ユーザー名') }}
{{ Form::text('username',old('username'),['class' => 'input']) }}
@error('username')
{{$message}}
@enderror
</div>

<!-- メールアドレス -->
<div>
{{ Form::label('mail','メールアドレス') }}
{{ Form::text('mail',old('mail'),['class' => 'input']) }}
@error('mail')
{{$message}}
@enderror
</div>

<!-- パスワード -->
<div>
{{ Form::label('password','パスワード') }}
{{ Form::password('password',null,['class' => 'input']) }}
@error('password')
{{$message}}
@enderror
</div>

<!-- パスワード確認 -->
<div>
{{ Form::label('password-confirm','パスワード確認') }}
{{ Form::password('password_confirmation',null,['class' => 'input']) }}
</div>

<!-- 登録ボタン -->
{{ Form::submit('登録') }}

<!-- ログイン画面へ戻るボタン -->
<p><a href="/login">ログイン画面へ戻る</a></p>

<!-- 新規ユーザー登録フォーム終了 -->
{!! Form::close() !!}


@endsection
