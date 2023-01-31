@extends('layouts.admin')

@section('content')
<adminsidebar :kind="3"></adminsidebar>
<div class="admin-container">
  <div class="card" style="padding:20px 10px;">
     <div class="page-title" style="padding:20px">コラム一覧管理</div>
     <columnlist></columnlist>
  </div>
</div>
@endsection
