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
        Schema::create('league_table_columns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained()->onDelete('cascade');
            $table->string('name');       // Column name shown to coordinator
            $table->string('key_name');   // Internal key for programmatic use
            $table->boolean('is_team_name')->default(false); // Flag for the special column
            $table->enum('type', ['integer','decimal','string','computed'])->default('integer');
            $table->integer('position')->default(0); // order in table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_table_columns');
    }
};
