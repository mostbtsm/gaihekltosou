@extends('layouts.app')
@section('content')

<div class="container-fluid d-flex justify-content-center">
  <div class="row form-container password-form">
    <div class="col">
      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="arg" value="{{ $arg }}">
        <input type="hidden" name="token" value="{{ $token }}">


        <div class="form-group">
          <label for="email">メールアドレス</label>
          <input id="email" type="email" class="form-control" name="email" aria-describedby="email_help" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

          @error('email')
          <small id="email_help" class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="form-group">
          <label for="password">新しいパスワード</label>
          <input id="password" type="password" class="form-control" name="password" aria-describedby="password_help" required autocomplete="new-password">

          @error('password')
          <small id="password_help" class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="form-group">
          <label for="password-confirm">確認用</label>
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn-send mt-5">設定</button>
      </form>
    </div>
  </div>
</div>
@endsection