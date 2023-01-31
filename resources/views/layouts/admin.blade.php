<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.head')

<body>
<div id="app">
  @if (Auth::guard('admin')->check())
  @include('layouts.headers.admin')
  @endif

  <div>
    @yield('content') 
  </div>
  
  @if (Auth::guard('admin')->check())
  @include('layouts.footers.admin')
  @endif
</div>
  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>
 
</body>

</html>