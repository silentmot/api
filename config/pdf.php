<?php

return [
    'mode'         => 'utf-8',
    'format'       => 'A4',
    'author'       => 'SLF',
    'subject'      => '',
    'keywords'     => '',
    'creator'      => 'SLF System',
    'display_mode' => 'fullpage',
    'tempDir'      => base_path('storage/app/public/temp/'),
    // 'font_path' => base_path('resources/fonts/'),
    'font_data' => [
        'dejavusanscondensed' => [
            'R'  => 'DejaVuSansCondensed.ttf',    // regular font
            'B'  => 'DejaVuSansCondensed-Bold.ttf',       // optional: bold font
            'I'  => 'DejaVuSansCondensed-Oblique.ttf"',     // optional: italic font
            'BI' => 'DejaVuSansCondensed-BoldOblique.ttf', // optional: bold-italic font
            'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
            'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
        ]
    ]
];
