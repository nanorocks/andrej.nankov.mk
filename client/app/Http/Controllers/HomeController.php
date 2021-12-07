<?php

namespace App\Http\Controllers;

use App\Services\WpApi;
use Illuminate\Support\Facades\Http;

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
        $profile = $this->wpApi->profile();
        $devTools = $this->wpApi->devTools();
        $goals = $this->wpApi->goals();
        $highlights = $this->wpApi->highlights();
        $posts = $this->wpApi->posts();
        $projects = $this->wpApi->projects();
        $projectsStatus = $this->wpApi->projectsStatus($projects);
        $counter = $this->wpApi->counter();
        $socMedias = $this->wpApi->socMedias();
        $metas = $this->wpApi->metas();
//        dd($posts);
        return view('home', compact('profile', 'devTools', 'goals', 'highlights', 'posts', 'projects', 'counter', 'socMedias', 'metas', 'projectsStatus'));
    }

    public function project(string $slug)
    {
        $project = $this->wpApi->singleProject($slug);
        $metas = $this->wpApi->metas();
        $socMedias = $this->wpApi->socMedias();

        return view('project', compact('project', 'metas', 'socMedias'));
    }

    public function post(string $slug)
    {
        $post = $this->wpApi->singlePost($slug);
        $metas = $this->wpApi->metas();
        $socMedias = $this->wpApi->socMedias();
        return view('post', compact('post', 'metas', 'socMedias'));
    }
}
