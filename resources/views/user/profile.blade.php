@extends('layouts.app')
@section('content')
@section('title','プロフィール編集')

<div class="form-container">
  <div class="text-blue sub-header">
    基本プロフィール項目
  </div>
</div>

<div class="container-fluid d-flex justify-content-center mt-5">
  <div class="row form-container">
    <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-body card-caution">
        <h5 class="card-title">※個人情報について</h5>
        <p class="card-text">氏名・住所・電話番号などの個人情報は商談が進むまで非公開になります</p>
      </div>
    </div>
    </div>
  </div>
</div>

<div class="container-fluid d-flex justify-content-center mt-5">
  <div class="row form-container">
    <div class="col">
      <user-profile-form :src="'{{ $user->profile_image }}'" :exists="@json($user->profile_image_exists)"></user-profile-form>
    </div>
  </div>
</div>

<div class="container-fluid d-flex justify-content-center mt-5">
  <div class="row form-container user-profile-update">
    <div class="col">
    <user-update-form></user-update-form>
    </div>
  </div>
</div>

@endsection
