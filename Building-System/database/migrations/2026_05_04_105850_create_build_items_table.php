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
        Schema::create('build_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("build_id")->constrained()->onDelete('cascade');
            $table->foreignId("product_id")->constrained()->onDelete('cascade');
            $table->string("category");
            $table->unsignedTinyInteger("count");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('build_items');
    }
};
