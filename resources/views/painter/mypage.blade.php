@extends('layouts.app')
@section('title','マイページ')
@section('content')

<div class="painter-mypage">
  <div class="form-container section">
    <div class="row">
        <div class="col d-flex justify-content-center">
          <img style="width: auto; max-width: 100%" src="{{ $painter->profile_image }}" />
        </div>
        <div class="col">
          <p class="company-name">{{ $painter->name }}</p>
          <p style="text-align:right; margin:0px"><a href="{{ route('painter.edit') }}" class="btn-profile-edit" role="button" aria-disabled="true">プロフィール編集</a></p>
          <p  class="profile-complate-rate" style="margin:0px">プロフィールの完成度0%</p>
          <painter-profile-progress :percentage="0" class="mx-2 mb-2"/>
        </div>
    </div>
  </div>

  <div class="form-container section">
    <div class="col">
      <div class="count-row">
        <p class="type">お気に入り登録</p>
        <p class="count">0件</p>
      </div>
      <div class="count-row">
        <p class="type">施工事例</p>
        <p class="count">{{ $painter->examples()->count() }}件</p>
      </div>
      <div class="count-row">
        <p class="type">コラム投稿</p>
        <p class="count">{{ $painter->columns()->count() }}件</p>
      </div>
      <div class="count-row">
        <p class="type">クチコミ件数</p>
        <p class="count">0件</p>
      </div>
    </div>
  </div>

  <div class="form-container section">
    <div class="mypage-link-group">
      <a href="{{ route('painter.chat') }}" class="mypage-link">
        <div  class="link-item">
          <div class="item-content">
            <h5 class="card-title">相談・商談</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('coming_soon') }}" class="mypage-link">
        <div  class="link-item">
          <div class="item-content">
            <h5 class="card-title">契約一覧</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('painter.example') }}" class="mypage-link">
        <div  class="link-item">
          <div class="item-content">
            <h5 class="card-title">施工事例</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('coming_soon') }}" class="mypage-link">
        <div  class="link-item">
          <div class="item-content">
            <h5 class="card-title">お知らせ</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('coming_soon') }}" class="mypage-link">
        <div  class="link-item">
          <div class="item-content">
            <h5 class="card-title">足あと</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('painter.setting') }}" class="mypage-link">
        <div  class="link-item">
          <div class="item-content">
            <h5 class="card-title">設定</h5>
          </div>
        </div>
      </a>
      <a href="{{ route('painter.inquiries') }}" class="mypage-link">
        <div  class="link-item">
          <div class="item-content">
            <h5 class="card-title">お問合せ</h5>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>

@endsection