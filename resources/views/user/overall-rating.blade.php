@extends('layouts.app')


@section('title')
<a class="text-white page-title" href="#">評 価</a>
@endsection


@section('content')
<div class="form-container">
<div class="bor_bottom bg_yellow">
        <h3 class="text-blue text-center">株式会社七色</h3>
    </div>
    <div class="bor_bottom">
        <h3 class="text-blue text-center">総合評価</h3>
        <div class="star">
            <overall-rating :rating="4.5"></overall-rating>
        </div>
    </div>
    <div class="bor_bottom">
        <h3 class="text-blue text-center">採点分布</h3>
        <div class="star_bar"><starrating :rating="5"></starrating><div style="width: 30%;"><div class="bar" style="width:100%;"></div></div><div style="width:40px">33件</div></div>
        <div class="star_bar"><starrating :rating="4"></starrating><div style="width: 30%;"><div class="bar" style="width:10%;"></div></div><div style="width:40px">3件</div></div>
        <div class="star_bar"><starrating :rating="3"></starrating><div style="width: 30%;"><div class="bar" style="width:3%;"></div></div><div style="width:40px">1件</div></div>
        <div class="star_bar"><starrating :rating="2"></starrating><div style="width: 30%;"><div class="bar" style="width:0%;"></div></div><div style="width:40px">0件</div></div>
        <div class="star_bar"><starrating :rating="1"></starrating><div style="width: 30%;"><div class="bar" style="width:0%;"></div></div><div style="width:40px">0件</div></div>

    </div>
    <div class="evaluation_content">
        <div class="part">
            <div class="part_title">
                <h5>愛知県Yさん</h5>
                <starrating :rating="5"></starrating>
            </div>
            <div class="part_text">
                5社の見積もりの中から塗替え逍場さんを選ばせていただきまし た。<br>
                決め手はスタッフさんの人柄と提案内容でした。<br>
                他社は『ウチは安いですよJという売り方だったのに対して、 塗替え道場さんはTこの家には油性塗料での外壁塗装がいいで す」という風に、価格ではなく家の今後を見て捉案してくれま した。<br>
                施工も無事に完了し、これからは長いお付き合いになります が、スタッフさんの人柄も良いので心配していません。<br>
                良い業者さんに出会えてラッキーだったと思っています。
            </div>
        </div>
        <div class="part">
            <div class="part_title">
                <h5>愛知県Yさん</h5>
                <starrating :rating="5"></starrating>
            </div>
            <div class="part_text">
                5社の見積もりの中から塗替え逍場さんを選ばせていただきまし た。<br>
                決め手はスタッフさんの人柄と提案内容でした。<br>
                他社は『ウチは安いですよJという売り方だったのに対して、 塗替え道場さんはTこの家には油性塗料での外壁塗装がいいで す」という風に、価格ではなく家の今後を見て捉案してくれま した。<br>
                施工も無事に完了し、これからは長いお付き合いになります が、スタッフさんの人柄も良いので心配していません。<br>
                良い業者さんに出会えてラッキーだったと思っています。
            </div>
        </div>
        <div class="part">
            <div class="part_title">
                <h5>愛知県Yさん</h5>
                <starrating :rating="5"></starrating>
            </div>
            <div class="part_text">
                5社の見積もりの中から塗替え逍場さんを選ばせていただきまし た。<br>
                決め手はスタッフさんの人柄と提案内容でした。<br>
                他社は『ウチは安いですよJという売り方だったのに対して、 塗替え道場さんはTこの家には油性塗料での外壁塗装がいいで す」という風に、価格ではなく家の今後を見て捉案してくれま した。<br>
                施工も無事に完了し、これからは長いお付き合いになります が、スタッフさんの人柄も良いので心配していません。<br>
                良い業者さんに出会えてラッキーだったと思っています。
            </div>
        </div>
    </div>
</div>
@endsection