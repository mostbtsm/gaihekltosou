<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.head')

<body class="@yield('body_class')">
<div id="app">
  @if (Auth::guard('painter')->check())
  @include('layouts.headers.painter')
  @elseif (Auth::guard('user')->check())
  @include('layouts.headers.user')
  @else
  @include('layouts.headers.guest')
  @endif


  @if (Auth::guard('painter')->check() || Auth::guard('user')->check())
  <div class="pb-5 mb-5">
    @yield('content')
  </div>
  @else
  <div>
    @yield('content')
  </div>
  @endif

  @if (Auth::guard('painter')->check())
  @include('layouts.footers.painter')
  @elseif (Auth::guard('user')->check())
  @include('layouts.footers.user')
  @else
  <!-- @include('layouts.footers.guest') -->
  @endif
</div>
  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>

</body>

</html>