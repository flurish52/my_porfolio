<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add position to multiple tables
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('position')->default(0)->after('id');
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->integer('position')->default(0)->after('id');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->integer('position')->default(0)->after('id');

            // Add new fields
            $table->string('link')->nullable()->after('position');
            $table->string('image')->nullable()->after('link');
            $table->string('role')->nullable()->after('image');
        });

        Schema::table('site_stats', function (Blueprint $table) {
            $table->integer('position')->default(0)->after('id');
        });
    }

    public function down(): void
    {
        // Drop from categories
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('position');
        });

        // Drop from skills
        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn('position');
        });

        // Drop from projects
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['position', 'link', 'image']);
        });

        // Drop from site_stats
        Schema::table('site_stats', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};
