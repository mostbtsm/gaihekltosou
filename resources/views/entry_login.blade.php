<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.head')

<body>
  <div id="app">
    <header id="secondary-header" class="sticky-top">
      <div class="d-flex bg-topbar justify-content-center">
        <div class="topbar-center">
          <span class="text-primary page-title">ログイン</span>
        </div>
      </div>
    </header>

    <div class="content-container">
      <a class="user-signup-btn" href="{{ route('user.login') }}">個人のお客様は<br>こちら</a>
      <a class="painter-signup-btn" href="{{ route('painter.login') }}">企業の方は<br />こちら</a>
    </div>

  </div>
  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>

</body>

</html>