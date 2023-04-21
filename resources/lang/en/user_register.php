<?php
return [
    'title_register' => 'Admission procedure',
    'title' => 'The asylum details',
    'family_code' => 'Family Code',
    'please_select' => '--',
    'is_owner' => 'Owner',
    'note' => 'Note',
    'gender_men' => 'Men',
    'gender_woman' => 'Woman',
    'submit' => 'Submit',
    'register_success' => 'Registration to the evacuation center is complete.',
    'register_success_note' => 'When you leave, you will need to bring your household number to the exit procedure.',
    'code_family_1' => 'Your household is',
    'code_family_2' => 'number.',
    'go_home' => 'Go home',
    'password' => 'Password',
    'cancel' => 'Cancel',
    'member_exit' => 'Exit procedure',
    'user_checkin' => 'For those who are new to admission procedures',
    'sing_up' => 'sign up',
    'sing_up_other' => 'Those who came from other shelters',
    'check_out' => 'I will go through the exit procedure',
    'search' => 'Search',
    'confirm_public_information' => 'The above information will leave for you',
    'checkin_place' => 'Enter the shelter',
    'checkout_success' => 'Checkout Successfully.',
    'checkout_fail' => 'Checkout Fail.',

    'checkin_success' => 'CheckIn Successfully.',
    'checkin_fail' => 'CheckIn Fail.',
    'checkin_again' => 'You are in this shelter, so please do not re-enter.',
    'checkin_first_times' => 'Checkin first times',

    'validate' => [
        'member' => [
            'family_code' => [
                'required' => 'Family code is required.'
                ],
            'family_password' => [
                'required' => 'Family password is required.',
                'max' => 'Password input max 8 characters.',
                'min' => 'Password input min 4 characters.',
                'digit' => 'Password is number.'
            ]
        ],
        'register' => [
            'note' => [
                'max' => 'Note input max 200 characters.',
            ],
            'password' => [
                'max' => 'Password input max 8 number.',
                'min' => 'Password input min 4 number.',
                'digit' => 'Password is number.'
            ]
        ]
    ],
    'no_data' => 'No data found',
];
