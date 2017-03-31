<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:uw_two_clicks/Resources/Private/Language/locallang_db.xlf:tca.database_table_tile',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY title',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'record_id' => 'record_id',
        'record_type' => 'record_type',
        'embedded_text' => 'embedded_text',
        'auto_play' => 'auto_play',
        'preview_image_id' => 'preview_image_id',
        'license' => 'license',
        'width' => 'width',
        'height' => 'height'
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => '0',
            ],
        ],
        'record_type' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:uw_two_clicks/Resources/Private/Language/locallang_db.xlf:tca.record_type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['LLL:EXT:uw_two_clicks/Resources/Private/Language/locallang_db.xlf:tca.record_type_youtube', 'yt'],
                    ['LLL:EXT:uw_two_clicks/Resources/Private/Language/locallang_db.xlf:tca.record_type_google_map', 'gm'],
                ],
            ],
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tca.title',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'eval' => 'trim',
            ],
        ],
        'url' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tca.url',
            'config' => [
                'type' => 'input',
                'size' => 500,
                'eval' => 'trim',
            ],
        ],
        'license' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tca.license',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'eval' => 'trim',
            ],
        ],
        'record_id' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tca.record_id',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required,trim',
            ],
        ],
        'preview_image_id' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tca.preview_image_id',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,int',
            ],
        ],
        'width' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tca.width_desc',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,int',
            ],
        ],
        'height' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tca.height_desc',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,int',
            ],
        ],
        'content_id' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tca.content_id',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,int',
            ],
        ],
        'auto_play' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tca.auto_play_desc',
            'config' => [
                'type' => 'check',
            ],
        ],
        'embedded_text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tca.embedded_text_desc',
            'config' => [
                'type' => 'text',
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'title, hidden, record_id, record_type, embedded_text, auto_play;;1 '],
        '1' => ['showitem' => 'title, preview_image_id '],
        '2' => ['showitem' => 'title, width, height, hidden '],
    ],
    'palettes' => [
        '1' => ['showitem' => 'record_id'],
    ],
];