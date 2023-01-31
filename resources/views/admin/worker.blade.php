@extends('layouts.admin')

@section('content')
<adminsidebar :kind="1"></adminsidebar>
<div class="admin-container">
  <div class="card" style="padding:20px 10px;">
     <div class="page-title" style="padding:20px">業者一覧管理</div>
     <workerlist></workerlist>
  </div>
</div>
@endsection
