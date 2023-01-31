@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col d-flex justify-content-center">
    <h2>お客様プロフィール</h2>
  </div>
</div>

<div class="container-fluid d-flex justify-content-center">
  <div class="row form-container">
    <div class="d-flex justify-content-center">
      <div class="detail-profile-image" style="background-image: url({{ $user->profile_image }})" />
    </div>
    <div class="d-flex align-items-center">
      <h4>{{ $user->nickname }}</h4>
    </div>
  </div>

  <div class="row form-container">
    
  </div>
</div>

@endsection