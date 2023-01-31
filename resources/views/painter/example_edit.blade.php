@extends('layouts.app')
@section('title','施工事例編集')
@section('content')

<div class="container-fluid d-flex justify-content-center example-form">
  <div class="form-container">
    <painter-example-form :example_id="{{ $example->id }}"></painter-example-form>
  </div>
</div>

@endsection