<?php

namespace App\Helpers;

class WpApiMapper
{
    const PROJECTS = [
        'Single Project' => 'wp-json/wp/v2/projects/82',
        'Filter by attribute' => 'wp-json/wp/v2/projects?slug=valuta-php-mk',
        'All Projects' => 'wp-json/wp/v2/projects?_fields=id,title.rendered,status,slug,acf,content.rendered&per_page=50',
    ];

    const POSTS = [
        'Single Post' => 'wp-json/wp/v2/posts/50',
        'Filter by attribute Post' => 'wp-json/wp/v2/posts?slug=laravel-compass-integration',
        'All Projects & Limit' => 'wp-json/wp/v2/posts?per_page=1',
    ];

    const HIGHLIGHTS = [
        'All Highlights' => 'wp-json/wp/v2/highlights/27',
    ];

    const GOALS = [
        'All Goals' => 'wp-json/wp/v2/goals',
    ];

    const PROFILE = [
        'Single Profile' => 'wp-json/wp/v2/profiles/107',
    ];

    const QUOTES = [
        'All Quotes' => 'wp-json/wp/v2/quotes',
    ];

    const DEV_TOOLS = [
        'All devTools & filter fields' => 'wp-json/wp/v2/devtools??_fields=id,title.rendered,status,slug,acf&per_page=50',
    ];

    const SOC_MEDIAS = [
        'All socMedias & filter fields' => 'wp-json/wp/v2/socmedias?_fields=id,title.rendered,status,slug,acf',
    ];

    const METAS = [
        'All Meta for the page' => 'wp-json/wp/v2/metas?_fields=id,title.rendered,content.rendered',
    ];
}
