@extends('layouts.top')
@section('content')
<div class="top-page">
  <section class="top" style="text-align:center">
    <div class="form-container" style="padding:0">
      <div class="top-header">
        YouTubeでお馴染みの塗替え道場がお手伝い!
      </div>
      <div class="top-image">
        <img class="top-title" src="/image/top-title.png" alt="top-title" />
        <img class="main-image" src="/image/top.png" alt="a" />
      </div>
    </div>
  </section>

  <section class="companys">
    <div class="form-container">
      <img src="/image/500.png" alt="a" />

      <div class="button-group">
        <div class="button-card">
          <div class="content">
            全国から集まった業者の中から、あなたの条件にあった塗装会社を見つけられます。気に入った業者とはこのサイト内でやり取りできるので便利!まずはここから集者を見てみてください。
            <!--<a class="btn-quotation" href="{{ route('user.entry') }}">業者を見てみる</a>-->
          </div>
        </div>
        <div class="button-card">
          <div class="content">
            多大なデータベースから、あなたの依頼内容にあった 施工会社に一括見積依頼が出来ます!<br>
            業者が依頼内容とマッチング成立すると業者側からコンタクトを開始してくれます
            <!--<a class="btn-quotation" href="{{ route('user.entry') }}">一括見積依頼をする</a>-->
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="lowest-price">
    <div class="form-container">
      <div class="image-container">
        <img src="/image/lowest-price.png" alt="a" />
      </div>
    </div>
  </section>

  <section class="best-craftsmen">
    <div class="form-container">
      <img src="/image/best-craftsmen.jpg" alt="a" />
    </div>
  </section>

  <section class="intro">
    <div class="form-container">
      <div class="card">
        <img src="/image/registration-trader.jpg" alt="" class="src">
        <div class="method">
          <div class="title">
            直接依頼
          </div>
          <div class="content text-white">
            一般的なマッチングサイトのように塗装業者を公開せずにお客様を紹介することで多額の手数料を取るマッチングサイトがほとんどの業界ですが、私たちのサイ卜では塗装業者様をサイト上で公開することで、お客様から直接見積もり依頼、相談ができるようにしています。
          </div>
        </div>
        <div class="method">
          <div class="title">
            一括見積依頼
          </div>
          <div class="content text-white">
            お客様の希望で公募見積もり依頼することで自分たちに合ったお客様と商談をすることができます。3〜5社ほどの塗装業社から依頼をすることで適正価格を知りつつ外壁塗装の知識が高まり成約意欲が高まります。
          </div>
        </div>
        <a class="btn-quotation" href="{{ route('painter.entry') }}">業者登録する</a>
      </div>
    </div>
  </section>

  <section class="inquiry">
    <div class="form-container">
      <div class="description">
        登録したのにメールでの返信が来ない。 または「ログイン」出来ない場合はこちらよりお問合せください。
      </div>
      <a class="btn-gray btn-inquiry" href="{{ route('inquiries') }}">お問合せ</a>
    </div>
  </section>
</div>
@endsection