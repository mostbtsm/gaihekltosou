@extends('layouts.admin')

@section('content')
<adminsidebar :kind="4"></adminsidebar>
<div class="admin-container">
  <div class="card" style="padding:20px 10px;">
     <div class="page-title" style="padding:20px">施工事例一覧管理</div>
     <examplelist></examplelist>
  </div>
</div>
@endsection
