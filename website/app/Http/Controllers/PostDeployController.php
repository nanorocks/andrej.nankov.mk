<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PostDeployController extends Controller
{
    public function __invoke(Request $request)
    {
        // Optional: Add a secret token check for security
        if ($request->input('token') !== env('POST_DEPLOY_TOKEN')) {
            abort(403, 'Unauthorized');
        }

        // Run composer install (not recommended via PHP, best via SSH)
        exec('composer install');

        // Run migrations and optimize
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('optimize');

        return response()->json(['status' => 'Post-deploy commands executed.']);
    }
}
