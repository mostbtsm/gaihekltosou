<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            @if ($errors->any())
            <div>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif
            <h1>管理者登録</h1>
            <form action="/admin" method="post">
                @csrf
                <div>
                    <label for="username">ユーザ名</label>
                    <input type="text" name="username" value="">
                </div>
                <div>
                    <label for="password">パスワード</label>
                    <input type="password" name="password" value="">
                </div>
                <div>
                    <label for="password_confirmation">パスワード（再入力）</label>
                    <input type="password" name="password_confirmation" value="">
                </div>
                <button type="submit">登録</button>
            </form>
        </div>
    </body>
</html>
