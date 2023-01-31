@extends('layouts.app')

@section('logo')
  <img class="logo-icon" src="/image/logo.png">
@endsection

@section('title')
<a class="text-white page-title" href="#">案 件</a>
@endsection


@section('content')
<div class="matter form-container">
    <div class="main">
      <div class="main-city">
        <div class="city-btn">
          <a href="">小林コーポA棟</a>
        </div>
        <div class="city-btn">
          <a href="">小林コーポB棟</a>
        </div>
        <div class="city-btn">
          <a href="">小林コーポC棟</a>
        </div>
        <div class="city-btn">
          <a href="">小林コーポD棟</a>
        </div>
      </div>
      <div class="main-new">
        <div class="new-txt">
          <h2>新規案件を立ち上げる</h2>
        </div>
        <a href="" class="new-btn">塗装工事</a>
        <a href="" class="new-btn">防水工事</a>
        <a href="" class="new-btn">その他工事</a>
      </div>
    </div>
</div>
@endsection
