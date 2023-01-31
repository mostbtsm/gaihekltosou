@extends('layouts.app')
@section('title', $painter->name . '　コラム')
@section('content')
<div class="content-container">
  <user-column-painter :painter_id="{{ $painter->id }}"></user-column-painter>
</div>
@endsection
