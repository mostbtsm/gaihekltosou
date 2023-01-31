@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col">
    <div style="background-color:lightgrey;height:25px;text-align:center;vertical-align:middle;">
      <p>退会フォーム（お客様）</p>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>パスワード</h4>
    <input v-model="pass" placeholder="password">
    </div>
  </div>
  <div class="row justify-content-center">
    <p>
    <button class="row blockquote" v-on:click="submit">退会</button>
    </p>
  </div>
</div>


@endsection