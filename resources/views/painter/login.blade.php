@extends('layouts.app')
@section('title', 'ログイン')
@section('content')

<div class="container-fluid d-flex justify-content-center mt-5 login-form">
  <div class="row form-container">
    <div class="col">
      <painter-login-form></painter-login-form>

      <div class="mt-5">
        <a href="{{ route('password.request', 'painters') }}">パスワードをお忘れの方はこちら</a>
        <a href="{{ route('painter.entry') }}">新規登録はこちら</a>
        <a href="{{ route('inquiries') }}">お問合せはこちら</a>
      </div>

    </div>
  </div>
</div>

@endsection