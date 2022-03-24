<?php

namespace App\Http\Controllers;

use App\Services\WpApi;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{

    /**
     * @var WpApi
     */
    public $wpApi;

    public function __construct(WpApi $wpApi)
    {
        $this->wpApi = $wpApi;
    }

    public function home()
    {
        $profile = $this->cacheSetup('profile', $this->wpApi);
        $devTools = $this->cacheSetup('devTools', $this->wpApi);
        $goals = $this->cacheSetup('goals', $this->wpApi);
        $highlights = $this->cacheSetup('highlights', $this->wpApi);
        $posts = $this->cacheSetup('posts', $this->wpApi);
        $projects = $this->cacheSetup('projects', $this->wpApi);
        $quotes = $this->cacheSetup('quotes', $this->wpApi);
        $socMedias = $this->cacheSetup('socMedias', $this->wpApi);
        $metas = $this->cacheSetup('metas', $this->wpApi);

        $projectsStatus = $this->wpApi->projectsStatus($projects);

        return view('home', compact('profile', 'devTools', 'goals', 'highlights', 'posts', 'projects', 'quotes', 'socMedias', 'metas', 'projectsStatus'));
    }

    public function project(string $slug)
    {
        $project = $this->wpApi->singleProject($slug);
        $socMedias = $this->cacheSetup('socMedias', $this->wpApi);
        $metas = $this->cacheSetup('metas', $this->wpApi);

        return view('project', compact('project', 'metas', 'socMedias'));
    }

    public function post(string $slug)
    {
        $post = $this->wpApi->singlePost($slug);
        $socMedias = $this->cacheSetup('socMedias', $this->wpApi);
        $metas = $this->cacheSetup('metas', $this->wpApi);

        return view('post', compact('post', 'metas', 'socMedias'));
    }

    public function cacheClear()
    {
        Artisan::call('cache:clear');
        die('It works. cache cleared!!!');
    }

    /**
     * @param string $key
     * @param $call
     * @return mixed
     */
    private function cacheSetup(string $key, $call)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $wpCall = $call->{$key}();

        Cache::put($key, $wpCall);

        return $wpCall;
    }
}