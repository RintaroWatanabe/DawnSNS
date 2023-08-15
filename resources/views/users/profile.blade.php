@extends('layouts.login')

@section('content')

<div>
    <img src="/images/{{ $profile->images}}" alt="">
</div>

<!-- プロフィール編集フォーム -->
{!! Form::open() !!}

    <!-- ユーザー名 -->
    <div>
      {{ Form::label('username','UserName') }}
      {{ Form::text('username', $profile->username, ['class' => 'input']) }}
      @error('username')
      {{$message}}
      @enderror
    </div>

    <!-- メールアドレス -->
    <div>
      {{ Form::label('mail','MailAdress') }}
      {{ Form::text('mail',$profile->mail,['class' => 'input']) }}
      @error('mail')
      {{$message}}
      @enderror
    </div>

    <!-- 既存パスワード、編集不可 -->
    <div>
      {{ Form::label('password','Password') }}
      {{ Form::text('password', $current_password,['class' => 'input', 'disabled' => 'disabled']) }}
      @error('password')
      {{$message}}
      @enderror
    </div>

    <!-- 新パスワード -->
    <div>
      {{ Form::label('password','New Password') }}
      {{ Form::password('password',null,['class' => 'input']) }}
      @error('password')
      {{$message}}
      @enderror
    </div>

    <!-- 自己紹介 -->
    <div>
      {{ Form::label('bio','Bio') }}
      {{ Form::textarea('bio', $profile->bio, ['class' => 'input']) }}
    </div>

    <!-- プロフィール画像選択 -->
    <div>
      {{ Form::label('file', 'Icon Image') }}
      {{ Form::file('file', ['class' => 'input']) }}
    </div>

    <!-- 更新ボタン -->
    {{ Form::submit('更新') }}

    <!-- プロフィール編集フォーム終了 -->
{!! Form::close() !!}

@endsection
