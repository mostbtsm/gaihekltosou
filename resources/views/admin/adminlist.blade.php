@extends('layouts.admin')

@section('content')
<adminsidebar :kind="0"></adminsidebar>
<div class="admin-container">
  <div class="card" style="padding:20px 10px;">
     <div class="page-title" style="padding:20px">管理者一覧管理</div>
     <div>
        <button class="btn-detail" style="width:100px;" onclick="location.href='/admin/create'">管理者追加</button>
     </div>
     <adminlist></adminlist>
  </div>
</div>
@endsection
