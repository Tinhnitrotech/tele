<?php
return [
    'title' => '環境設定',
    'map_scale' => '全体MAP縮尺率',
    'footer' => 'フッター表示',
    'type_name' => '通称',
    'system_name' => 'システム名',
    'disclosure_info' => '情報公開の説明',
    'save' => '保存',
    'setting_ja' => '日本語表記',
    'setting_en' => '英語表記',
    'label_map' => 'MAPの中心座標',
    'update_success' => 'データが更新されました。',
    'validate' => [
        'map_scale' => [
            'required' => '全体MAP縮尺率は必須です。',
            'digits' => '全体MAP縮尺率、半角数字の正しい形式で入力してください。',
            'minlength' => '全体MAP縮尺率には1以上の数字を指定してください。',
            'maxlength' => '全体MAP縮尺率ドには25以上の数字を指定してください。',
        ],
        'footer' => [
            'required' => 'フッター表示は必須です。',
        ],
        'type_name_ja' => [
            'required' => '通称は必須です。'
        ],
        'type_name_en' => [
            'required' => '通称は必須です。'
        ],
        'system_name_en' => [
            'required' => 'システム名は必須です。'
        ],
        'system_name_ja' => [
            'required' => 'システム名は必須です。'
        ],
        'disclosure_info_ja' => [
            'required' => '情報公開の説明は必須です。'
        ],
        'disclosure_info_en' => [
            'required' => '情報公開の説明は必須です。'
        ],
        'image_logo' => [
            'max' => '画像サイズは3MB以内のものをご使用ください。',
            'mines' => 'ロゴ画像のフォーマットが正しいものをご使用ください。',
        ],
    ],

];
