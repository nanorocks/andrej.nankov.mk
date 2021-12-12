<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "nankov.mk", // set false to total remove
            'titleBefore'  => "Personal website of Andrej Nankov", // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => 'Content related on building professional carrier as Software Engineer', // set false to total remove
            'separator'    => ' | ',
            'keywords'     => ['software', 'profile', 'developer', 'engineer', 'posts', 'projects', 'work', 'experience'],
            'canonical'    => 'full', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots'       => 'all', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => "nankov.mk", // set false to total remove
            'description' => "Personal website of Andrej Nankov", // set false to total remove
            'url'         => 'https://nankov.mk', // Set null for using Url::current(), set false to total remove
            'type'        => 'article',
            'site_name'   => 'nankov.mk',
            'images'      => ['https://wpadmin.nankov.mk/wp-content/uploads/2021/11/250978249_2952591805054393_1722592307182354630_n-e1639231192454.jpeg'],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => "nankov.mk", // set false to total remove
            'description' => "Personal website of Andrej Nankov", // set false to total remove
            'url'         => 'https://nankov.mk', // Set null for using Url::current(), set false to total remove
            'type'        => 'WebPage',
            'images'      => ['https://wpadmin.nankov.mk/wp-content/uploads/2021/11/250978249_2952591805054393_1722592307182354630_n-e1639231192454.jpeg'],
        ],
    ],
];
