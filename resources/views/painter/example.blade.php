@extends('layouts.app')
@section('title', '施工事例一覧')
@section('body_class', 'bg-dark')
@section('content')
<div class="d-flex justify-content-center">
  <div class="row content-container">
    <div class="col" style="text-align: center; color: #3490dc;">
      サイト外案件登録は3件まで登録可能です
    </div>
  </div>
</div>

<div class="form-container">
  <div class="col-12" style="padding:5px 7px 0 7px">
    @if(!$createBtnDisable)
    <div class="button-div">
      <a href="{{ route('painter.example.create') }}" class="btn-regester btn-round">サイト外案件登録</a>
    </div>
    @endif
  </div>

  <painter-example-list></painter-example-list>
</div>
@endsection