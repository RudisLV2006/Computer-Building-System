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
        Schema::create('mother_boards', function (Blueprint $table) {
            $table->id();
            $table->string("manufacturer");
            $table->string("series");
            $table->string("socket");
            $table->string("chipset");
            $table->string("memory_technology");
            $table->string("form_factor");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mother_boards');
    }
};
