@extends('layouts.admin')

@section('content')
<adminsidebar :kind="2"></adminsidebar>
<div class="admin-container">
  <div class="card" style="padding:20px 10px;">
     <div class="page-title" style="padding:20px">お客様一覧管理</div>
     <clientlist></clientlist>
  </div>
</div>
@endsection
