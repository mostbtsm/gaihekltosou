@extends('layouts.app')
@section('title','マイページ')
@section('content')

<div class="user-mypage">
  <div class="form-container section">
    <div class="row">
      <div class="col d-flex justify-content-center">
        <img style="width: auto; max-width: 100%" src="{{ $user->profile_image }}" />
      </div>
      <div class="col">
        <p class="company-name">{{ $user->full_name }}</p>
        <p style="text-align:right; margin:0px"><a href="{{ route('user.edit') }}" class="btn-profile-edit" role="button" aria-disabled="true">プロフィール編集</a></p>
        <p class="profile-complate-rate" style="margin:0px">プロフィールの完成度0%</p>
        <painter-profile-progress :percentage="0" class="mx-2 mb-2" />
      </div>
    </div>
  </div>

  <div class="form-container section">
    <div class="mypage-link-group">
      <a href="{{ route('user.chat') }}" class="mypage-link">
        <div class="link-item">
          <div class="item-content">
            <h5 class="card-title">相談・商談</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('user.painter.favorite') }}" class="mypage-link">
        <div class="link-item">
          <div class="item-content">
            <h5 class="card-title">お気入り企業</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('user.example') }}" class="mypage-link">
        <div class="link-item">
          <div class="item-content">
            <h5 class="card-title">施工事例</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('coming_soon') }}" class="mypage-link">
        <div class="link-item">
          <div class="item-content">
            <h5 class="card-title">一括見積</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('coming_soon') }}" class="mypage-link">
        <div class="link-item">
          <div class="item-content">
            <h5 class="card-title">お知らせ</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('user.column') }}" class="mypage-link">
        <div class="link-item">
          <div class="item-content">
            <h5 class="card-title">コラム</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('user.setting') }}" class="mypage-link">
        <div class="link-item">
          <div class="item-content">
            <h5 class="card-title">設定</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('user.inquiries') }}" class="mypage-link">
        <div class="link-item">
          <div class="item-content">
            <h5 class="card-title">お問合せ</h5>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>

@endsection