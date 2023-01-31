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
                    <div class="col-12">
                        <div class="text-blue page-title" style="text-align:center">coming soon</div>
                    </div>
                </div>
            </header>
            <div class="form-container coming-soon">
                <a class="text-white btn-regester goback-btn" onclick="window.history.back();">戻 る</a>
            </div>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
