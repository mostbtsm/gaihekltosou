@extends('layouts.app')
@section('content')
@section('title','プロフィール編集')

<div class="container-fluid d-flex justify-content-center mt-5">
  <div class="row form-container">
    <div class="col">
      <painter-profile-form :src="'{{ $painter->profile_image }}'" :exists="@json($painter->profile_image_exists)"></painter-profile-form>
    </div>
  </div>
</div>

<div class="container-fluid d-flex justify-content-center mt-5">
  <div class="row form-container painter-profile-update">
    <div class="col">
      <painter-update-form></painter-update-form>
    </div>
  </div>
</div>

@endsection