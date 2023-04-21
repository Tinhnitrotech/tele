<?php
return [
    'title_register' => '入所手続き',
    'family_code' => '世帯番号',
    'title' => '避難者情報入力',
    'please_select' => '--',
    'is_owner' => '代表者',
    'note' => '要支援者備考欄',
    'gender_men' => '男',
    'gender_woman' => '女',
    'register_success' => '入所登録が完了しました',
    'register_success_note' => '退所時には世帯番号をもって退所手続きが必要になります。',
    'code_family_1' => 'あなた世帯番号は、',
    'code_family_2' => '番です。',
    'go_home' => 'ホームへ戻る',
    'password' => 'パスワード',
    'member_exit' => '退所手続き',
    'user_checkin' => '入所手続き',
    'sing_up' => '新規登録',
    'sing_up_other' => '他の場所から来た方',
    'check_out' => '退所手続を行います',
    'search' => '検索',
    'cancel' => '編集',
    'submit' => '登録',
    'confirm_public_information' => '上記の情報は本人のため退所します',
    'checkin_place' => '避難所に入所する',
    'checkout_success' => '退所手続きが完了しました。',
    'checkout_fail' => '退所手続きが失敗しました。',

    'checkin_success' => '入所手続きが完了しました。',
    'checkin_fail' => '入所手続きが失敗しました。',
    'checkin_again' => 'この避難所に入所していますので、再度入所しないで下さい。',
    'checkin_first_times' => '初めての方',

    'validate' => [
        'member' => [
            'family_code' => [
                'required' => '世帯番号が必要です'
            ],
            'family_password' => [
                'required' => 'パスワードが必要です。',
                'max' => 'パスワードは最大8文字です。',
                'min' => 'パスワードは最小4文字です。',
                'digit' => 'パスワードには数字を指定してください。'
            ]
        ],
        'register' => [
            'note' => [
                'max' => '最大200文字以下で指定してください。',
            ],
            'password' => [
                'max' => 'パスワードは最大8文字です。',
                'min' => 'パスワードは最小4文字です。',
               'digit' => 'パスワードには数字を指定してください。'
            ]

        ]
    ],
    'no_data' => 'データが見つかりません。',
];
