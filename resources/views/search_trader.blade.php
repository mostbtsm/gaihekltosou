@extends('layouts.app')
@section('content')

<div class="container-fluid">
  <div class="row justify-content-center">
    <p>
    <button class="row blockquote" v-on:click="search">検索条件変更</button>
    </p>
  <div class="row">
    <div class="col">
      <exsamples-slider>
    <p>
    検索条件をスライド
    </p>
      </exsamples-slider>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <p>
    全〇件
    </p>
    <select v-model="selected">
      <option disabled value=""></option>
      <option>気になる多い順</option>
      <option>事例順</option>
      <option>実績（評価数）順</option>
      <option>近い順</option>
    </select>
    </div>
  </div>


  <div class="row justify-content-center">
    <div id="app">
    <table>
<?php
 /*
      <template v-for="(info, index) in traders" :key="index">
      表示確認用
 */
?>
      <tr>
        <td>
          <p>ここに写真{{ info.icon }}</p>
        </td>
        <td>
	      <div class="col" style="text-align:right;">
          <p>会社名{{ info.name }}</p>
          <p>プロフィール{{ info.profile }}</p>
          <p>会社情報{{ info.info }}</p>
          <p>口コミ・評価{{ info.rating }}</p>
          <p>ランク（バッジ）{{ info.rank }}</p>
          <p>気になる{{ info.count }}</p>
	      </div>
        </td>
      </tr>
      <tr>
        <td>
          <button class="row blockquote" v-on:click="submit">相談する</button>
        </td>
        <td>
          <button class="row blockquote" v-on:click="bookmark">お気に入り登録</button>
        </td>
      </tr>
<?php
 /*
      </template>
      表示確認用
 */
?>
    </table>
    </div>
  </div>

</div>




@endsection