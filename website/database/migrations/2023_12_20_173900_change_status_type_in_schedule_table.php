<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeStatusTypeInScheduleTable extends Migration
{
    // Status values inlined after removing husam-tariq/filament-database-schedule
    private const STATUS_VALUES = ['inactive', 'active', 'trashed'];

    public function up()
    {
        $table = Config::get('filament-database-schedule.table.schedules', 'schedules');

        Schema::table($table, function (Blueprint $table) {
            $table->enum('new_status', self::STATUS_VALUES)->nullable()->after('status');
        });

        DB::table($table)->where('status', 0)->update(['new_status' => 'inactive']);
        DB::table($table)->where('status', 1)->update(['new_status' => 'active']);
        DB::table($table)->where('status', 3)->update(['new_status' => 'trashed']);

        Schema::table($table, function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table($table, function (Blueprint $table) {
            $table->renameColumn('new_status', 'status');
        });
        Schema::table($table, function (Blueprint $table) {
            $table->enum('status', self::STATUS_VALUES)->default('active')->change();
        });
    }

    public function down()
    {
        $table = Config::get('filament-database-schedule.table.schedules', 'schedules');

        Schema::table($table, function (Blueprint $table) {
            $table->boolean('old_status')->default(true)->after('status');
        });

        DB::table($table)->where('status', 'inactive')->update(['old_status' => 0]);
        DB::table($table)->where('status', 'active')->update(['old_status' => 1]);
        DB::table($table)->where('status', 'trashed')->update(['old_status' => 3]);

        Schema::table($table, function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table($table, function (Blueprint $table) {
            $table->renameColumn('old_status', 'status');
        });
    }
}
