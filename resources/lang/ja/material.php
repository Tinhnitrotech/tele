<?php
return [
    'title' => '物資マスタ管理',
    'supply_name' => '物資',
    'unit' => '単位',
    'action_column' => '削除',
    'title_create_page' => '物資情報登録',
    'title_edit_page' => '物資情報編集',
    'import_title_page' => '物資マスタCSVインポート',
    'import_csv_success' => 'CSVが正常にインポートされました。',
    'import_csv_fail' => 'CSVのインポートに失敗しました。',
    'required_csv_input' => 'CSVファイルを選択してください。',
    'button_import' => 'インポート',
    'button_create' => '新規登録',
    'cancel' => 'キャンセル',
    'submit' => '登録',
    'update' => '更新',
    'validate' => [
        'name' => [
            'max' =>'物資は100文字以下で指定してください。',
            'required' =>'物資は必須です。',
        ],
        'unit' => [
            'max' =>'単位は100文字以下で指定してください。',
        ],
    ],
    'title_export' => '物資CSVインポート',
];
