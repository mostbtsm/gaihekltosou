<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.head')

<body>
  <div id="app">
    <header id="secondary-header" class="sticky-top">
      <div class="d-flex bg-topbar justify-content-center">
        <div class="topbar-center">
          <span class="text-primary page-title">新規登録</span>
        </div>
      </div>
    </header>

    <div class="content-container">
      <a class="user-signup-btn" href="{{ route('user.entry') }}">個人のお客様は<br>こちら</a>
      <a class="painter-signup-btn" href="{{ route('painter.entry') }}">企業の方は<br />こちら</a>
    </div>

  </div>
  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>

</body>

</html>