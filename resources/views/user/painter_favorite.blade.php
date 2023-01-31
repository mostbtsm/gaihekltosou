@extends('layouts.app')
@section('title', 'お気に入り一覧')
@section('body_class', 'bg-yellow')

@section('content')
<div class="content-container">
  <user-favorite-list-index></user-favorite-list-index>
</div>
@endsection
