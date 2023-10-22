@extends('layouts.login')

@section('content')

<div class='profile'>
    <img class='profile-img' src="storage/images/{{ $profile->images }}" alt="">
</div>

<!-- プロフィール編集フォーム -->
<!-- ファイルを送れるように記述 -->
{!! Form::open(['url' => '/update-profile','files' => 'true']) !!}

    <!-- ユーザー名 -->
    <div class='profile'>
      {{ Form::label('upName', 'UserName') }}
      {{ Form::text('upName', $profile->username, ['class' => 'input', 'style' => 'width: 200px;']) }}
      <br>
      <!-- 更新された時のメッセージ -->
      {{ session('upName') }}
      <!-- バリデーションエラー時のメッセージ -->
      @error('upName')
      {{$message}}
      @enderror
    </div>

    <!-- メールアドレス -->
    <div class='profile'>
      {{ Form::label('upMail', 'MailAdress') }}
      {{ Form::text('upMail', $profile->mail, ['class' => 'input', 'style' => 'width: 200px;']) }}
      <br>
      <!-- 更新された時のメッセージ -->
      {{ session('upMail') }}
      <!-- バリデーションエラー時のメッセージ -->
      @error('upMail')
      {{$message}}
      @enderror
    </div>

    <!-- 既存パスワード、編集不可 -->
    <div class='profile'>
      {{ Form::label('Password','Password') }}
      {{ Form::text('Password',$current_password,['class' => 'input', 'disabled' => 'disabled', 'style' => 'width: 200px;']) }}
    </div>

    <!-- 新パスワード -->
    <div class='profile'>
      {{ Form::label('upPassword', 'New Password') }}
      {{ Form::password('upPassword', null, ['class' => 'input', 'style' => 'width: 200px;']) }}
      <br>
      <!-- 更新された時のメッセージ -->
      {{ session('upPassword') }}
      <!-- バリデーションエラー時のメッセージ -->
      @error('upPassword')
      {{$message}}
      @enderror
    </div>

    <!-- 自己紹介 -->
    <div class='profile'>
      {{ Form::label('upBio','Bio') }}
      {{ Form::textarea('upBio', $profile->bio, ['class' => 'bio-input', 'cols'=> 60, 'rows' => 5,]) }}
      <br>
      <!-- 更新された時のメッセージ -->
      {{ session('upBio') }}
      <!-- バリデーションエラー時のメッセージ -->
      @error('upBio')
      {{$message}}
      @enderror
    </div>

    <!-- プロフィール画像選択 -->
    <div class='profile'>
      {{ Form::label('upFile', 'Icon Image') }}
      {{ Form::file('upFile', ['class' => 'input']) }}
      <br>
      <!-- 更新された時のメッセージ -->
      {{ session('upImage') }}
      <!-- バリデーションエラー時のメッセージ -->
      @error('upFile')
      {{$message}}
      @enderror
    </div>

    <!-- 更新ボタン -->
    <div class='profile'>
    {{ Form::submit('こうしん') }}
    </div>

    <!-- プロフィール編集フォーム終了 -->
{!! Form::close() !!}

@endsection
