<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('options') || ! Schema::hasColumn('options', 'option_value')) {
            return;
        }

        $column = DB::selectOne("SHOW COLUMNS FROM `options` LIKE 'option_value'");

        if (! $column) {
            return;
        }

        $type = strtolower((string) ($column->Type ?? ''));

        if (str_contains($type, 'longtext')) {
            return;
        }

        DB::statement('ALTER TABLE `options` MODIFY `option_value` LONGTEXT NULL');
    }

    public function down(): void
    {
        if (! Schema::hasTable('options') || ! Schema::hasColumn('options', 'option_value')) {
            return;
        }

        DB::statement('ALTER TABLE `options` MODIFY `option_value` TEXT NULL');
    }
};
