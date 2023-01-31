@extends('layouts.app')
@section('title', '絞込み検索')
@section('body_class', 'bg-lightgray')
@section('content')

<div class="form-container painter-search">
  <form id="form" method="post" action="{{ route('user.painter') }}">
    @csrf

    <div class="form-div">
      <label for="prefecture">施工地域</label>
      <select id="prefecture" name="prefecture" class="form-control">
        <option value=''>都道府県</option>
        @foreach (config('const.select.prefecture') as $index => $name)
        <option value='{{ $index }}' {{ (string)$index === request('prefecture') ? 'selected' : '' }} >{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-div">
      <label for="city"></label>
      <input type="input" id="city" name="city" placeholder="市区町村" class="form-control" value="{{ request('city') }}">
    </div>

    <div class="btn-area">
      <button type="submit" class="btn-confirm">検索</button>
    </div>
  </form>
</div>
@endsection
