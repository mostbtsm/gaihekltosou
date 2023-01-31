@extends('layouts.app')

@section('header_left')
<a href="{{ route('user.painter.search', request()->query()) }}" class="btn-primary-round">絞込み検索</a>
@endsection

@section('body_class', 'bg-lightgray')

@section('content')
<div class="content-container">
  <user-painter-list-index></user-painter-list-index>
</div>
@endsection
