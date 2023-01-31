<?php

return [

    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行はバリデタークラスにより使用されるデフォルトのエラー
    | メッセージです。サイズルールのようにいくつかのバリデーションを
    | 持っているものもあります。メッセージはご自由に調整してください。
    |
    */

    'accepted'             => ':attributeを承認してください。',
    'active_url'           => ':attributeが有効なURLではありません。',
    'after'                => ':attributeには、:dateより後の日付を指定してください。',
    'after_or_equal'       => ':attributeには、:date以降の日付を指定してください。',
    'alpha'                => ':attributeはアルファベットのみがご利用できます。',
    'alpha_dash'           => ':attributeはアルファベットとダッシュ(-)及び下線(_)がご利用できます。',
    'alpha_num'            => ':attributeはアルファベット数字がご利用できます。',
    'array'                => ':attributeは配列でなくてはなりません。',
    'before'               => ':attributeには、:dateより前の日付をご利用ください。',
    'before_or_equal'      => ':attributeには、:date以前の日付をご利用ください。',
    'between'              => [
        'numeric' => ':attributeは、:minから:maxの間で指定してください。',
        'file'    => ':attributeは、:min kBから、:max kBの間で指定してください。',
        'string'  => ':attributeは、:min文字から、:max文字の間で指定してください。',
        'array'   => ':attributeは、:min個から:max個の間で指定してください。',
    ],
    'boolean'              => ':attributeは、trueかfalseを指定してください。',
    'confirmed'            => ':attributeと、確認フィールドとが、一致していません。',
    'date'                 => ':attributeには有効な日付を指定してください。',
    'date_equals'          => ':attributeには、:dateと同じ日付けを指定してください。',
    'date_format'          => ':attributeは:format形式で指定してください。',
    'different'            => ':attributeと:otherには、異なった内容を指定してください。',
    'digits'               => ':attributeは:digits桁で指定してください。',
    'digits_between'       => ':attributeは:min桁から:max桁の間で指定してください。',
    'dimensions'           => ':attributeの図形サイズが正しくありません。',
    'distinct'             => ':attributeには異なった値を指定してください。',
    'email'                => ':attributeには、有効なメールアドレスを指定してください。',
    'ends_with'            => ':attributeには、:valuesのどれかで終わる値を指定してください。',
    'exists'               => '選択された:attributeは正しくありません。',
    'file'                 => ':attributeにはファイルを指定してください。',
    'filled'               => ':attributeに値を指定してください。',
    'gt'                   => [
        'numeric' => ':attributeには、:valueより大きな値を指定してください。',
        'file'    => ':attributeには、:value kBより大きなファイルを指定してください。',
        'string'  => ':attributeは、:value文字より長く指定してください。',
        'array'   => ':attributeには、:value個より多くのアイテムを指定してください。',
    ],
    'gte'                  => [
        'numeric' => ':attributeには、:value以上の値を指定してください。',
        'file'    => ':attributeには、:value kB以上のファイルを指定してください。',
        'string'  => ':attributeは、:value文字以上で指定してください。',
        'array'   => ':attributeには、:value個以上のアイテムを指定してください。',
    ],
    'image'                => ':attributeには画像ファイルを指定してください。',
    'in'                   => '選択された:attributeは正しくありません。',
    'in_array'             => ':attributeには:otherの値を指定してください。',
    'integer'              => ':attributeは整数で指定してください。',
    'ip'                   => ':attributeには、有効なIPアドレスを指定してください。',
    'ipv4'                 => ':attributeには、有効なIPv4アドレスを指定してください。',
    'ipv6'                 => ':attributeには、有効なIPv6アドレスを指定してください。',
    'json'                 => ':attributeには、有効なJSON文字列を指定してください。',
    'lt'                   => [
        'numeric' => ':attributeには、:valueより小さな値を指定してください。',
        'file'    => ':attributeには、:value kBより小さなファイルを指定してください。',
        'string'  => ':attributeは、:value文字より短く指定してください。',
        'array'   => ':attributeには、:value個より少ないアイテムを指定してください。',
    ],
    'lte'                  => [
        'numeric' => ':attributeには、:value以下の値を指定してください。',
        'file'    => ':attributeには、:value kB以下のファイルを指定してください。',
        'string'  => ':attributeは、:value文字以下で指定してください。',
        'array'   => ':attributeには、:value個以下のアイテムを指定してください。',
    ],
    'max'                  => [
        'numeric' => ':attributeには、:max以下の数字を指定してください。',
        'file'    => ':attributeには、:max kB以下のファイルを指定してください。',
        'string'  => ':attributeは、:max文字以下で指定してください。',
        'array'   => ':attributeは:max個以下指定してください。',
    ],
    'mimes'                => ':attributeには:valuesタイプのファイルを指定してください。',
    'mimetypes'            => ':attributeには:valuesタイプのファイルを指定してください。',
    'min'                  => [
        'numeric' => ':attributeには、:min以上の数字を指定してください。',
        'file'    => ':attributeには、:min kB以上のファイルを指定してください。',
        'string'  => ':attributeは、:min文字以上で指定してください。',
        'array'   => ':attributeは:min個以上指定してください。',
    ],
    'not_in'               => '選択された:attributeは正しくありません。',
    'not_regex'            => ':attributeの形式が正しくありません。',
    'numeric'              => ':attributeには、数字を指定してください。',
    'password'             => 'パスワードが正しくありません。',
    'present'              => ':attributeが存在していません。',
    'regex'                => ':attributeに正しい形式を指定してください。',
    'required'             => ':attributeは必ず指定してください。',
    'required_if'          => ':otherが:valueの場合、:attributeも指定してください。',
    'required_unless'      => ':otherが:valuesでない場合、:attributeを指定してください。',
    'required_with'        => ':valuesを指定する場合は、:attributeも指定してください。',
    'required_with_all'    => ':valuesを指定する場合は、:attributeも指定してください。',
    'required_without'     => ':valuesを指定しない場合は、:attributeを指定してください。',
    'required_without_all' => ':valuesのどれも指定しない場合は、:attributeを指定してください。',
    'same'                 => ':attributeと:otherには同じ値を指定してください。',
    'size'                 => [
        'numeric' => ':attributeは:sizeを指定してください。',
        'file'    => ':attributeのファイルは、:sizeキロバイトでなくてはなりません。',
        'string'  => ':attributeは:size文字で指定してください。',
        'array'   => ':attributeは:size個指定してください。',
    ],
    'starts_with'          => ':attributeには、:valuesのどれかで始まる値を指定してください。',
    'string'               => ':attributeは文字列を指定してください。',
    'timezone'             => ':attributeには、有効なゾーンを指定してください。',
    'unique'               => ':attributeの値は既に存在しています。',
    'uploaded'             => ':attributeのアップロードに失敗しました。',
    'url'                  => ':attributeに正しい形式を指定してください。',
    'uuid'                 => ':attributeに有効なUUIDを指定してください。',

    'without_html'         => ':attribute の入力にHTMLタグは使用できません',

    /*
    |--------------------------------------------------------------------------
    | Custom バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | "属性.ルール"の規約でキーを指定することでカスタムバリデーション
    | メッセージを定義できます。指定した属性ルールに対する特定の
    | カスタム言語行を手早く指定できます。
    |
    */

    'custom' => [
        '属性名' => [
            'ルール名' => 'カスタムメッセージ',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション属性名
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は、例えば"email"の代わりに「メールアドレス」のように、
    | 読み手にフレンドリーな表現でプレースホルダーを置き換えるために指定する
    | 言語行です。これはメッセージをよりきれいに表示するために役に立ちます。
    |
    */

    'attributes' => [
        'username' => 'ユーザ名',
        'password' => 'パスワード',
        'new_password' => '新しいパスワード',
        'contents' => '内容',
        'email' => 'メールアドレス',
        'name' => '名称',
        'kana' => 'フリガナ',
        'ceo_name' => '代表者名',
        'type' => '事業内容',
        'city' => '市区町村',
        'address' => '住所',
        'address1' => '住所１',
        'address2' => '住所２',
        'tel' => '電話番号',
        'fax' => 'FAX番号',
        'charge_name1' => '担当者姓',
        'charge_name2' => '担当者名',
        'charge_kana1' => '担当者カナ姓',
        'charge_kana2' => '担当者カナ名',
        'charge_tel' => '担当者電話番号',
        'charge_email' => '担当者メールアドレス',
        'url' => 'ホームページ',
        'established' => '設立年',
        'capital' => '資本金',
        'permission' => '建設業許可証',
        'organization' => '加盟団体',
        'employees' => '従業員数',
        'other_insurance' => 'その他民間保険',
        'image_file' => '画像ファイル',
        'catch_copy' => 'キャッチコピー',
        'constructions' => '施工件数',
        'annual_constructions' => '年間施工件数',
        'pr_copy' => 'PRコピー',
        'name1' => '姓',
        'name2' => '名',
        'kana1' => 'カナ姓',
        'kana2' => 'カナ名',
        'nickname' => 'ニックネーム',
        'postal' => '郵便番号',
        'birth_date' => '生年月日',
        'mobile' => '携帯電話番号',
        'area' => '敷地面積',
        'area_b' => '建坪',
        'floors' => '階数',
        'age' => '築年数',
        'num' => '戸数',
        'repainting_wall' => '前回塗替_外壁',
        'repainting_roof' => '前回塗替_屋根',
        'title' => 'タイトル',
        'budget' => '予算',
        'visit_schedule' => '初回訪問予定',
        'visit_record' => '初回訪問実績',
        'quotation1' => '見積書１',
        'quotation2' => '見積書２',
        'quotation3' => '見積書３',
        'quotation4' => '見積書４',
        'quotation5' => '見積書５',
        'document1' => '添付書類１',
        'document2' => '添付書類２',
        'document3' => '添付書類３',
        'document4' => '添付書類４',
        'document5' => '添付書類５',
        'user_memo' => '相談メモ個人',
        'painter_memo' => '相談メモ業者',
        'visit_memo' => '訪問メモ',
        'quotation_memo' => '見積メモ',
        'document' => '契約書',
        'contract_amount' => '契約金額',
        'contract_date' => '契約日',
        'contract_details' => '契約内容詳細',
        'charge_name' => '担当者',
        'plan' => '工事プラン',
        'period' => '工事期間',
        'paint' => '使用塗料',
        'warranty_title' => '保証項目名',
        'warranty' => '保証内容',
        'memo' => 'メモ',
        'complete_date' => '完工日',
        'amount' => '金額',
        'image_file1' => '画像ファイル１',
        'image_file2' => '画像ファイル２',
        'image_file3' => '画像ファイル３',
        'image_file4' => '画像ファイル４',
        'image_file5' => '画像ファイル５',
        'image_file6' => '画像ファイル６',
        'comment' => 'コメント',
        'user_name' => 'ユーザ名',
        'category' => '分類',
    ],

];
