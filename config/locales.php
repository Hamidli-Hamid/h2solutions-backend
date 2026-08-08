<?php

return [
    /*
    | Comma-separated codes in .env (H2_SUPPORTED_LOCALES) drive this list.
    | Adding a new language = add its code here AND create the matching
    | dictionary file on the Next.js side; no PHP code change required.
    */
    'supported' => array_values(array_filter(array_map(
        'trim',
        explode(',', env('H2_SUPPORTED_LOCALES', 'az,en,ru,de,kk,uz'))
    ))),

    'default' => env('APP_LOCALE', 'az'),

    /*
    | Endonyms shown on the admin translation tabs. Codes not listed here still
    | work — the tab just falls back to the raw code.
    */
    'labels' => [
        'az' => 'Azərbaycan',
        'en' => 'English',
        'ru' => 'Русский',
        'de' => 'Deutsch',
        'kk' => 'Қазақша',
        'uz' => 'Oʻzbekcha',
        'tr' => 'Türkçe',
    ],
];
