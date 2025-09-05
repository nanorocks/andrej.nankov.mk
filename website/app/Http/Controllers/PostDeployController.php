<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PostDeployController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validate token from query parameter
        if ($request->query('token') !== config('app.post_deploy_token')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Run composer install
        $composerOutput = [];
        $composerReturn = 0;
        exec('composer install 2>&1', $composerOutput, $composerReturn);

        // Run migrations
        Artisan::call('migrate', ['--force' => true]);
        $migrateOutput = Artisan::output();

        // Run optimize
        Artisan::call('optimize');
        $optimizeOutput = Artisan::output();

        // Prepare report
        $report = [
            'composer' => [
                'return_code' => $composerReturn,
                'output' => implode("\n", $composerOutput),
            ],
            'migrate' => $migrateOutput,
            'optimize' => $optimizeOutput,
        ];

        return response()->json([
            'status' => 'Post-deploy commands executed.',
            'report' => $report,
        ]);
    }
}
