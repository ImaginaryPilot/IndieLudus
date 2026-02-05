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
        Schema::create('match_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained('leagues')->onDelete('cascade')->unique();
            $table->json('stats'); // user-defined stats for this league
            $table->timestamps();
            $table->unsignedInteger('decider_stat_index');
            $table->enum('decider_mode', ['higher','lower'])->default('higher');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_templates');
    }
};
