@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col">
    <div style="background-color:lightgrey;height:25px;text-align:center;vertical-align:middle;">
      <p>お客様情報</p>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>氏名</h4>
    <input v-model="name" placeholder="DBから">
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>フリガナ</h4>
    <input v-model="kana" placeholder="DB or blank">
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>郵便番号</h4>
    <input v-model="post" placeholder="DB or blank">
    </div>
  </div>
  <div class="row justify-content-center">
    <p>
    <button class="row blockquote" v-on:click="search">郵便番号から住所検索</button>
    </p>
  </div>

  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>住所</h4>
    <input v-model="address" placeholder="DB or blank">
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>連絡可能な電話番号</h4>
    <input v-model="tel" placeholder="DB or blank">
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>メールアドレス</h4>
    <input v-model="mail" placeholder="DBから">
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>生年月日</h4>
    <input v-model="kana" placeholder="DB or blank">
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col" style="text-align:left;">
    <h4>性別</h4>
    <input v-model="post" placeholder="DB or blank">
    </div>
  </div>


  <div class="row justify-content-center">
  <div id="app">
    <table>
<?php
 /*
      <template v-for="(info, index) in buildings" :key="index">
      表示確認用
 */
?>
      <tr>
        <td>
          <div class="col" style="text-align:center;"><h4>物件情報{{ index + 1 }} </h4></div>
        </td>
      </tr>
      <tr>
        <td>
          <h4>住所</h4>
          <input v-model="address_inf" placeholder="{{ info.address }}">
        </td>
      </tr>
      <tr>
        <td>
          <h4>延床面積（居住面積）</h4>
          <input v-model="floorspace" placeholder="{{ info.floorspace }}">
        </td>
      </tr>
      <tr>
        <td>
          <h4>階数</h4>
          <input v-model="floors" placeholder="{{ info.floors }}">
        </td>
      </tr>
      <tr>
        <td>
          <h4>築年数</h4>
          <input v-model="age" placeholder="{{ info.age }}">
        </td>
      </tr>
      <tr>
        <td>
          <h4>家のタイプ</h4>
          <select v-model="selected">
            <option disabled value=""></option>
            <option>洋風</option>
            <option>和モダン</option>
            <option>和風</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>
          <h4>前の塗り替え（外壁）</h4>
          <input v-model="wall_repaint" placeholder="{{ info.wall }}">
        </td>
      </tr>
      <tr>
        <td>
          <h4>前の塗り替え（屋根）</h4>
          <input v-model="roof_repaint" placeholder="{{ info.roof }}">
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


  <div class="row justify-content-center">
    <p>
    <button class="row blockquote" v-on:click="submit">更新</button>
    </p>
  </div>
</div>




@endsection