<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\WpApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use \Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Laravel\Passport\RefreshTokenRepository;

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

    public function pulsePurge()
    {
        DB::table('pulse_entries')->truncate();
        DB::table('pulse_aggregates')->truncate();

        return redirect('/dashboard')->with('msg', 'It works. Pulse Puget!');
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

        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);


        $user = Auth::user();

        dd($user->tokens);

        // Revoke an access token...
        // $tokenRepository->revokeAccessToken($tokenId);

        // Revoke all of the token's refresh tokens...
        // $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

        // Auth::guard('api')->logout();
        Auth::guard('web')->logout();

        if ($request->query('redirect')) {
            return redirect($request->query('redirect'))->with([
                'message' => 'Successfully logged out'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Successfully logged out'
        ]);
    }
}
