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
        Schema::create('cpu_cooler_specs', function (Blueprint $table) {
            $table->id();
            $table->string("manufacturer");
            $table->unsignedSmallInteger("wattage_w")->comment("Power consumption in Watts");
            $table->unsignedSmallInteger("height_mm")->comment("Power consumption in Watts");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpu_cooler_specs');
    }
};
