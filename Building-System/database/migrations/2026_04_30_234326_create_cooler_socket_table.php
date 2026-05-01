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
        Schema::create('cooler_sockets', function (Blueprint $table) {
            $table->foreignId('cooler_id')->constrained('cpu_cooler_specs', 'product_id')->cascadeOnDelete();
            $table->string('socket');
            $table->timestamps();

            $table->unique(['cooler_id', 'socket']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooler_sockets');
    }
};
