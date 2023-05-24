@extends('layouts.logout')

@section('content')

{!! Form::open() !!}

<h2>新規ユーザー登録</h2>

{{ Form::label('username','ユーザー名') }}
{{ Form::text('username',null,['class' => 'input']) }}

{{ Form::label('mail','メールアドレス') }}
{{ Form::text('mail',null,['class' => 'input']) }}

{{ Form::label('password','パスワード') }}
{{ Form::text('password',null,['class' => 'input']) }}

{{ Form::label('password-confirm','パスワード確認') }}
{{ Form::text('password-confirm',null,['class' => 'input']) }}

{{ Form::submit('登録') }}

<p><a href="/login">ログイン画面へ戻る</a></p>

{!! Form::close() !!}


@endsection
