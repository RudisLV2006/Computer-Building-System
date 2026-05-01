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
        Schema::table('motherboard_specs', function (Blueprint $table) {
            $table->string("memory_slots")->nullable();
            $table->string("pcie_version")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motherboard_specs', function (Blueprint $table) {
            $table->dropColumn('memory_slots');
            $table->dropColumn('pcie_version');
        });
    }
};
