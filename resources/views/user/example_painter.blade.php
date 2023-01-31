@extends('layouts.app')
@section('title', $painter->name . '　施工事例')
@section('body_class', 'bg-dark')
@section('content')
<div class="content-container">
  <user-example-painter :painter_id="{{ $painter->id }}"></user-example-painter>
</div>
@endsection
