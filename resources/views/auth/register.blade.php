@extends('layouts.logout')

@section('content')

{!! Form::open() !!}

<h2>新規ユーザー登録</h2>

<div>
{{ Form::label('username','ユーザー名') }}
{{ Form::text('username',old('username'),['class' => 'input']) }}
@error('username')
{{$message}}
@enderror
</div>

<div>
{{ Form::label('mail','メールアドレス') }}
{{ Form::text('mail',old('mail'),['class' => 'input']) }}
@error('mail')
{{$message}}
@enderror
</div>

<div>
{{ Form::label('password','パスワード') }}
{{ Form::password('password',null,['class' => 'input']) }}
@error('password')
{{$message}}
@enderror
</div>

<div>
{{ Form::label('password-confirm','パスワード確認') }}
{{ Form::password('password_confirmation',null,['class' => 'input']) }}
</div>

{{ Form::submit('登録') }}

<p><a href="/login">ログイン画面へ戻る</a></p>

{!! Form::close() !!}


@endsection
