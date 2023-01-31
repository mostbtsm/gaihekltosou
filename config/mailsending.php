<?php

return [
    // 会員登録メール
    'entry' => [
        // 送信元
        'send_from' => env('MAIL_FROM_ADDRESS', 'sample@example.com'),
        // 送信者名
        'sender' => env('MAIL_FROM_NAME', '日本塗装職人の集まる会'),
        // 管理者送信先
        'send_to_admin' => env('MAIL_FROM_ADDRESS', 'sample@example.com'),
    ],

    // 会員承認メール
    'approve' => [
        // 送信元
        'send_from' => env('MAIL_FROM_ADDRESS', 'sample@example.com'),
        // 送信者名
        'sender' => env('MAIL_FROM_NAME', '日本塗装職人の集まる会'),
        // 件名
        'subject' => 'アカウントの承認が完了しました',
    ],

    // お問い合わせメール
    'contact' => [
        // 送信元
        'send_from' => env('MAIL_FROM_ADDRESS', 'sample@example.com'),
        // 送信者名
        'sender' => env('MAIL_FROM_NAME', '日本塗装職人の集まる会'),
        // 管理者送信先
        'send_to_admin' => env('MAIL_FROM_ADDRESS', 'sample@example.com'),
    ],

    // 見積もりメール
    'estimate' => [
        // 送信元
        'send_from' => env('MAIL_FROM_ADDRESS', 'sample@example.com'),
        // 送信者名
        'sender' => env('MAIL_FROM_NAME', '日本塗装職人の集まる会'),
    ],

    // パスワードリセット通知
    'password' => [
        // パスワードリセット通知の送信元
        'send_from' => env('MAIL_FROM_ADDRESS', 'sample@example.com'),
        // パスワードリセット通知の送信者名
        'sender' => env('MAIL_FROM_NAME', '日本塗装職人の集まる会'),
        // 件名
        'subject' => 'パスワード初期化についてのお知らせ',
    ],

    // 管理者からのお知らせ
    'notice' => [
        // 管理者からのお知らせの送信元
        'send_from' => env('MAIL_FROM_ADDRESS', 'sample@example.com'),
        // 管理者からのお知らせの送信者名
        'sender' => env('MAIL_FROM_NAME', '日本塗装職人の集まる会'),
    ],
];
