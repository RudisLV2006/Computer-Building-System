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
        Schema::create('gpu_specs', function (Blueprint $table) {
            $table->foreignId('product_id')->primary()->constrained()->onDelete('cascade');
            $table->string("manufacturer");
            $table->string("chipset");
            $table->unsignedTinyInteger("memory");
            $table->unsignedSmallInteger("core_clock_mhz")->comment("Represent operation frequency");
            $table->unsignedTinyInteger("pcie_version")->comment("e.g. 4 = PCIe 4.0");
            $table->unsignedTinyInteger("pcie_lanes")->default(16);
            $table->unsignedSmallInteger("length")->comment("Check compatibility with case");
            $table->unsignedSmallInteger("wattage_w")->comment("Power consumption in Watts");
            $table->unsignedTinyInteger("pcie_8pin_count")->default(0);
            $table->unsignedTinyInteger("pcie_6pin_count")->default(0);
            $table->boolean("has_12vhpwr")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpu_specs');
    }
};
