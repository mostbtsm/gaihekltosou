@extends('layouts.app')
@section('title', 'コラム一覧')
@section('content')
<div class="d-flex justify-content-center">
  <div class="row content-container">
    <div class="col" style="text-align: center; color: #3490dc;">
      コラムは3件まで登録可能です
    </div>
  </div>
</div>

<div class="form-container">
  <div class="col-12" style="padding:5px 7px 0 7px">
    @if(!$createBtnDisable)
    <div class="button-div">
      <a href="{{ route('painter.column.create') }}" class="btn-regester btn-round">新規投稿する</a>
    </div>
    @endif
  </div>

  <painter-column-list></painter-column-list>
</div>
@endsection