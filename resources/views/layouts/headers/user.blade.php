<header id="header" class="sticky-top">
  <div class="d-flex bg-topbar justify-content-center">
    <div class="topbar-left">
      @yield('header_left')
    </div>
    <div class="topbar-center">
      <a class="text-white page-title" href="#">@yield('title')</a>
    </div>
    <div class="topbar-right">
      <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#header-toggle-menu" aria-controls="header-toggle-menu" aria-expanded="false">
        <i class="fa fa-bars"></i>
      </button>
    </div>
  </div>

  <div class="collapse navbar-collapse" id="header-toggle-menu">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('user.mypage') }}">マイページ</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('user.logout') }}">ログアウト</a>
      </li>
    </ul>
  </div>
</header>