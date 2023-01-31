@extends('layouts.app')
@section('content')


<div class="container-fluid">
  <div class="row justify-content-center">
    <table>
      <tr>
        <td>
          <p>ここに写真</p>
        </td>
        <td>
	      <div class="col" style="text-align:left;">
	        <div class="row justify-content-center"><a href="#">>プロフィール変更</a></div>
	        <div class="row justify-content-center"><span>プロフィール完成度 {{ persent }}</span></div>
	        <div class="row justify-content-center">
	          <h4>ログイン者名称</h4>
	        </div>
	      </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="row justify-content-space-between">
    <a href="#">>お気に入り企業</a>
    <a href="#">>商談一覧</a>
  </div>

  <div class="row justify-content-space-between">
    <a href="#">>施工事例一覧</a>
    <a href="#">>コラム一覧</a>
  </div>

  <div class="row justify-content-space-between">
    <a href="#">>お知らせ</a>
    <a href="#">>設定</a>
  </div>


  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>コラム</h4>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>施工事例</h4>
    </div>
  </div>

</div>


@endsection