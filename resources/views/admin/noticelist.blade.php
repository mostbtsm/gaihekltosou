@extends('layouts.admin')

@section('content')
<adminsidebar :kind="6"></adminsidebar>
<div class="admin-container">
  <div class="card" style="padding:20px 10px;">
     <div class="page-title" style="padding:20px">お知らせ管理</div>
     <div>
        <button class="btn-detail" style="width:120px;" onclick="location.href='/notice/create'">お知らせ追加</button>
     </div>
     <noticelist></noticelist>
  </div>
</div>
@endsection
