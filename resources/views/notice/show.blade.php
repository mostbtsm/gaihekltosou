@extends('layouts.admin')

@section('content')
<adminsidebar :kind="6"></adminsidebar>
<div class="admin-container">
  <div class="card" style="padding:20px 10px;">
    <div class="page-title" style="padding:20px">お知らせ確認</div>
    <notice-show :notice="{{ $notice }}"></notice-show>
  </div>
</div>
@endsection
