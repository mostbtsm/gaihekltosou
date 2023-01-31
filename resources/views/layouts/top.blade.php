<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.head')

<body>
<div id="app">
  @if (Auth::guard('painter')->check())
  @include('layouts.headers.painter')
  @elseif (Auth::guard('user')->check())
  @include('layouts.headers.user')
  @else
  <header id="header" class="sticky-top">
    <div class="row bg-topbar">
      <div class="col" style="text-align: right;height: 33px;line-height: 33px;">
        <a class="text-white pr-2 btn-primary-round" href="{{ route('entry_login') }}">ログイン</a>
        <a class="text-white pr-2 btn-primary-round" href="{{ route('entry') }}">新規会員登録</a>
      </div>
    </div>
  </header>
  @endif

  <div>
    @yield('content')
  </div>

</div>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>

</body>

</html>