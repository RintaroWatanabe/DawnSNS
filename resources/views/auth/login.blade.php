@extends('layouts.logout')

@section('content')

{!! Form::open() !!}

<p class='login'>DAWNSNSへようこそ</p>

<div class='login'>{{ Form::label('MailAdress') }}</div>
<div class='login'>{{ Form::text('mail',null,['class' => 'input']) }}</div>
<div class='login'>{{ Form::label('Password') }}</div>
<div class='login'>{{ Form::password('password',['class' => 'input']) }}</div>
<div class='login'>{{ Form::submit('ログイン') }}</div>

<p class='login'><a href="/register">新規ユーザーの方はこちら</a></p>

{!! Form::close() !!}

@endsection
