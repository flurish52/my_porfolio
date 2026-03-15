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
        Schema::create('profile_settings', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('occupation')->nullable();
            $table->string('picture')->nullable();       // stored file path
            $table->text('about')->nullable();
            $table->text('nav_description')->nullable();
            $table->text('home_description')->nullable();
            $table->json('links')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_settings');
    }
};
