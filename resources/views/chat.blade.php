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
            <div class="row bg-topbar">
                <div class="col-6">
                    <div class="text-blue page-title chat-title">塗替え道場</div>
                </div>
                <div class="col-6 status" style="padding-left:0px;text-align:right; align-self:center; padding-right: 2px;">
                    <div class="label">{{ $status }}</div>
                </div>
            </div>
        </header>
            <chat-form user-id="{{ $user_id }}" painter-id="{{ $painter_id }}" request-id="{{ $request_id }}" message-key="{{ $message_key }}" ></chat-form>
            {{-- <div>
                <a href="{{ $url }}">マイページに戻る</a><br />
            </div> --}}
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
