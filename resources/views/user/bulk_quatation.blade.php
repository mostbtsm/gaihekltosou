@extends('layouts.app')


@section('title')
<span class="text-white page-title" >一括見積</span>
@endsection

@section('content')
<div class="form-container quote-top-section">
    <img src="/image/logo.png" />
    <div>無料で簡単申込!</div>
    <div>希望に沿った業者を集められる!</div>
    <div>一度に試算結果が分かる!</div>
</div>
<div class="form-container quote-description">
  <div>
    複数の業者からサイトを通してメッセージが届きます。十分に相談した後に商談に移ってください。個人情報については非公開で進みます。相談から商談に移る際は2〜3社と商談することをお勧めします。
  </div>
</div>

<form action="/api/estimate" method="post">
@method('put')
<bulk-quatation user-id="{{ $user_id }}"></bulk-quatation>
</form>
@endsection