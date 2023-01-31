@extends('layouts.admin')

@section('content')
<adminsidebar :kind="5"></adminsidebar>
<div class="admin-container">
  <div class="card" style="padding:20px 10px;">
     <div class="page-title" style="padding:20px">口コミ・評価一覧管理</div>
     <evaluationlist></evaluationlist>
  </div>
</div>
@endsection
