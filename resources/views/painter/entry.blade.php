@extends('layouts.app')
@section('title', '新規登録')
@section('content')

<div class="container-fluid d-flex justify-content-center mt-5 register">
  <div class="row form-container">
    <div class="col">
      <painter-entry-form></painter-entry-form>

      <div class="mt-5">
        <a href="{{ route('painter.login') }}">登録済の方はこちら</a>
      </div>

    </div>
  </div>
</div>

@endsection