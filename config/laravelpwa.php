<?php

return [
    'name' => 'SLSUQRAttendance',
    'manifest' => [
        'name' => env('APP_NAME', 'SLSU QR Attendance'),
        'short_name' => 'PWA',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        'icons' => [
            '72x72' => [
                'path' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
                'purpose' => 'any',
            ],
            '96x96' => [
                'path' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
                'purpose' => 'any',
            ],
            '128x128' => [
                'path' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
                'purpose' => 'any',
            ],
            '144x144' => [
                'path' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
                'purpose' => 'any',
            ],
            '152x152' => [
                'path' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
                'purpose' => 'any',
            ],
            '192x192' => [
                'path' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
                'purpose' => 'any',
            ],
            '384x384' => [
                'path' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
                'purpose' => 'any',
            ],
            '512x512' => [
                'path' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
                'purpose' => 'any',
            ],
        ],
        'splash' => [
            '640x1136' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
            '750x1334' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
            '828x1792' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
            '1125x2436' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
            '1242x2208' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
            '1242x2688' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
            '1536x2048' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
            '1668x2224' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
            '1668x2388' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
            '2048x2732' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Shortcut Link 1',
                'description' => 'Shortcut Link 1 Description',
                'url' => '/',
                'icons' => [
                    'src' => 'https://trace.southernleyte.org.ph/assets/img/slsu-logo.png',
                    'purpose' => 'any',
                ],
            ],
        ],
        'custom' => [],
    ],
];
