@extends('layouts.login')

@section('content')

<div>
    <img class='profile-img' src="storage/images/{{ $profile->images }}" alt="">
</div>

<!-- プロフィール編集フォーム -->
<!-- ファイルを送れるように記述 -->
{!! Form::open(['url' => '/update-profile','files' => 'true']) !!}

    <!-- ユーザー名 -->
    <div>
      {{ Form::label('upName', 'UserName') }}
      {{ Form::text('upName', $profile->username, ['class' => 'input', 'style' => 'width: 200px;']) }}
      @error('upName')
      {{$message}}
      @enderror
    </div>

    <!-- メールアドレス -->
    <div>
      {{ Form::label('upMail', 'MailAdress') }}
      {{ Form::text('upMail', $profile->mail, ['class' => 'input', 'style' => 'width: 200px;']) }}
      @error('upMail')
      {{$message}}
      @enderror
    </div>

    <!-- 既存パスワード、編集不可 -->
    <div>
      {{ Form::label('Password','Password') }}
      {{ Form::text('Password',$current_password,['class' => 'input', 'disabled' => 'disabled', 'style' => 'width: 200px;']) }}
    </div>

    <!-- 新パスワード -->
    <div>
      {{ Form::label('upPassword', 'New Password') }}
      {{ Form::password('upPassword', null, ['class' => 'input', 'style' => 'width: 200px;']) }}
      @error('upPassword')
      {{$message}}
      @enderror
    </div>

    <!-- 自己紹介 -->
    <div>
      {{ Form::label('upBio','Bio') }}
      {{ Form::textarea('upBio', $profile->bio, ['class' => 'input', 'cols'=> 60, 'rows' => 4,]) }}
      @error('upBio')
      {{$message}}
      @enderror
    </div>

    <!-- プロフィール画像選択 -->
    <div>
      {{ Form::label('upFile', 'Icon Image') }}
      {{ Form::file('upFile', ['class' => 'input']) }}
      @error('upFile')
      {{$message}}
      @enderror
    </div>

    <!-- 更新ボタン -->
    {{ Form::submit('更新') }}

    <!-- プロフィール編集フォーム終了 -->
{!! Form::close() !!}

@endsection
