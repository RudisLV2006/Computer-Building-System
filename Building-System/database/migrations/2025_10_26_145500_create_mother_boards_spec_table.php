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
        Schema::create('motherboard_specs', function (Blueprint $table) {
            $table->unsignedBigInteger("product_id");
            $table->primary('product_id');
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
        Schema::dropIfExists('motherboard_specs');
    }
};
