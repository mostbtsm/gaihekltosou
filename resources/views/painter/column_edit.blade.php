@extends('layouts.app')
@section('title', 'コラム編集')
@section('content')
<div class="form-container column-edit-form mt-5">
  <painter-column-form :column_id="{{ $column->id }}"></painter-column-form>
</div>
@endsection