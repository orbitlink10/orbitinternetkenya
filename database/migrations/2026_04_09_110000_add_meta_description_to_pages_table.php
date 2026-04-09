<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pages', 'meta_description')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->text('meta_description')->nullable()->after('meta_title');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pages', 'meta_description')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropColumn('meta_description');
            });
        }
    }
};
