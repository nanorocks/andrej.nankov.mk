<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SecurityTestSuite extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function complete_security_test_suite_runs_successfully(): void
    {
        // This test ensures all security components work together
        // and serves as a comprehensive smoke test

        $this->artisan('incident:test', ['type' => 'brute_force'])
             ->expectsOutput('✅ Test notification sent successfully!')
             ->assertExitCode(0);

        $this->artisan('incident:test', ['type' => 'failed_login'])
             ->expectsOutput('✅ Test notification sent successfully!')
             ->assertExitCode(0);

        $this->artisan('incident:test', ['type' => 'suspicious_activity'])
             ->expectsOutput('✅ Test notification sent successfully!')
             ->assertExitCode(0);

        $this->assertTrue(true); // If we get here, all tests passed
    }
}
