@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col d-flex justify-content-center">
    <h2>一般会員トップ</h2>
  </div>
</div>

<div class="container-fluid d-flex justify-content-center">
  <div class="row form-container">
    <div class="col" style="text-align: center;">
      <p>{{ $user->email }}</p>
      <a href="{{ route('user.mypage') }}" class="btn btn-primary btn-md btn-block mt-5" role="button" aria-disabled="true">マイページ</a>
    </div>
  </div>
</div>

@endsection