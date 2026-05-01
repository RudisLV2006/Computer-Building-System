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
        Schema::create('psu_specs', function (Blueprint $table) {
            $table->foreignId('product_id')->primary()->constrained()->onDelete('cascade');
            $table->string("manufacturer");
            $table->string("psu_type");
            $table->unsignedSmallInteger("wattage_w")->comment("Power consumption in Watts");
            $table->unsignedSmallInteger("length")->comment("Check compatibility with case");
            $table->string("modular");
            $table->unsignedTinyInteger('atx_4pin_connectors')->default(0);
            $table->unsignedTinyInteger('eps_8pin_connectors')->default(0);
            $table->unsignedTinyInteger('pcie_16pin_12vhpwr_connectors')->default(0);
            $table->unsignedTinyInteger('pcie_12pin_connectors')->default(0);
            $table->unsignedTinyInteger('pcie_8pin_connectors')->default(0);
            $table->unsignedTinyInteger('pcie_6plus2pin_connectors')->default(0);
            $table->unsignedTinyInteger('pcie_6pin_connectors')->default(0);
            $table->unsignedTinyInteger('sata_connectors')->default(0);
            $table->unsignedTinyInteger('molex_4pin_connectors')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psu_specs');
    }
};
