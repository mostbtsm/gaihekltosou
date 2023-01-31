<?php

return [
    'app_name' => env('APP_NAME', '日本塗装職人の集まる会'),

    // 画像サイズ、ファイルサイズ上限定義
    'image' => [
        'max_width' => 320,   // 幅320px
        'max_height' => 240,  // 高さ240px
        'max_size' => 10240,  // ファイルサイズは10240KB(10MB)まで
    ],

    // 画像、添付ファイル保存場所定義
    'directory' => [
        'profile_p' => 'painter/profile/',    // 業者プロフィール画像保存場所
        'image_p' => 'painter/image/',        // 業者登録画像保存場所
        'profile_u' => 'user/profile/',       // 個人プロフィール画像保存場所
        'property' => 'user/property/',       // 物件添付画像保存場所
        'request' => 'user/request/',         // 依頼添付画像保存場所
        'column' => 'painter/column/',        // コラム画像保存場所
        'example' => 'painter/example/',      // 施工事例画像保存場所
        'quotation' => 'painter/quotation/',  // 見積書保存場所
        'attach' => 'painter/attach/',        // 提案添付書類保存場所
        'contract' => 'painter/contract/',    // 契約書保存場所
    ],

    // 画像ファイルが存在しない場合のURL
    'no_image' => env('APP_URL').'/image/no_image.jpg',

    // ユーザプロフィール初期画像
    'user_default_image' => env('APP_URL').'/image/user_default_image.jpg',

    // ホーム画面のURL
    'home' => '/',

    // 画面URLプレフィックス定義
    'prefix' => [
        'admin' => '/admin',
        'painter' => '/painter',
        'user' => '/user',
    ],

    // テンプレートファイル名定義
    'template' => [
        'admin' => [
            // 管理者登録画面
            'entry' => 'admin.entry',
            // 管理者ログイン画面
            'login' => 'admin.login',
            // 管理者一覧画面
            'admin_list' => 'admin.adminlist',
            // 管理者用個人会員一覧画面
            'user_list' => 'admin.client',
            // 管理者用業者会員一覧画面
            'painter_list' => 'admin.worker',
            // 管理者用コラム一覧画面
            'column_list' => 'admin.column',
            // 管理者用施工事例一覧画面
            'example_list' => 'admin.construction_case',
            // 管理者用口コミ・評価一覧画面
            'evaluation_list' => 'admin.evaluationlist',
            // 管理者用お知らせ一覧画面
            'notice_list' => 'admin.noticelist',
        ],

        'painter' => [
            // 業者会員登録画面
            'entry' => 'painter.entry',
            // 業者会員登録完了画面
            'complete' => 'painter.entry_complete',
            // 業者会員ログイン画面
            'login' => 'painter.login',
            // 業者会員トップページ
            'top' => 'painter.top',
            // 業者会員マイページ
            'mypage' => 'painter.mypage',
            // 業者会員プロフィール編集画面
            'edit' => 'painter.profile',
            // 業者会員プロフィールプレビュー画面
            'preview' => 'painter.preview',
            // 業者会員退会画面
            'withdraw' => 'painter.withdraw',
            // 一般向け業者会員検索結果ページ
            'list' => '',
            // 一般向け業者会員詳細ページ
            'detail' => '',
            // 相談・商談一覧画面
            'workflow' => 'business_discussion',

            // 施工事例一覧ページ
            'example' => 'painter.example',
            // 施工事例追加画面
            'example_create' => 'painter.example_create',
            // 施工事例編集画面
            'example_edit' => 'painter.example_edit',

            // コラム一覧ページ
            'column' => 'painter.column',
            // コラム追加画面
            'column_create' => 'painter.column_create',
            // コラム編集画面
            'column_edit' => 'painter.column_edit',

            'chat' => 'painter.chat',

            'chat_detail' => 'painter.chat_detail',
        ],

        'user' => [
            // 個人会員登録画面
            'entry' => 'user.entry',
            // 個人会員登録完了画面
            'complete' => 'user.entry_complete',
            // 個人会員ログイン画面
            'login' => 'user.login',
            // 個人会員トップページ
            'top' => 'user.top',
            // 個人会員マイページ
            'mypage' => 'user.mypage',
            // 個人会員プロフィール編集画面
            'edit' => 'user.profile',
            // 個人会員退会画面
            'withdraw' => 'user.withdraw',
            // 業者向け個人会員詳細ページ
            'detail' => '',
            // 相談・商談一覧画面
            'workflow' => 'business_discussion',

            // 業者検索結果ページ
            'painter' => 'user.painter',
            // 業者検索ページ
            'painter_search' => 'user.painter_search',
            // 業者詳細ページ
            'painter_detail' => 'user.painter_detail',
            // お気に入り業者一覧
            'painter_favorite' => 'user.painter_favorite',

            // 施工事例一覧ページ
            'example' => 'user.example',
            // 業者施工事例一覧ページ
            'example_painter' => 'user.example_painter',
            // 施工事例詳細画面
            'example_detail' => 'user.example_detail',

            // コラム一覧ページ
            'column' => 'user.column',
            // 業者コラム一覧ページ
            'column_painter' => 'user.column_painter',
            // コラム詳細画面
            'column_detail' => 'user.column_detail',


            'chat' => 'user.chat',

            'chat_create' => 'user.chat_create',

            'chat_detail' => 'user.chat_detail',


            // 評価登録画面
            'evaluation' => 'user.evalution',

        ],

        'property' => [
            // 物件追加画面
            'create' => '',
            // 物件編集画面
            'edit' => '',
        ],

        // 依頼編集画面
        'request' => '',

        // 見積依頼入力画面
        'estimate' => 'user.bulk_quatation',

        // 見積依頼確認画面
        'estimate_conf' => 'user.bulk_quatation_confirm',

        // 見積応答入力画面
        'proposal' => 'workflow.proposal',

        // 契約編集画面
        'contract' => '',

        // 口コミ・評価登録画面
        'evaluation' => '',

        // お問い合わせ画面
        'contact' => '',

        // チャット画面
        'chat' => 'chat',

        'password' => [
            // パスワードリセット画面
            'request' => 'password.request',
            // パスワード変更画面
            'reset' => 'password.reset',
        ],

        'notice' => [
            // お知らせ追加画面
            'create' => 'notice.create',
            // お知らせ表示画面
            'show' => 'notice.show',
            // お知らせ編集画面
            'edit' => 'notice.edit',
        ],
    ],

    'select' => [
        // 都道府県
        'prefecture' => [
            '北海道',
            '青森県',
            '岩手県',
            '宮城県',
            '秋田県',
            '山形県',
            '福島県',
            '茨城県',
            '栃木県',
            '群馬県',
            '埼玉県',
            '千葉県',
            '東京都',
            '神奈川県',
            '新潟県',
            '富山県',
            '石川県',
            '福井県',
            '山梨県',
            '長野県',
            '岐阜県',
            '静岡県',
            '愛知県',
            '三重県',
            '滋賀県',
            '京都府',
            '大阪府',
            '兵庫県',
            '奈良県',
            '和歌山県',
            '鳥取県',
            '島根県',
            '岡山県',
            '広島県',
            '山口県',
            '徳島県',
            '香川県',
            '愛媛県',
            '高知県',
            '福岡県',
            '佐賀県',
            '長崎県',
            '熊本県',
            '大分県',
            '宮崎県',
            '鹿児島県',
            '沖縄県',
        ],

        // 年間売上
        'sales' => [
            0 => '１０００万円未満',
            1 => '１０００万円～３０００万円未満',
            2 => '３０００万円～５０００万円未満',
            3 => '５０００万円～１億円未満',
            4 => '１億円～３億円未満',
            5 => '３億円～５億円未満',
            6 => '５億円～１０億円未満',
            7 => '１０億円以上',
        ],

        // 業者、依頼、契約共通で使用するカテゴリー
        'category' => [
            10 => '外壁塗装',
            20 => '屋根塗装',
            30 => '屋上防水',
            40 => 'ベランダ防水',
            99 => 'その他',
        ],

        // 物件のタイプ
        'property' => [
            10 => '戸建',
            20 => 'アパート・マンション',
            30 => '工場・ビル',
            99 => 'その他',
        ],

        // 屋根の種類
        'roof' => [
            10 => '切妻屋根',
            20 => '寄棟屋根',
            30 => '片流れ屋根',
            40 => '陸屋根',
            50 => '方形屋根',
            60 => '入母屋根',
            70 => '半切妻屋根',
            80 => '差しかけ屋根',
            90 => 'のこぎり屋根',
        ],

        // 外壁の種類
        'wall' => [
            10 => 'ALC',
            20 => 'サイディング',
            30 => '木造',
            40 => 'コンクリート',
        ],

        // コラムのカテゴリー
        'column' => [
            10 => '日記',
            20 => '雑学',
            30 => '業務',
            99 => 'その他',
        ],

        // 工事に求めるもの
        'priority' => [
            10 => 'できるだけ工事を安くしたい',
            20 => '保証内容や品質にこだわりたい',
            30 => '完成時期や工事期間などにこだわりたい',
            40 => '職人や営業の人柄や知識を求めている',
        ],

        // 工期予定
        'period' => [
            10 => '３ヶ月以内',
            20 => '６ヶ月以内',
            30 => '１年以内',
            70 => 'できるだけ早く工事をしたい',
            80 => '色々相談して考えていきたい',
            90 => 'まだまだ考えていない',
            99 => 'よくわからない',
        ],

        // 進捗ステータス
        'status' => [
            0 => '新規',
            1 => '相談中',
            2 => '商談開始',
            3 => '見積提出',
            4 => '本契約',
            5 => '工事終了',
            6 => '完工',
        ],

        // 保証
        'warranty' => [
            0 => '',
            1 => '1年',
            2 => '2年',
            3 => '3年',
            4 => '4年',
            5 => '5年',
            6 => '6年',
            7 => '7年',
            8 => '8年',
            9 => '9年',
            10 => '10年',
        ],

        // 金額
        'amount' => [
            1 => '50-100万円',
            2 => '100-150万円',
            3 => '150-200万円',
            4 => '200-250万円',
            5 => '250-300万円',
            6 => '300-350万円',
            7 => '350-400万円',
            8 => '400-450万円',
            9 => '450-500万円',
            10 => '500万円以上',
        ],

        // 工事期間
        'construction_period' => [
            10 => '約1週間',
            20 => '2週間',
            30 => '3週間',
            40 => '1ヶ月以内',
            50 => '1ヶ月以上',
        ],
    ],

    // チャット画面の初期送信メッセージ
    'message' => '初めまして。よろしくお願いいたします。',
];
