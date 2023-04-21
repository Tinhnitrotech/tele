<?php
return [
    'validate' => [
        'name_staff' => [
            'max' =>'Staff name 200 characters or less.',
            'required' =>'Staff name is required.',
        ],
        'name_admin' => [
            'max' =>'Admin name 200 characters or less.',
            'required' =>'Admin name is required.',
        ],
        'name_admin_kana' => [
            'max' =>'Admin name kana 200 characters or less.',
            'required' =>'Admin kana name is required.',
        ],
        'name_place' => [
            'max' =>'Place name 200 characters or less.',
            'required' =>'Place name is required.',
        ],
        'email' => [
            'max' =>'Email must not be greater than 100 characters.',
            'required' =>'Email is required.',
            'email' => 'Email must be a valid email address',
        ],
        'birthday' => [
            'required' => 'Birthday is required',
            'date' => 'Please enter a valid date.',
        ],
        'tel' => [
            'required' => 'Phone number is required',
            'digits_between' => 'Phone number between 10 to 11 numbers.',
            'regex' => 'Format phone number not correct.',
        ],
        'postal_code_1' => [
            'required' =>' Zip code is required. ',
            'numeric' =>' Specify a number for the zip code. ',
            'digits' =>' The first zip code with 3 digits',
        ],
        'postal_code_2' => [
            'required' =>' Zip code is required. ',
            'numeric' =>' Specify a number for the zip code. ',
            'digits' =>' The second zip code with 4 digits',
        ],
        'postal_code_default_1' => [
            'required' =>'Initial zip code is required. ',
            'numeric' =>' Specify a number for the initial zip code. ',
            'digits' =>' The first initial zip code with 3 digits',
        ],
        'postal_code_default_2' => [
            'required' =>' Initial zip code is required. ',
            'numeric' =>' Specify a number for the initial zip code. ',
            'digits' =>' The second zip initial code with 4 digits',
        ],
        'prefecture_id' => [
            'required' =>'Prefecture is required. ',
            'numeric' =>'Prefecture is number.',
            'min' => 'Prefecture a number equal to 1.',
            'max' => 'Prefecture a number of 47 or down.'
        ],
        'prefecture_id_default' => [
            'required' =>'Initial prefecture is required. ',
            'numeric' =>'Initial prefecture is number.',
            'min' => 'Initial prefecture a number equal to 1.',
            'max' => 'Initial prefecture a number of 47 or down.'
        ],
        'address' => [
            'required' => 'Location is required.',
        ],
        'address_default' => [
            'required' => 'Initial location is required.',
        ],
        'total_place' => [
            'required' => 'Capacity is required.',
            'numeric' => 'Capacity is number.',
        ],
        'latitude' => [
            'required' => 'Latitude is required.',
            'regex' => 'Latitude invalid coordinate format.',
        ],
        'longitude' => [
            'required' => 'Longitude is required.',
            'regex' => 'Longitude invalid coordinate format.',
        ],
        'csv_file' => [
            'required' => 'CSV File is required.',
            'file' => 'Please input file csv.',
            'mimes' => 'File import only accept type .csv.'
        ],
        'altitude' => [
            'numeric' => 'The altitude exacerbated is a number.'
        ],
        'password' => [
            'required' => 'Password is required.',
            'min' => 'Password 8 characters or than.',
            'max' => 'Password 15 characters or less.',
        ],
        'gender' => [
            'required' => 'Gender is required.',
            'digits' => 'The gender is a number.'
        ]
    ],
];
