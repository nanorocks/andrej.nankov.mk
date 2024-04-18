<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\WpApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

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

    public function posts()
    {
        $posts = $this->cacheSetup('posts', $this->wpApi);
        $metas = $this->cacheSetup('metas', $this->wpApi);
        $socMedias = $this->cacheSetup('socMedias', $this->wpApi);

        return view('posts', compact('posts', 'metas', 'socMedias'));
    }

    public function home(Request $request)
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

        $darkMode = config('app.dark_mode_ui');

        try {
            $darkMode = is_null($request->get('dm')) ?  $darkMode : $request->get('dm');

            if (is_bool($darkMode)) {
                throw new \Exception('Invalid value');
            }
        } catch (Exception $e) {
            // abort('403', $e->getMessage());
            $darkMode = config('app.dark_mode_ui');
        }

        return view('home', compact('profile', 'devTools', 'goals', 'highlights', 'posts', 'projects', 'quotes', 'socMedias', 'metas', 'projectsStatus', 'darkMode'));
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
        Artisan::call('config:clear');

        return redirect('/dashboard')->with('msg', 'It works. Cache Cleared!');
    }

    public function optimize()
    {
        Artisan::call('optimize');

        return redirect('/dashboard')->with('msg', 'It works. Optimize complied!');
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

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        return redirect()->back()->with([
            'message' => 'Successfully logged out'
        ]);
    }
}
