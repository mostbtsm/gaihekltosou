@extends('layouts.app')
@section('title','コラム')
@section('content')
<div class="content-container">
  <user-column-detail :column_id="{{ $column->id }}" :painter_name="'{{ $column->painter->name }}'" :profile_image="'{{ $column->painter->profile_image }}'"></user-column-detail>
</div>
@endsection
