@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col">
    <div style="background-color:lightgrey;height:25px;text-align:center;vertical-align:middle;">
      <p>パスワード変更フォーム（お客様）</p>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>パスワード（現在）</h4>
    <input v-model="oldpass" placeholder="oldpassword">
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>パスワード（新規）</h4>
    <input v-model="newpass" placeholder="newpassword">
    </div>
  </div>
  <div class="row justify-content-center">
    <p>
    <button class="row blockquote" v-on:click="submit">変更</button>
    </p>
  </div>
</div>


@endsection