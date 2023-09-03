<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <!--IEブラウザ対策-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="ページの内容を表す文章" />
    <title></title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <!--スマホ,タブレット対応-->
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <!--サイトのアイコン指定-->
    <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
    <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
    <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
    <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
    <!--iphoneのアプリアイコン指定-->
    <link rel="apple-touch-icon-precomposed" href="画像のURL" />
    <!--OGPタグ/twitterカード-->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script> <!-- jQuery -->
    <script src="{{ asset('js/script.js') }}"></script> <!-- jQuery -->
</head>
<body>
    <header>
        <div id = "head">
            <h1><a href="/top"><img src="/storage/images/main_logo.png"></a></h1>
                <div id="head-menu">
                    <div id="name">
                        <p class="user-name">{{Auth::user()->username}}さん</p>
                        <img class='profile-img' src="/storage/images/{{Auth::user()->images}}">
                    </div>
                    <!-- アコーディオンメニュー -->
                    <!-- 三角マーク -->
                    <span class="menu-trigger"></span>
                    <!-- メニューリスト -->
                    <div class="menu-list">
                        <ul class="list">
                            <li><a href="/top">HOME</a></li><hr>
                            <li><a href="/profile">プロフィール</a></li><hr>
                            <li>{{ Form::open(['url' => '/logout',
                                 'onsubmit' => 'return confirmLogout();']) }}
                                <button type='submit'>ログアウト</button>
                                {{ Form::close() }}</li>
                        </ul>
                    </div>
                </div>
        </div>

    </header>
    <div id="row">
        <div id="container">
            @yield('content')
        </div >
        <div id="side-bar">
            <div id="confirm">
                <p>{{Auth::user()->username}}さんの</p>
                <div>
                <p>フォロー数</p>
                <p>{{$follow_num}}名</p>
                </div>
                <p class="btn"><a class="side-btn" href="/follow-list">フォローリスト</a></p>
                <div>
                <p>フォロワー数</p>
                <p>{{$follower_num}}名</p>
                </div>
                <p class="btn"><a class="side-btn" href="/follower-list">フォロワーリスト</a></p>
            </div>
            <hr>
            <p class="btn"><a class="side-btn" href="/users/search">ユーザー検索</a></p>
        </div>
    </div>
    <footer>
    </footer>
</body>

<!-- ログアウト前に確認 -->
<script>
    function confirmLogout() {
        return confirm("ログアウトします。よろしいですか？");
    }
  </script>

</html>
