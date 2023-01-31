@extends('layouts.app')
@section('content')

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col" style="text-align:center;">
      <a href="#">>見積もり依頼作成</a>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col" style="text-align:center;"><h4>業者検索</h4></div>
  </div>
  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>エリア検索</h4>
    <select v-model="selected">
      <option v-for="area in areas" v-bind:value="area.value">
        {{ area.text }}
      </option>
    </select>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>業種検索</h4>
    <select v-model="selected">
      <option v-for="industry in industrys" v-bind:value="industry.value">
        {{ industry.text }}
      </option>
    </select>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>キーワード検索</h4>
    <input v-model="keyword" placeholder="">
    </div>
  </div>
  <div class="row justify-content-center">
    <p>
    <button class="row blockquote" v-on:click="submit">検索</button>
    </p>
  </div>
</div>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col" style="text-align:center;">
      <a href="#">>コラム一覧を見る</a>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col" style="text-align:center;">
      <a href="#">>施工事例一覧を見る</a>
    </div>
  </div>
</div>

    
@endsection