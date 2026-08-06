<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mail_logs', function (Blueprint $table) {
            $table->text('body')->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('mail_logs')->whereNull('body')->update(['body' => '']);

        Schema::table('mail_logs', function (Blueprint $table) {
            $table->text('body')->nullable(false)->change();
        });
    }
};
