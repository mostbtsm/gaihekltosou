@extends('layouts.app')

@section('title', '設定')

@section('content')
<div class="form-container setting">
  <a href="{{ route('painter.update_password') }}" class="setting-link-btn">パスワード設定</a>
  <a href="{{ route('painter.withdraw') }}" class="setting-link-btn">退会</a>
</div>
@endsection