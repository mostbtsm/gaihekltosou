<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="全国から集まった業者の中から、あなたの条件にあった塗装会社を見つけられます。気に入った業者とはこのサイト内でやり取りできるので便利">
  <meta name="keywords" content="塗替え道場、日本塗装職人の集まる会、外壁塗装">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="format-detection" content="telephone=no">
  <!-- CSRF Token-->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- meta title description -->
  <title>{{ config('const.app_name') }}</title>

  <meta property="og:locale" content="ja_JP" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="{{ config('const.app_name') }}" />
  <meta property="og:description" content="全国から集まった業者の中から、あなたの条件にあった塗装会社を見つけられます。気に入った業者とはこのサイト内でやり取りできるので便利" />
  <meta property="og:site_name" content="tosoumatching" />
  <meta property="og:image" content="{{ asset('image/top.png') }}" />
  {{-- <meta property="og:image:secure_url" content="{{ asset('image/top.png') }}" /> --}}
  <meta property="og:image:width" content="749" />
  <meta property="og:image:height" content="803" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:description" content="全国から集まった業者の中から、あなたの条件にあった塗装会社を見つけられます。気に入った業者とはこのサイト内でやり取りできるので便利!まずはここから集者を見てみてください。" />
  <meta name="twitter:title" content="{{ config('const.app_name') }}" />
  <meta name="twitter:image" content="{{ asset('image/top.png') }}" />


  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
