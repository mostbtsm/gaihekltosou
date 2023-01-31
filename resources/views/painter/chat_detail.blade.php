@extends('layouts.chat')
@section('title', $user->name)

@section('header_left')
<a class="navbar-toggler" href="{{ route('painter.chat') }}">
  <i class="fa fa-angle-left"></i>
</a>
@endsection

@section('header_right')
<button class="btn btn-consul-status" type="button">相談中</button>
@endsection

@section('content')
<div class="chat-container">
  <chat-body :thread_id="{{ $thread->id }}" :thread_hash="'{{ md5($thread->id) }}'"></chat-body>
</div>

<chat-footer :thread_id="{{ $thread->id }}" :painter_id="{{ $painter->id }}"></chat-footer>
@endsection