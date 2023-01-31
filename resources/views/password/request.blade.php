@extends('layouts.app')
@section('content')

<div class="container-fluid d-flex justify-content-center mt-5">
  <div class="row form-container password-form">
    <div class="col">
      @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="hidden" name="arg" value="{{ $arg }}">

        <div class="form-group">
          <label for="email">メールアドレス</label>
          <input id="email" type="email" class="form-control" name="email" aria-describedby="email_help" value="{{ old('email') }}" required autocomplete="email" autofocus>

          @error('email')
          <small id="email_help" class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>

        <button type="submit" class="btn-send mt-5">送信</button>
      </form>
    </div>
  </div>
</div>

@endsection