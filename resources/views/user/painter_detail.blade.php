@extends('layouts.app')
@section('title', '')
@section('body_class', 'bg-lightgray')
@section('content')

<div class="content-container">
  <user-painter-detail :painter_id="{{ $painter->id }}"></user-painter-detail>
</div>
@endsection