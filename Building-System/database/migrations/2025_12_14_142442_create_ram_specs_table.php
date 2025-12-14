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
        Schema::create('ram_specs', function (Blueprint $table) {
            $table->foreignId('product_id')->primary()->constrained()->onDelete('cascade');
            $table->string('manufacturer');
            $table->string('series');
            $table->string('memory_type');
            $table->unsignedSmallInteger('capacity_gb');
            $table->unsignedTinyInteger('modules');
            $table->unsignedSmallInteger('speed_mhz'); // 3200, 3600, 60
            $table->unsignedSmallInteger('base_speed_mhz')->nullable();
            $table->unsignedTinyInteger('cas_latency');
            $table->decimal('voltage_v', 3, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ram_specs');
    }
};
