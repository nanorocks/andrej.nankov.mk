<?php

use RalphJSmit\Laravel\SEO\Models\SEO;

return [
    'model'     => SEO::class,
    'site_name' => env('APP_NAME', 'Andrej Nankov'),
    'sitemap'   => '/sitemap.xml',

    'canonical_link' => true,

    'robots' => [
        'default'       => 'max-snippet:-1,max-image-preview:large,max-video-preview:-1',
        'force_default' => false,
    ],

    'favicon' => '/favicon.ico',

    'title' => [
        'infer_title_from_url' => true,
        'suffix'               => ' | Andrej Nankov',
        'homepage_title'       => null,
    ],

    'description' => [
        'fallback' => 'Fractional CTO, Startup Consultant & Senior Engineer — partnering with startups to build reliable, scalable software.',
    ],

    'image' => [
        'fallback' => null,
    ],

    'author' => [
        'fallback' => 'Andrej Nankov',
    ],

    'twitter' => [
        '@username' => env('TWITTER_USERNAME', null),
    ],
];
