@extends('layouts.app')
@section('title', '新規登録')
@section('content')

<div class="container-fluid d-flex justify-content-center">
  <div class="row form-container">
    <div class="register mt-5" style="text-align: center;">
      <h4 class="title">登録が完了しました。</h4>
      <p class="content">「ログイン」より会員ページに進み<br>プロフィールの設定を行ってください</p>
      <a href="{{ route('painter.login') }}" class="btn-send" role="button" aria-disabled="true">ログイン</a>
    </div>
  </div>
</div>

@endsection