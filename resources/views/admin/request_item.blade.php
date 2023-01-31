@extends('layouts.admin')

@section('content')
<div class="admin-container">
    <div class="card">
       <div class="page-title" style="padding:20px">依頼案件一覧 管理</div>
       <form id="searchForm" class="search-form" onSubmit="">
           <div class='search'>
               <div class='search_box'>
                   <img src="/image/search.svg" alt="" class="searchImage" />
                   <input id="search_input" value="" class="search_text" name="search_keyword" />
               </div>
               <button class="search-btn">検索</button>
           </div>
       </form>
       <table class="trader-table">
           <tr>
               <th>案件ID</th>
               <th>依頼案件名</th>
               <th>依頼者</th>            
               <th>業者</th>
               <th></th>
           </tr>
           <tr>
               <td>
                   <p>1</p>
               </td>
               <td><p>塗装お願い</p></td>
               <td><p>塗装太郎</p></td>
               <td><p>塗装株式会社</p></td>
               <td>
                   <button class="btn-detail">詳細</button>
                   <button class="btn-danger">削除</button>
               </td>
           </tr>      
       </table>
        <adminpagination></adminpagination>
    </div>
</div>
@endsection

