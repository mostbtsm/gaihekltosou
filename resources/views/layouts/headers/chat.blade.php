<header id="chat-header" class="sticky-top">
  <div class="d-flex bg-topbar justify-content-center">
    <div class="topbar-left">
      @yield('header_left')
    </div>
    <div class="topbar-center">
      <span class="text-primary page-title">@yield('title')</span>
    </div>
    <div class="topbar-right">
      @yield('header_right')
    </div>
  </div>
</header>