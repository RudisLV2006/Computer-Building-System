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
        Schema::create('cpu_specs', function (Blueprint $table) {
            $table->foreignId('product_id')->primary()->constrained()->onDelete('cascade');
            $table->string("manufacturer");
            $table->string("series");
            $table->string("socket");
            $table->decimal("cpu_speed_ghz", 3, 1)->comment("CPU speed in GHz");
            $table->unsignedSmallInteger("wattage_w")->comment("Power consumption in Watts");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpu_specs');
    }
};
