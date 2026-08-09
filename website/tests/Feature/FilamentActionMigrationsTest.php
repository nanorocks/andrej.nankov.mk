<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FilamentActionMigrationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_filament_action_tables_are_part_of_the_application_schema(): void
    {
        $this->assertTrue(Schema::hasTable('imports'));
        $this->assertTrue(Schema::hasTable('exports'));
        $this->assertTrue(Schema::hasTable('failed_import_rows'));
    }
}
