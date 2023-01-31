@extends('layouts.app')
@section('content')

<div class="row">
  <div class="col">
    <div style="background-color:lightgrey;height:25px;text-align:center;vertical-align:middle;">
      <p>会社名</p>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
      <exsamples-slider>
        <p>
        プロフィール写真をスライド
        </p>
      </exsamples-slider>
    </div>
  </div>

  <div class="row justify-content-space-between">
      <p>
      ランク（バッジ）　見習い（ロゴバッジ）
      </p>
    <div class="col" style="text-align:left;">
      <p>
      気になる　〇件
      </p>
      <p>
      <a href="#">施工事例一覧　〇件</a>
      </p>
      <p>
      <a href="#">コラム一覧　〇件</a>
      </p>
      <p>
      <a href="#">口コミ・評価　〇件　☆★★★★　</a>
      </p>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col" style="text-align:center;">
      <h4>プロフィール</h4>
      <p>
      プロフィール内容
      </p>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col" style="text-align:center;">
      <h4>会社情報</h4>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col" style="text-align:center;">
      <h4>施工事例、コラム、口コミ・評価</h4>
      <exsamples-slider>
        <p>
        それぞれスライド
        </p>
      </exsamples-slider>
    </div>
  </div>

  <div class="row justify-content-space-between">
     <button class="row blockquote" v-on:click="submitall">相談する</button>
     <button class="row blockquote" v-on:click="releaseall">お気に入り登録</button>
  </div>

</div>




@endsection