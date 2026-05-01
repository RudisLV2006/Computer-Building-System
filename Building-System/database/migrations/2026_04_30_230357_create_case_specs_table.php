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
        Schema::create('case_specs', function (Blueprint $table) {
            $table->foreignId('product_id')->primary()->constrained()->onDelete('cascade');
            $table->string("manufacturer");
            $table->string("case_type");
            $table->unsignedSmallInteger("max_gpu_length_mm")->comment("Maximum length for gpu to fit inside case");
            $table->unsignedSmallInteger("max_cooler_height_mm")->comment("Maximum length for cpu cooler to fit inside case");
            $table->unsignedSmallInteger("max_psu_length_mm")->nullable();
            $table->unsignedSmallInteger("height_mm");
            $table->unsignedSmallInteger("length_mm");
            $table->unsignedSmallInteger("width_mm");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_specs');
    }
};
