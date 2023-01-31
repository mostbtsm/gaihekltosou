@extends('layouts.chat')
@section('title', $painter->name)

@section('header_left')
<button class="navbar-toggler" type="button" onclick="history.back()">
  <i class="fa fa-angle-left"></i>
</button>
@endsection

@section('content')
<div class="chat-container">
  <div class="chat-body">
    <div class="chat-row my-message">
      <div class="message my-message">
        <div class="message-body">
          <div class="message-text">{{ $painter->name }}宛てにメッセージを送ることができます
            画面下部のテキストボックスにメッセージを入力してください
          </div>
        </div>
      </div>
    </div>
  </div>

  <chat-create-footer :painter_id="{{ $painter->id }}"></chat-create-footer>
</div>
@endsection