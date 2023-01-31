<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <meta name="format-detection" content="telephone=no">
    <!-- CSRF Token-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <!-- meta title description -->
    <title>{{ config('const.app_name') }}</title>
  
    <!-- OGP -->
    <!--
      <meta property="og:locale" content="ja_JP" />
      <meta property="og:type" content="website" />
      <meta property="og:title" content="タイトル" />
      <meta property="og:description" content="" />
      <meta property="og:site_name" content="タイトル" />
      <meta property="og:image" content="" />
      <meta property="og:image:secure_url" content="" />
      <meta property="og:image:width" content="1200" />
      <meta property="og:image:height" content="630" />
      <meta name="twitter:card" content="summary_large_image" />
      <meta name="twitter:description" content="" />
      <meta name="twitter:title" content="タイトル" />
      <meta name="twitter:image" content="" />
      -->
  
    <!-- favicon -->
    <!--
      <link rel="shortcut icon" href="{{ asset('image/common/favicon.ico') }}">
      <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/common/touch-icon.png') }}">
      -->
  
    <!-- Styles-->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  </head>

    <body>
        <div id="app">
            @if ($errors->any())
            <div>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif
            <div class="admin-login-form">
                <h1>管理者ログイン</h1>
                <form action="/admin/login" method="post">
                    @csrf
                    <div class="form-div">
                        <div> <label for="username">ユーザ名</label></div>
                        <div>                    
                            <input type="text" name="username" value="">
                        </div>
                    </div>
                    <div class="form-div">
                        <div>パスワード</div>
                        <div>
                            <input type="password" name="password" value="">
                        </div>
                    </div>
                    <div class="login-button">
                        <button type="submit">ログイン</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </body>
</html>
