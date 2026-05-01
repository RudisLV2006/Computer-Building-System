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
        Schema::create('storage_specs', function (Blueprint $table) {
            $table->foreignId('product_id')->primary()->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('capacity_gb');
            $table->string('type');       // SSD, HDD, NVMe
            $table->string('form_factor'); // 2.5", 3.5", M.2
            $table->string('interface');   // SATA, PCIe 3.0, PCIe 4.0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_specs');
    }
};
