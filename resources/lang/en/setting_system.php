<?php
return [
    'title' => 'Setting Systems',
    'map_scale' => 'Overall MAP Size Setting',
    'footer' => 'Footer Display',
    'type_name' => 'Type Name',
    'system_name' => 'System Name',
    'disclosure_info' => 'Disclosure information',
    'save' => 'Save',
    'setting_ja' => 'Japanese Notation',
    'setting_en' => 'English Notation',
    'label_map' => 'MAP center coordinates',
    'update_success' => 'Data has been updated.',
    'validate' => [
        'map_scale' => [
            'required' => ' Map scale is required.',
            'digits' => 'Map scale is number.',
            'minlength' => 'Map scale a number equal to 1.',
            'maxlength' => 'Map scale a number of 25 or down.',
        ],
        'footer' => [
            'required' => 'Footer is required.'
        ],
        'type_name_ja' => [
            'required' => 'Type name japan is required.'
        ],
        'type_name_en' => [
            'required' => 'Type name english is required.'
        ],
        'system_name_en' => [
            'required' => 'System name english is required.'
        ],
        'system_name_ja' => [
            'required' => 'System name japan is required.'
        ],
        'disclosure_info_ja' => [
            'required' => 'Disclosure information japan is required.'
        ],
        'disclosure_info_en' => [
            'required' => 'Disclosure information english is required.'
        ],
        'image_logo' => [
            'max' => 'The logo image must not be greater than 3 megabytes.',
            'mines' => 'The logo image must be correct format',
        ],
    ]
];
