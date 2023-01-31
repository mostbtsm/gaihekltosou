<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.head')

<body class="bg-gray">
<div id="app">
  @include('layouts.headers.chat')

  <div>
    @yield('content')
  </div>

</div>
  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>

</body>

</html>