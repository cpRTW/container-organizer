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
        Schema::create('swap_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_container')->constrained('containers');
            $table->foreignId('to_container')->constrained('containers');
            $table->foreignId('ball_id')->constrained('balls');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swap_operations');
    }
};
