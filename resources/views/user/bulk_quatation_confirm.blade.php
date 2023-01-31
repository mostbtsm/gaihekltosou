<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="format-detection" content="telephone=no">
        <!-- CSRF Token-->
        <meta name="csrf-token" content="{{ csrf_token() }}">    
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="app">
        <header id="chat-header" class="sticky-top">
            <div class="row bg-topbar pt-2 pb-1" style="box-shadow: 1px 1.5px darkgrey;">        
                    <div class="text-blue page-title" style="margin:auto">一括見積 &nbsp; 内容確認</div>
            </div>
        </header>
        <form action="/api/estimate" method="post">
        <div class="form-container section">
            <div class="col text-blue sub-title">
            施工内容
            </div>
            <div class="col text-gray sub-content">
            {!! nl2br($data['category_text']) !!}
            </div>
        </div>
        <div class="form-container section">
            <div class="text-blue sub-title">
            工事に求めるもの
            </div>
            <div class="text-gray sub-content">
            {!! nl2br($data['priority_text']) !!}
            </div>
        </div>
        <div class="form-container section">
            <div class="text-blue sub-title">
            工期予定
            </div>
            <div class="text-gray sub-content">
            {{ $data['period_text'] }}
            </div>
        </div>
        <div class="form-container section">
            <div class="text-blue sub-title">
            建物について
            </div>
            <div class="text-gray sub-content">
            {{ $data['property'] }}
            </div>
            <div class="text-gray sub-content">
            {{ $data['floors_text'] }}
            </div>
            <div class="text-gray sub-content">
            {{ $data['age_text'] }}
            </div>
            <div class="text-gray sub-content">
            {{ $data['area_text'] }}
            </div>
            <div class="text-gray sub-content">
            {{ $data['area_b_text'] }}
            </div>
            <div class="text-gray sub-content">
            {{ $data['type_roof_text'] }}
            </div>
            <div class="text-gray sub-content">
            {{ $data['type_wall_text'] }}
            </div>
            <div class="text-gray sub-content">
            {{ $data['budget_text'] }}
            </div>
            <div class="text-gray sub-content">
            工事内容に関して<br />{!! nl2br(e($data['memo'])) !!}
            </div>
            <div class="text-gray sub-content">
            送信先業者<br />{!! nl2br($data['painters']) !!}
            </div>
            <div class="col-12" style="margin-top:20px; text-align: center;">
                <a class="btn btn-confirm" role="button" href="javascript:void(0)" onclick="document.forms[0].submit();">申込む</a>
            </div>
            <div class="col-12" style="margin-bottom:90px; margin-top:20px; text-align: center;">
                <a class="btn btn-confirm" role="button" href="javascript:void(0)" onclick="history.back();">修正する</a>
            </div>
            <input type="hidden" name="property_id" value="{{ $data['property_id'] }}" />
            <input type="hidden" name="category" value="{{ $data['category'] }}" />
            <input type="hidden" name="category_text" value="{{ $data['category_text'] }}" />
            <input type="hidden" name="priority" value="{{ $data['priority'] }}" />
            <input type="hidden" name="priority_text" value="{{ $data['priority_text'] }}" />
            <input type="hidden" name="period" value="{{ $data['period'] }}" />
            <input type="hidden" name="period_text" value="{{ $data['period_text'] }}" />
            <input type="hidden" name="type" value="{{ $data['type'] }}" />
            <input type="hidden" name="num" value="{{ $data['num'] }}" />
            <input type="hidden" name="property" value="{{ $data['property'] }}" />
            <input type="hidden" name="floors" value="{{ $data['floors'] }}" />
            <input type="hidden" name="floors_text" value="{{ $data['floors_text'] }}" />
            <input type="hidden" name="age" value="{{ $data['age'] }}" />
            <input type="hidden" name="age_text" value="{{ $data['age_text'] }}" />
            <input type="hidden" name="area" value="{{ $data['area'] }}" />
            <input type="hidden" name="area_text" value="{{ $data['area_text'] }}" />
            <input type="hidden" name="area_b" value="{{ $data['area_b'] }}" />
            <input type="hidden" name="area_b_text" value="{{ $data['area_b_text'] }}" />
            <input type="hidden" name="type_roof" value="{{ $data['type_roof'] }}" />
            <input type="hidden" name="type_roof_text" value="{{ $data['type_roof_text'] }}" />
            <input type="hidden" name="type_wall" value="{{ $data['type_wall'] }}" />
            <input type="hidden" name="type_wall_text" value="{{ $data['type_wall_text'] }}" />
            <input type="hidden" name="budget" value="{{ $data['budget'] }}" />
            <input type="hidden" name="budget_text" value="{{ $data['budget_text'] }}" />
            <input type="hidden" name="memo" value="{{ $data['memo'] }}" />
            @for ($i = 0; $i < count($data['painter_id']); $i++)
            <input type="hidden" name="painter_id[]" value="{{ $data['painter_id'][$i] }}" />
            @endfor
        </div>
        </form>
       
        @include('layouts.footers.user')
    </body>
</html>
